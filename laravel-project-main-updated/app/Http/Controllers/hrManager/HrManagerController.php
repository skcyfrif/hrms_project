<?php

namespace App\Http\Controllers\hrManager;
use App\Models\User;
use App\Models\Employee;
use App\Models\Leave;
use App\Models\Leavebalance;
use App\Models\Subu;
use App\Models\Employeeattendance;
use App\Models\Apply;
use App\Models\Interview;
use App\Models\Holiday;
use App\Models\Payrolls;
use App\Models\Salary;
use App\Models\Expenseclaim;
use App\Models\LeaveRejection;
use App\Models\ClaimRejection;
use App\Models\Makepermanent;


use Carbon\Carbon;


use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HrManagerController extends Controller
{
    //
    public function HrmanagerDashboard()
    {
        return view('hr_manager.index');
    } //End mehtod

    public function HrmanagerDashboards()
{
    $user = Auth::user();
    $employee = $user->subu;
    $employyeData = Subu::where('user_id', $user->id)->first();
    $leaveBalanceData = LeaveBalance::where('employee_id', $employyeData->id)->first();
    $attendance = $employee->attendances()->latest()->first();
    $totalMembers = Subu::where('created_by', $user->id)->count();

    // Get today's attendance count
    $today = Carbon::today()->toDateString();
    $presentCount = Employeeattendance::whereDate('date', $today)
        ->where('status', 'Present') // Adjust based on how you track presence
        ->count();

        // $pendingLeaveCount = Leave::where('m_status', 'mpending')->count(); // Or use '0' if pending is stored as numeric
        $pendingLeaveCountemplyee = Leave::where('m_status', 'mpending')
                            ->whereHas('employeeleavestatusinrm', function($query) {
                                $query->where('user_role', 'user');
                            })->count();

        $pendingLeaveCountreportmanager = Leave::where('m_status', 'mpending')
                            ->whereHas('employeeleavestatusinrm', function($query) {
                                $query->where('user_role', 'reportmanager');
                            })->count();

    // 🆕 Count candidates in pipeline
    // $candidateCount = Interview::where('status', 'pipeline')->count();
    $candidateCount = Apply::where('status', '1')->count();
    $sheduledcandidateCount = Apply::where('status', '2')->count();
    // ✅ Add claim request count
    $pendingClaimCount = Expenseclaim::where('status', 'pending')
                        ->whereHas('subu', function($query) {
                            $query->where('user_role', 'user');
                        })->count();
    $pendingClaimCountrm = Expenseclaim::where('status', 'pending')
    ->whereHas('subu', function($query) {
        $query->where('user_role', 'reportmanager'); // or 'rm' based on your role naming
    })->count();
    // Interview
    return view('hr_manager.my_dashboard', compact('employee', 'attendance', 'leaveBalanceData', 'totalMembers', 'presentCount', 'candidateCount', 'sheduledcandidateCount', 'pendingClaimCount', 'pendingClaimCountrm', 'pendingLeaveCountemplyee', 'pendingLeaveCountreportmanager'));
}


    public function ManagerLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function ManagerProfile()
    {
        $id             = Auth::user()->id;
        $profileData    = User::find($id);

        return view('hr_Manager.manager_profile_view' , compact('profileData'));
    }

    public function ManagerProfileStore(Request $request)
    {
        $id             = Auth::user()->id;
        $data           = User::find($id);

        $data->username = $request->username;
        $data->name     = $request->name;
        $data->email    = $request->email;
        $data->phone    = $request->phone;
        $data->address  = $request->address;

        if($request->file('photo')){

            $file       = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename   = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data->photo = $filename;
        }

        $data->save();

        $notification = [
            'message'       => 'Admin profile updated successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->back()->with($notification);
    } //End method

    public function ManagerChangePassword()
    {
        $id             = Auth::user()->id;
        $profileData    = User::find($id);

        return view('hr_Manager.manager_change_password', compact('profileData'));
    }

    public function ManagerUpdatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        //Match the old password
        if(!Hash::check($request->old_password , Auth::user()->password)){

            $notification = [
                'message'       => 'Old password does not match',
                'alert-type'    => 'error'
            ];

            return back()->with($notification);
        }

        //Update the new password
        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = [
            'message'       => 'password change successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->back()->with($notification);
    }


public function EmployeeList()
{
    $sams = Subu::where('created_by', auth()->user()->id)
        ->whereHas('user', function ($query) {
            // Use whereIn to check for multiple roles
            $query->whereIn('role', ['user', 'reportmanager']);
        })
        ->latest()
        ->get();

    return view('hr_manager.employee_directory.employee_list', compact('sams'));
}

    public function AddEmployee()
    {
        $hasRecords = Subu::exists(); // true if any row exists
        return view('hr_manager.employee_directory.add_employee_list', [
            'hasRecords' => $hasRecords
        ]);
    }

    public function getReportManagers()
{
    // Get the logged-in HR manager
    $user = auth()->user();  // Assume that the logged-in user is the HR manager

    // Fetch the report managers associated with this HR manager
    // Assuming 'user_role' is the field to identify if someone is a report manager
    $reportManagers = Subu::where('created_by', $user->id)  // HR Manager's user_id
                          ->where('user_role', 'reportmanager')  // Only fetch report managers
                          ->get(['id', 'name']);  // Get id and name of the report managers

    // Return the list as JSON
    return response()->json([
        'reportManagers' => $reportManagers
    ]);
}



    public function StoreEmployee(Request $request)
    {
        // dd($request->all());
        $request->validate([
            // 'employee_id' => 'required',
            'name' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
            'email' => 'required',
            'phone_number' => 'required',
            'dob' => 'required',
            'gender' => 'required',

             // Contact Information


            'permanent_address_line1' => 'required',
            'permanent_address_line2' => 'required',
            'permanent_city' => 'required',
            'permanent_district' => 'required',
            'permanent_state' => 'required',
            'permanent_pin' => 'required',
            'current_address_line1' => 'required',
            'current_address_line2' => 'nullable',
            'current_city' => 'required',
            'current_district' => 'required',
            'current_state' => 'required',
            'current_pin' => 'required',


            'emergency_contact' => 'required',

               // Employment Details
            'designation' => 'required',
            'department' => 'required',
            'work_location' => 'required',
            'doj' => 'required',
            'employment_type' => 'required',
            'created_by' => 'required',

            // Bank Details
            'account_number' => 'required',
            'ifsc_code' => 'required',
            'bank_name' => 'required',
            'branch_name' => 'required',


            // Compensation Details
            'types' => 'required',
            'pay_cycle' => 'required',

            // stiend
            // 'stipend_amount' => 'required',
            // 'stipend_allowance' => 'required',
            // 'total_stipend_ammount' => 'required',

            //consolidated
            // 'consolidated_amount' => 'required',
            // 'consolidated_allowance' => 'required',
            // 'total_consolidated_ammount' => 'required',


            'total_leave_allowed' => 'required',
            'basic_salary' => 'required',
            'house_rent_allowance' => 'required',
            'conveyance_allowance' => 'required',
            'lunch_allowance' => 'required',
            'personal_pay' => 'required',
            'medical_allowance' => 'required',
            'other_allowance' => 'required',
            'leave_travel_allowance' => 'required',
            'total_ammount' => 'required',
            'professional_tax' => 'required',
            'esic' => 'required',
            'net_salary_payable' => 'required',

             // System Access
            'user_role' => 'required',
            'username' => 'required',
            'password' => 'required'
            // 'assigned_to' => $request->assigned_to, // Ensure this field is passed

        ]);
        $photoPath = null;
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $photoName = time() . '_' . $photo->getClientOriginalName(); // Generate a unique name
        $photoPath = 'photos/' . $photoName;
        $photo->move(public_path('photos'), $photoName); // Move file to public/resume
    }

    if (!empty($request->employee_id)) {
        // If user provides something like BOG002
        $prefix = strtoupper(preg_replace('/\d/', '', $request->employee_id));
        $manualNumber = intval(preg_replace('/\D/', '', $request->employee_id));
        $generatedEmployeeId = $prefix . str_pad($manualNumber, 3, '0', STR_PAD_LEFT);
    } else {
        // No input → find last record and increment
        $lastSub = Subu::orderBy('id', 'desc')->first();

        if ($lastSub) {
            $lastEmpId = $lastSub->employee_id;
            $prefix = preg_replace('/\d/', '', $lastEmpId);
            $lastNumber = intval(preg_replace('/\D/', '', $lastEmpId));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            $generatedEmployeeId = $prefix . $newNumber;
        } else {
            // First record in DB
            $prefix = 'EMP';
            $generatedEmployeeId = $prefix . '001';
        }
    }



        // Get the logged-in manager ID
    $createdBy = auth()->id();


        // dd($request->all());exit;
        $user = User::create([
            // 'employee_id'        => $request->employee_id,
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone_number,
            'role'   => $request->user_role,
            'username'    => $request->username,
            'password'    => Hash::make($request->password), // Hash the password
            'address'     => $request->permanent_address  // You can also use current_address if needed
        ]);
        $data = [
            // 'employee_id' => $request->employee_id,
            'employee_id' => $generatedEmployeeId,
            'user_id' => $user->id,
            'name' => $request->name,
            // 'photo' => $request->photo,
            'photo' => $photoPath,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'dob' => $request->dob,
            'gender' => $request->gender,

            // Contact Information
            'permanent_address_line1' => $request->permanent_address_line1,
            'permanent_address_line2' => $request->permanent_address_line2,
            'permanent_city' => $request->permanent_city,
            'permanent_district' => $request->permanent_district,
            'permanent_state' => $request->permanent_state,
            'permanent_pin' => $request->permanent_pin,
            'current_address_line1' => $request->current_address_line1,
            'current_address_line2' => $request->current_address_line2,
            'current_city' => $request->current_city,
            'current_district' => $request->current_district,
            'current_state' => $request->current_state,
            'current_pin' => $request->current_pin,

            'emergency_contact' => $request->emergency_contact,

            // Employment Details
            'designation' => $request->designation,
            'department' => $request->department,
            'work_location' => $request->work_location,
            'doj' => $request->doj,
            'employment_type' => $request->employment_type,

            // Conditionally set permanent_date
            'created_by' => $createdBy, // Automatically set created_by
            // 'created_by' => $request->created_by,

            // Bank Details
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,

            // Compensation Details
            'types' => $request->types,
            'pay_cycle' => $request->pay_cycle,
            'total_leave_allowed' => $request->total_leave_allowed,
            'basic_salary' => $request->basic_salary,
            'house_rent_allowance' => $request->house_rent_allowance,
            'conveyance_allowance' => $request->conveyance_allowance,
            'lunch_allowance' => $request->lunch_allowance,
            'personal_pay' => $request->personal_pay,
            'medical_allowance' => $request->medical_allowance,
            'other_allowance' => $request->other_allowance,
            'leave_travel_allowance' => $request->leave_travel_allowance,
            'total_ammount' => $request->total_ammount,
            'professional_tax' => $request->professional_tax,
            'esic' => $request->esic,
            'net_salary_payable' => $request->net_salary_payable,

            // System Access
            'user_role' => $request->user_role,
            'username' => $request->username,
            'password' => $request->password,
            'assigned_to' => $request->assigned_to, // Ensure this field is passed
        ];
// dd($data);exit;
        // Conditionally add 'permanent_date' if the user role is 'reportmanager'
        if ($request->user_role == 'reportmanager') {
            $data['permanent_date'] = now()->toDateString();
        }

        Subu::create($data);

        $notification = [
            'message' => 'Employee created successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('employee.list')->with($notification);
    }


    public function EditEmployee($id)
    {
        $emp = Subu::findOrFail($id);
        $reportManagers = Subu::where('user_role', 'reportmanager')->get();

        return view('hr_manager.employee_directory.edit_employee_list', compact('emp', 'reportManagers'));
    }



    public function UpdateEmployee(Request $request)
    {
        $pid = $request->id;
        $subu = Subu::findOrFail($pid);
        $user = User::findOrFail($subu->user_id);

        // Update the User record
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone_number,
        'role' => $request->user_role,
        'username' => $request->username,
        'password' => Hash::make($request->password), // Hash the password for security
        'address' => $request->permanent_address
    ]);

        Subu::findOrFail($pid)->update([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'photo' => $request->photo,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'dob' => $request->dob,
            'gender' => $request->gender,

            // Contact Information
            // 'permanent_address' => $request->permanent_address,

            'permanent_address_line1' => $request->permanent_address_line1,
            'permanent_address_line2' => $request->permanent_address_line2,
            'permanent_city' => $request->permanent_city,
            'permanent_district' => $request->permanent_district,
            'permanent_state' => $request->permanent_state,
            'permanent_pin' => $request->permanent_pin,
            'current_address_line1' => $request->current_address_line1,
            'current_address_line2' => $request->current_address_line2,
            'current_city' => $request->current_city,
            'current_district' => $request->current_district,
            'current_state' => $request->current_state,
            'current_pin' => $request->current_pin,


            // 'current_address' => $request->current_address,

            'emergency_contact' => $request->emergency_contact,
            // Employment Details
            'designation' => $request->designation,
            'department' => $request->department,
            'work_location' => $request->work_location,
            'doj' => $request->doj,
            'employment_type' => $request->employment_type,
            'created_by' => $request->created_by,
            // Bank Details
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            // Compensation Details
            'types' => $request->types,
            'pay_cycle' => $request->pay_cycle,

            // stiend
            // 'stipend_amount' => $request->stipend_amount,
            // 'stipend_allowance' => $request->stipend_allowance,
            // 'total_stipend_ammount' => $request->total_stipend_ammount,

            //consolidated
            // 'consolidated_amount' => $request->consolidated_amount,
            // 'consolidated_allowance' => $request->consolidated_allowance,
            // 'total_consolidated_ammount' => $request->total_consolidated_ammount,

            'total_leave_allowed' => $request->total_leave_allowed,
            'basic_salary' => $request->basic_salary,
            'house_rent_allowance' => $request->house_rent_allowance,
            'conveyance_allowance' => $request->conveyance_allowance,
            'lunch_allowance' => $request->lunch_allowance,
            'personal_pay' => $request->personal_pay,
            'medical_allowance' => $request->medical_allowance,
            'other_allowance' => $request->other_allowance,
            'leave_travel_allowance' => $request->leave_travel_allowance,
            'total_ammount' => $request->total_ammount,
            'professional_tax' => $request->professional_tax,
            'esic' => $request->esic,
            'net_salary_payable' => $request->net_salary_payable,

            // System Access

            'user_role' => $request->user_role,
            'username' => $request->username,
            'password' => $request->password,
            'assigned_to' => $request->assigned_to,
            // $emp->assigned_to = $request['assigned_to'];


        ]);

        $notification = [
            'message'       => 'Employee updated successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('employee.list')->with($notification);

    }

    // Delete an employee
    public function DeleteEmployee($id)
    {
        // Delete the employee by ID
        Subu::findOrFail($id)->delete();

        $notification = [
            'message' => 'Employee deleted successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('employee.list')->with($notification);
    }

    public function EmployeeView($id)
    {
        $test = Subu::findOrFail($id);
        return view('hr_manager.employee_directory.view_employee_lists', compact('test'));

    }

///////////////////////////////////////leave approval status of employees///////////////////////////////////////

public function LeaveApprovalStatus()
    {
        // Fetch salary records where the user_role is either 'user' or 'reportmanager' and created by the logged-in manager
    $approvals = Leave::whereHas('employeeleavestatusinhrm', function ($query) {
        $query->whereIn('user_role', ['user'])  // Check for both 'user' and 'reportmanager'
              ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
    })->latest()->get();

    return view('hr_manager.employee.leave_approval.leaveapproval', compact('approvals'));
    }

public function approveLeave($id)
        {
            $leave = Leave::findOrFail($id);
            if ($leave->m_status == 'mreject' || $leave->m_status == 'mpending') {
                $employeeId = $leave->employee_id;
                $year = \Carbon\Carbon::parse($leave->leave_from)->year;

                $leaveBalance = LeaveBalance::where('employee_id', $employeeId)
                    ->where('year', $year)
                    ->first();

                if ($leaveBalance) {
                    // Deduct PL again
                    if ($leave->PL > 0) {
                        $leaveBalance->pl_balance -= $leave->PL;
                        if ($leaveBalance->pl_balance < 0) {
                            $leaveBalance->pl_balance = 0;
                        }
                    }

                    // Deduct SL again
                    if ($leave->SL > 0) {
                        $leaveBalance->sl_balance -= $leave->SL;
                        if ($leaveBalance->sl_balance < 0) {
                            $leaveBalance->sl_balance = 0;
                        }
                    }

                    // Add LOP again
                    if ($leave->LOP > 0) {
                        $leaveBalance->lop_days += $leave->LOP;
                    }

                    $leaveBalance->save();
                }
            }
            $leave->m_status = 'mapprove';
            $leave->save();
            return redirect()->back()->with('success', 'Leave Approved Successfully');
        }

public function rejectLeave($id)
        {
            $leave = Leave::findOrFail($id);
            $leave->m_status = 'mreject';
            $leave->save();
            return redirect()->back()->with('error', 'Leave Rejected');
        }

        // leave approval status of employees when reject open a dialouge box

        public function rejectLeaveSubmit(Request $request)
        {
            $request->validate([
                'leave_id' => 'required',
                'employee_id' => 'required',
                'reason' => 'required|string|max:255',
                'rejected_by' => 'required',
            ]);

            // Update Leave status
            $leave = Leave::findOrFail($request->leave_id);

            if ($leave->m_status !== 'mreject') {

                $employeeId = $leave->employee_id;
                $year = \Carbon\Carbon::parse($leave->leave_from)->year;

                $leaveBalance = LeaveBalance::where('employee_id', $employeeId)
                    ->where('year', $year)
                    ->first();

                if ($leaveBalance) {
                    // Restore PL
                    if ($leave->PL > 0) {
                        $leaveBalance->pl_balance += $leave->PL;
                    }

                    // Restore SL
                    if ($leave->SL > 0) {
                        $leaveBalance->sl_balance += $leave->SL;
                    }

                    // Reverse LOP
                    if ($leave->LOP > 0) {
                        $leaveBalance->lop_days -= $leave->LOP;
                        if ($leaveBalance->lop_days < 0) {
                            $leaveBalance->lop_days = 0;
                        }
                    }

                    $leaveBalance->save();
                }

                // Update leave status
                $leave->m_status = 'mreject';
                $leave->save();

                // Save rejection reason
                LeaveRejection::create([
                    'leave_id' => $request->leave_id,
                    'employee_id' => $request->employee_id,
                    'rejected_by' => auth()->user()->id,
                    'status' => 'mreject',
                    'reason' => $request->reason,
                ]);
            }

            return redirect()->back()->with('error', 'Leave Rejected Successfully');
        }

public function LeaveApprovalStatusOfRm()
{
    // Fetch salary records where the user_role is either 'user' or 'reportmanager' and created by the logged-in manager
$approvals = Leave::whereHas('rmleavestatusinhrm', function ($query) {
    $query->whereIn('user_role', ['reportmanager'])  // Check for both 'user' and 'reportmanager'
          ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
})->latest()->get();

return view('hr_manager.rm.leave_approval.leave_approval', compact('approvals'));
}

public function approveLeaveOfRm($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->m_status = 'mapprove';
        $leave->save();
        return redirect()->back()->with('success', 'Leave Approved Successfully');
    }

public function rejectLeaveOfRm($id)
    {
        $leave = Leave::findOrFail($id);
        $leave->m_status = 'mreject';
        $leave->save();
        return redirect()->back()->with('error', 'Leave Rejected');
    }







// claim approval to employee
public function ClaimApprovalStatusofUser()
    {
        // Fetch salary records where the user_role is either 'user' or 'reportmanager' and created by the logged-in manager
    $claims = Expenseclaim::whereHas('employeeclaimstatusinhrm', function ($query) {
        $query->whereIn('user_role', ['user'])  // Check for both 'user' and 'reportmanager'
              ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
    })->latest()->get();

    return view('hr_manager.employee.claim_approval.claim_approval', compact('claims'));
    }

    // claim approval of reporting manager
public function ClaimApprovalStatustoRm()
{
    $claims = Expenseclaim::whereHas('employeeclaimstatusinhrm', function ($query) {
    $query->whereIn('user_role', ['reportmanager'])  // Check for both 'user' and 'reportmanager'
          ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
          })->latest()->get();

return view('hr_manager.rm.claim_approval.rm_claim_status', compact('claims'));
}

public function approveClaim($id)
        {
            $claim = Expenseclaim::findOrFail($id);
            $claim->status = 'approve';
            $claim->save();
            return redirect()->back()->with('success', 'Claim Approved Successfully');
        }

public function rejectClaim($id)
        {
            $claim = Expenseclaim::findOrFail($id);
            $claim->status = 'reject';
            $claim->save();
            return redirect()->back()->with('error', 'Claim Rejected');
        }


public function rejectClaimSubmit(Request $request)
    {
    // Validate the request
    $request->validate([
        'claim_id' => 'required',  // Ensure the claim exists
        'employee_id' => 'required',  // Ensure the employee exists
        'reason' => 'required|string|max:255',  // Reason is required
        'rejected_by' => 'required',  // Ensure the rejecting user is valid
    ]);

    // Find the claim and update its status to 'reject'
    $claim = Expenseclaim::findOrFail($request->claim_id);
    $claim->status = 'reject';
    $claim->save();

    // Insert rejection record into ClaimRejections table
    ClaimRejection::create([
        'claim_id' => $request->claim_id,
        'employee_id' => $request->employee_id,
        'rejected_by' => auth()->user()->id,
        'status' => 'reject',
        'reason' => $request->reason,
    ]);

    return redirect()->back()->with('error', 'Claim Rejected Successfully');
    }





// salary approval of employees
public function SalaryApproval()
{
    $user = auth()->user();

    // Get employees managed by the logged-in HR manager
    $employees = Subu::where('created_by', $user->id)->get();

    // Calculate the number of days in the current month
    $totalDaysInMonth = \Carbon\Carbon::now()->daysInMonth;

    foreach ($employees as $employee) {
        // Get attendance data
        $attendance = Employeeattendance::where('employee_id', $employee->id)
            ->whereMonth('date', \Carbon\Carbon::now()->month)
            ->get();

        // Get leave data
        $leaves = Leave::where('employee_id', $employee->id)
            ->whereMonth('leave_from', \Carbon\Carbon::now()->month)
            ->get();

        // Calculate total present days
        $presentDays = $attendance->where('status', 'Present')->count();

        // Calculate total leave days
        $totalLeaves = $leaves->sum('total_days');

        // Calculate total holidays (assuming weekends as holidays)
        $holidays = 6;

        // Add calculated data to the employee object
        $employee->total_days = $totalDaysInMonth;
        $employee->present_days = $presentDays;
        $employee->total_leaves = $totalLeaves;
        $employee->total_holidays = $holidays;
        $employee->working_days = $totalDaysInMonth - $holidays;
        $employee->paid_leave = $leaves->where('status', 'Approved')->sum('total_days');
        $employee->unpaid_leave = $leaves->where('status', 'Rejected')->sum('total_days');
    }

    return view('hr_manager.pending_approval.salary_approval', compact('employees'));
}


    public function AddSalaryApproval()
{
    $salaries = Subu::all();
    $sima = Employee::all();  // Fetch data from the Employee table
    return view('hr_manager.pending_approval.add_salary_approval', compact('salaries', 'sima'));
}


public function AttendanceStatusinHrm(Request $request)
{
    // Get the logged-in user's ID
    $managerId = auth()->user()->id;

    // Start the query for attendance records
    $attendQuery = Employeeattendance::whereHas('employeeattendancestatusinhrm', function ($query) use ($managerId) {
        $query->whereIn('user_role', ['user', 'reportmanager'])  // Check for both 'user' and 'reportmanager'
              ->where('created_by', $managerId);  // Filter by logged-in manager's ID
    });

    // Apply date filter if the 'date' parameter is provided
    if ($request->has('date') && $request->date) {
        $attendQuery->whereDate('date', $request->date); // Filter by selected date
    }

    // Execute the query and get the results
    $attend = $attendQuery->latest()->get();

    // Pass the attendance data to the view
    return view('hr_manager.hrm.attendance_status_of_all_employees.attendance_status_in_hrm', compact('attend'));

}



    public function approveAttendance($id)
    {
        $attendance = Employeeattendance::findOrFail($id);
        $attendance->manager_approval_status = 'Present';
        $attendance->approve_by_manager = auth()->user()->id;
        $attendance->save();

        return redirect()->back()->with('success', 'Attendance marked as Present.');
    }

    public function absentAttendance($id)
    {
        $attendance = Employeeattendance::findOrFail($id);
        $attendance->manager_approval_status = 'Absent';
        $attendance->approve_by_manager = auth()->user()->id;
        $attendance->save();

        return redirect()->back()->with('success', 'Attendance marked as Absent.');
    }




//////////////////////////////////////////////////HR Manager Management//////////////////////////////////////////////////
// 1. Add Attendance
public function HrmAttendanceList(Request $request)
{
    $user = auth()->user();
    $employee = Subu::where('user_id', $user->id)->first();

    $query = Employeeattendance::where('employee_id', $employee->id);

    // Filter by month and year
    if ($request->filled('month') && $request->filled('year')) {
        $query->whereMonth('date', $request->month)
              ->whereYear('date', $request->year);
    }

    $atens = $query->latest()->get();

    $currentYear = now()->year;
    $years = range(2019, $currentYear); // for year dropdown

    return view('hr_manager.hrm.hrm_attendace.hrm_attendance_list', compact('atens', 'employee', 'years', 'currentYear'));
}



    public function AddHrmAttendance()
    {
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();
        // return view('employee.employeeattendancerecord.add_employee_attendance_list');
    return view('hr_manager.hrm.hrm_attendace.add_hrm_attendance_list', compact('user', 'employee'));

    } //End method


    public function StoreHrmAttendance(Request $request)
    {
    // Validation
    $request->validate([
        'employee_id' => 'required',
        'name' => 'required',
        'date' => 'required',
        'check_in_time' => 'required',
        'status' => 'required',
        // 'remarks' => 'required'
    ]);

    $existingAttendance = Employeeattendance::where('employee_id', $request->employee_id)
        ->where('date', $request->date)
        ->first();

    if ($existingAttendance) {
        $notification = [
            'message' => 'Attendance for this date already exists!',
            'alert-type' => 'error'
        ];

        return redirect()->back()->with($notification);
    }
    // Insert employee data
    Employeeattendance::create([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'date' => $request->date,
        'check_in_time' => $request->check_in_time,
        'status' => $request->status,
        // 'remarks' => $request->remarks,
    ]);

    $notification = [
        'message' => 'Attendance created successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('hrm.attendance')->with($notification);
    }

    public function EditHrmAttendance($id)
    {
    $aten = Employeeattendance::findOrFail($id);
    return view('hr_manager.hrm.hrm_attendace.edit_hrm_attendance_list', compact('aten'));
    }

    public function UpdateHrmAttendance(Request $request, $id)
{
    Employeeattendance::findOrFail($id)->update([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'date' => $request->date,
        'check_in_time' => $request->check_in_time,
        'status' => $request->status,
        // 'remarks' => $request->remarks,
    ]);

    $notification = [
        'message' => 'Attendance updated successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('hrm.attendance')->with($notification);
}
    public function DeleteHrmAttendance($id)
    {
        Employeeattendance::findOrFail($id)->delete();

        $notification = [
            'message'       => 'attaindance deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('hrm.attendance')->with($notification);
    } //End method



// ======================================================================================
     // Check leave balance of HRM
// ======================================================================================

public function CheckLeaveofHrm()
    {
    return view('hr_manager.hrm.leave_management.leavebalance.check_leave_balance');
    }


// ======================================================================================
     // Apply leave of HRM
// ======================================================================================

    // 2. Apply Leave

    public function HrmlistLeave()
    {
        $user = auth()->user();
        $employye = Subu::where('user_id', $user->id)->first();
        $tests = Leave::where('employee_id', $employye->id)->latest()->get();

    // return view('hr_manager.hrmanager_leave.leave_list');
    return view('hr_manager.hrm.leave_management.apply_leave.leave_list' , compact('tests', 'employye'));

    }

    public function AddHrmLeave()
    {
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();

    return view('hr_manager.hrm.leave_management.apply_leave.add_leave', compact('user', 'employee'));

    } //End method

    public function StoreHrmLeave(Request $request)
    {
    // Validation
    $request->validate([
        'employee_id' => 'required',
        'name' => 'required',
        'designation' => 'required',
        'department' => 'required',
        'leave_from' => 'required',
        'leave_to' => 'required',
        'total_days' => 'required',
        'reason' => 'required',
        'upload' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        // 'upload' => 'required'
    ]);

    $uploadPath = null;
if ($request->hasFile('upload')) {
    $upload = $request->file('upload');
    $uploadName = time() . '_' . $upload->getClientOriginalName(); // Generate a unique name
    $uploadPath = 'leaveupload/' . $uploadName;
    $upload->move(public_path('leaveupload'), $uploadName); // Move file to public/leaveupload
}
    // Insert employee data
    Leave::create([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'designation' => $request->designation,
        'department' => $request->department,
        'leave_from' => $request->leave_from,
        'leave_to' => $request->leave_to,
        'total_days' => $request->total_days,
        'reason' => $request->reason,
        'upload' => $uploadPath,
    ]);

    $notification = [
        'message' => 'leave apply successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('hrmanagerleave.list')->with($notification);
    }

    public function EdiHrmLeave($id)
    {
    $test = Leave::findOrFail($id);
    return view('hr_manager.hrm.leave_management.apply_leave.edit_leave', compact('test'));
    }

    public function UpdateHrmLeave(Request $request, $id)
{
    Leave::findOrFail($id)->update([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'designation' => $request->designation,
        'department' => $request->department,
        'leave_from' => $request->leave_from,
        'leave_to' => $request->leave_to,
        'total_days' => $request->total_days,
        'reason' => $request->reason,
        'upload' => $request->upload,
    ]);

    $notification = [
        'message' => 'leave updated successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('hrmanagerleave.list')->with($notification);
}

public function DeleteHrmLeave($id)
    {
        Leave::findOrFail($id)->delete();

        $notification = [
            'message'       => 'leave deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('hrmanagerleave.list')->with($notification);
    } //End method


    // 3. HR Manager Manager Leave Status


    public function HrmLeaveStatus()
{
    $user = auth()->user();
    $employye = Subu::where('user_id', $user->id)->first();
    $approvals = Leave::with('leavestatusofhrm')->where('employee_id', $employye->id)->latest()->get();

    return view('hr_manager.hrm.leave_management.leave_status.leave_status', compact('approvals'));

}


// ================================================================================
                    // Expense Claim Form of HRM or apply claim
    // ================================================================================
    public function ListClaimForm()
    {
        $user = auth()->user();
        $employyee = Subu::where('user_id', $user->id)->first();
        $claims = Expenseclaim::where('employee_id', $employyee->id)->latest()->get();

        // $claims = Expenseclaim::latest()->get();
        return view('hr_manager.hrm.claim_form.apply_claim.expense_claim_form_list' , compact('claims', 'employyee'));

    }
    public function AddClaimForm()
    {
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();
        return view('hr_manager.hrm.claim_form.apply_claim.add_expense_claim_form', compact('user', 'employee'));

    } //End method

    public function StoreclaimForm(Request $request)
{
    // Validation
    $request->validate([
        'employee_id' => 'required',
        'name' => 'required',
        'department' => 'required',
        'claim_date' => 'required|date',
        'expense_date' => 'required|date|before_or_equal:claim_date',
        'expense_category' => 'required',
        'expense_description' => 'required',
        'amount' => 'required|numeric',
        // 'receipt_attached' => 'required',
        'hrhead_approval' => 'required',
        'approval_date' => 'nullable|date',
        'reimbursed' => 'required',
        // 'processed_date' => 'nullable|date',
    ], [
        'expense_date.before_or_equal' => 'The expense date cannot be after the claim date.',
        'amount.numeric' => 'The amount must be a valid number.',
    ]);

    // Insert employee data
    Expenseclaim::create($request->all());

    return redirect()->route('claim.formhrm')->with([
        'message' => 'Claim applied successfully',
        'alert-type' => 'success'
    ]);
}

public function EditClaimForm($id)
{
    $claim = Expenseclaim::findOrFail($id);
    return view('hr_manager.hrm.claim_form.apply_claim.edit_expense_claim_form', compact('claim'));
}

public function UpdateClaimForm(Request $request, $id)
{
    // Validation
    $request->validate([
        'employee_id' => 'required',
        'name' => 'required',
        'department' => 'required',
        'claim_date' => 'required|date',
        'expense_date' => 'required|date|before_or_equal:claim_date',
        'expense_category' => 'required',
        'expense_description' => 'required',
        'amount' => 'required|numeric',
        // 'receipt_attached' => 'required',
        'hrhead_approval' => 'required',
        'approval_date' => 'nullable|date',
        'reimbursed' => 'required',
        // 'processed_date' => 'nullable|date',
    ], [
        'expense_date.before_or_equal' => 'The expense date cannot be after the claim date.',
        'amount.numeric' => 'The amount must be a valid number.',
    ]);

    Expenseclaim::findOrFail($id)->update($request->all());

    return redirect()->route('claim.formhrm')->with([
        'message' => 'Claim updated successfully',
        'alert-type' => 'success'
    ]);
}

    public function DeleteClaimForm($id)
    {
        Expenseclaim::findOrFail($id)->delete();

        $notification = [
            'message'       => 'claim deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('claim.formhrm')->with($notification);
    } //End method



    /////////////////////////////track claim approval status of hrmanager/////////////////////////////

    public function trackClaimStatusofHrm()
    {
        $user = auth()->user();
        $employye = Subu::where('user_id', $user->id)->first();
        $approvals = Expenseclaim::with(['claimstatusofemployee', 'latestRejectionReason'])
                        ->where('employee_id', $employye->id)
                        ->latest()
                        ->get();

        return view('hr_manager.hrm.claim_form.claim_status.claim_approval_status', compact('approvals'));
    }

// carrer portal
//apply
public function ApplyListing()
    {
        $tests = Apply::latest()->get();
        return view('hr_manager.carrer_portal.apply.job_apply_list', compact('tests'));
    // return view('admin.employee_management.employee_directory.employee_list', compact('tests'));
    }
public function AddApply()
{
return view('hr_manager.carrer_portal.apply.add_job_apply');
}
public function StoreApply(Request $request)
{

    $request->validate([
        'name' => 'required',
        'email' => 'required',
        'mobile' => 'required',
        'applied_for' => 'required',
        'applied_date' => 'required',
        'resume' => 'required|file|mimes:pdf,doc,docx|max:2048', // Validate resume file
    ]);

    // Handle file upload
    $resumePath = null;
    if ($request->hasFile('resume')) {
        $resume = $request->file('resume');
        $resumeName = time() . '_' . $resume->getClientOriginalName(); // Generate a unique name
        $resumePath = 'resume/' . $resumeName;
        $resume->move(public_path('resume'), $resumeName); // Move file to public/resume
    }

    Apply::create([
        'name' => $request->name,
        'email' => $request->email,
        'mobile' => $request->mobile,
        'applied_for' => $request->applied_for,
        'applied_date' => $request->applied_date,
        'resume' => $resumePath,
        'status' => $request->status ?? '1', // Default to "1" if not provided
    ]);
    $notification = [
        'message' => 'Employee applied successfully',
        'alert-type' => 'success',
    ];

    return redirect()->route('apply.list')->with($notification);
}


public function EditApply($id)
{
    $aten = Apply::findOrFail($id);

    return view('hr_manager.carrer_portal.apply.edit_job_apply', compact('aten'));
}

public function UpdateApply(Request $request)
{

    $pid = $request->id;
    // $subu = Apply::findOrFail($pid);
    // $user = User::findOrFail($subu->user_id);

    Apply::findOrFail($pid)->update([
        'name' => $request->name,
        'email' => $request->email,
        'mobile' => $request->mobile,
        'applied_for' => $request->applied_for,
        'applied_date' => $request->applied_date,
        'resume' => $request->resume,
    ]);

    $notification = [
        'message'       => 'Employee applied successfully',
        'alert-type'    => 'success'
    ];

    return redirect()->route('apply.list')->with($notification);

}

// Delete an employee
public function DeleteApply($id)
{
    // Delete the employee by ID
    Apply::findOrFail($id)->delete();

    $notification = [
        'message' => 'Employee deleted successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('apply.list')->with($notification);
}



// candidate details
public function CandidateListing()
{
    // $tests = Apply::latest()->get();
    $tests = Apply::where('status', '1')->latest()->get();

    return view('hr_manager.carrer_portal.interview_list.interview_listing', compact('tests'));
}

public function scheduleInterview($id)
{
    $candidate = Apply::findOrFail($id);

    return view('hr_manager.carrer_portal.interview_list.schedule_interview', compact('candidate'));
}
public function storeInterview(Request $request)
{
    $request->validate([
        'candidate_id' => 'required|exists:applies,id',
        'interview_date' => 'required|date',
        'interview_time' => 'required',
        'location' => 'required|string|max:255',
    ]);

    // Store interview data (you can create an Interview model for better structure)
    Interview::create([
        'candidate_id' => $request->candidate_id,
        'interview_date' => $request->interview_date,
        'interview_time' => $request->interview_time,
        'location' => $request->location,
    ]);
    Apply::where('id', $request->candidate_id)->update(['status' => '2']);
    $notification = [
        'message' => 'Interview scheduled successfully!',
        'alert-type' => 'success',
    ];

    return redirect()->route('interview.list')->with($notification);
}


public function EditScheduled($id)
    {
        $aten = Apply::findOrFail($id);
        $interview = Interview::where('candidate_id', $id)->first();

        return view('hr_manager.carrer_portal.interview_list.edit_schedule_interview', compact('aten', 'interview'));
    }

    public function UpdateScheduled(Request $request)
{
    $request->validate([
        'candidate_id' => 'required|exists:applies,id',
        'interview_date' => 'required|date',
        'interview_time' => 'required',
        'location' => 'required|string|max:255',
    ]);

    // Update the interview details
    Interview::where('candidate_id', $request->candidate_id)->update([
        'interview_date' => $request->new_date,
        'interview_time' => $request->new_time,
        'location' => $request->new_location,
    ]);

    $notification = [
        'message' => 'Interview rescheduled successfully!',
        'alert-type' => 'success',
    ];

    return redirect()->route('interview.list')->with($notification);
}

public function InterviewScheduledListing()
{
    $interviews = Interview::with(['candidate' => function($query) {
        $query->where('status', '2');
    }])->latest()->get();

    return view('hr_manager.carrer_portal.interview_shedule.interview_shedule', compact('interviews'));
}

public function shortlistCandidate($id)
{
    // Find the candidate by ID and update the status to 3 (Shortlisted)
    $candidate = Apply::findOrFail($id);
    $candidate->status = '3';
    $candidate->save();

    // Success message
    $notification = [
        'message' => 'Candidate shortlisted successfully!',
        'alert-type' => 'success',
    ];

    // Redirect to the candidate listing page with the success message
    return redirect()->route('interview.list')->with($notification);
}

public function holdCandidate($id)
{
    // Find the candidate by ID and update the status to 3 (Shortlisted)
    $candidate = Apply::findOrFail($id);
    $candidate->status = '4';
    $candidate->save();

    // Success message
    $notification = [
        'message' => 'Candidate hold successfully!',
        'alert-type' => 'success',
    ];

    // Redirect to the candidate listing page with the success message
    return redirect()->route('interview.list')->with($notification);
}
public function rejectCandidate($id)
{
    // Find the candidate by ID and update the status to 3 (Shortlisted)
    $candidate = Apply::findOrFail($id);
    $candidate->status = '5';
    $candidate->save();

    // Success message
    $notification = [
        'message' => 'Candidate reject successfully!',
        'alert-type' => 'success',
    ];

    // Redirect to the candidate listing page with the success message
    return redirect()->route('interview.list')->with($notification);
}
public function RejectCandidatesfromHoldPage($id)
{
    // Find the candidate by ID and update the status to 3 (Shortlisted)
    $candidate = Apply::findOrFail($id);
    $candidate->status = '5';
    $candidate->save();

    // Success message
    $notification = [
        'message' => 'Candidate reject successfully!',
        'alert-type' => 'success',
    ];

    // Redirect to the candidate listing page with the success message
    return redirect()->route('interview.list')->with($notification);
}


public function ShortListing()
{
    $tests = Apply::where('status', '3')->latest()->get();
return view('hr_manager.carrer_portal.shortlisting.shortlisting', compact('tests'));
}
public function HoldListing()
{
    $tests = Apply::where('status', '4')->latest()->get();

return view('hr_manager.carrer_portal.holding.holding', compact('tests'));
}
public function RejectListing()
{
    $tests = Apply::where('status', '5')->latest()->get();

return view('hr_manager.carrer_portal.rejected.rejected', compact('tests'));
}

public function viewOfferLetterForIntern($id)
    {
        $candidate = Apply::findOrFail($id); // Fetch the employee by ID
        return view('hr_manager.carrer_portal.offerletter.offer_letter_intern', compact('candidate')); // Pass data to view
    }

public function viewOfferLetterForFullTime($id)
{
    $candidate = Apply::findOrFail($id); // Fetch the employee by ID
    return view('hr_manager.carrer_portal.offerletter.offer_letter_fulltime', compact('candidate')); // Pass data to view
}

public function ReSchedule($id)
{
    // Find the candidate by ID
    $candidate = Apply::find($id);

    // Check if candidate exists
    if (!$candidate) {
        return redirect()->back()->with('message', 'Candidate not found.');
    }

    // Update the candidate's status to rescheduled (you can customize the status value)
    $candidate->status = 2; // Assuming '2' means 'Scheduled'
    $candidate->save();

    // Redirect back with a success message
    return redirect()->back()->with('message', 'Candidate rescheduled successfully.');
}

/////////////// Report Manager ///////////////

public function ReportManagerList()
{
    $sams = Subu::where('created_by', auth()->user()->id)
        ->whereHas('user', function ($query) {
            $query->where('role', 'reportmanager');
        })
        ->latest()
        ->get();

    return view('hr_manager.reportmanager.report_manager_list', compact('sams'));
}



    public function AddReportManager()
    {

    return view('hr_manager.reportmanager.add_report_manager_list');
    }

    public function StoreReportManager(Request $request)
    {

        $request->validate([
            'employee_id' => 'required',
            'name' => 'required',
            // 'photo' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
            'email' => 'required',
            'phone_number' => 'required',
            'dob' => 'required',
            'gender' => 'required',

             // Contact Information
            'permanent_address' => 'required',
            'current_address' => 'required',
            'emergency_contact' => 'required',

               // Employment Details
            'designation' => 'required',
            'department' => 'required',
            'work_location' => 'required',
            'doj' => 'required',
            'employment_type' => 'required',
            'created_by' => 'required',

            // Bank Details
            'account_number' => 'required',
            'ifsc_code' => 'required',
            'bank_name' => 'required',
            'branch_name' => 'required',


            // Compensation Details
            'types' => 'required',
            'pay_cycle' => 'required',

            // stiend
            // 'stipend_amount' => 'required',
            // 'stipend_allowance' => 'required',
            // 'total_stipend_ammount' => 'required',

            //consolidated
            // 'consolidated_amount' => 'required',
            // 'consolidated_allowance' => 'required',
            // 'total_consolidated_ammount' => 'required',


            'total_leave_allowed' => 'required',
            'basic_salary' => 'required',
            'house_rent_allowance' => 'required',
            'conveyance_allowance' => 'required',
            'lunch_allowance' => 'required',
            'personal_pay' => 'required',
            'medical_allowance' => 'required',
            'other_allowance' => 'required',
            'leave_travel_allowance' => 'required',
            'total_ammount' => 'required',
            'professional_tax' => 'required',
            'esic' => 'required',
            'net_salary_payable' => 'required',

             // System Access
            'user_role' => 'required',
            'username' => 'required',
            'password' => 'required'

        ]);
        $photoPath = null;
    if ($request->hasFile('photo')) {
        $photo = $request->file('photo');
        $photoName = time() . '_' . $photo->getClientOriginalName(); // Generate a unique name
        $photoPath = 'photos/' . $photoName;
        $photo->move(public_path('photos'), $photoName); // Move file to public/resume
    }

        // Get the logged-in manager ID
    $createdBy = auth()->id();


        // dd($request->all());exit;
        $user = User::create([
            // 'employee_id'        => $request->employee_id,
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone_number,
            'role'   => $request->user_role,
            'username'    => $request->username,
            'password'    => Hash::make($request->password), // Hash the password
            'address'     => $request->permanent_address  // You can also use current_address if needed
        ]);
        Subu::create([
            'employee_id' => $request->employee_id,
            'user_id' => $user->id,
            'name' => $request->name,
            // 'photo' => $request->photo,
            'photo' => $photoPath,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'dob' => $request->dob,
            'gender' => $request->gender,


            // Contact Information
            'permanent_address' => $request->permanent_address,
            'current_address' => $request->current_address,
            'emergency_contact' => $request->emergency_contact,

             // Employment Details
            'designation' => $request->designation,
            'department' => $request->department,
            'work_location' => $request->work_location,
            'doj' => $request->doj,
            'employment_type' => $request->employment_type,
            'created_by' => $createdBy, // Automatically set created_by
            // 'created_by' => $request->created_by,

            // Bank Details
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,

            // Compensation Details
            'types' => $request->types,
            'pay_cycle' => $request->pay_cycle,
            'total_leave_allowed' => $request->total_leave_allowed,
            'basic_salary' => $request->basic_salary,
            'house_rent_allowance' => $request->house_rent_allowance,
            'conveyance_allowance' => $request->conveyance_allowance,
            'lunch_allowance' => $request->lunch_allowance,
            'personal_pay' => $request->personal_pay,
            'medical_allowance' => $request->medical_allowance,
            'other_allowance' => $request->other_allowance,
            'leave_travel_allowance' => $request->leave_travel_allowance,
            'total_ammount' => $request->total_ammount,
            'professional_tax' => $request->professional_tax,
            'esic' => $request->esic,
            'net_salary_payable' => $request->net_salary_payable,

             // System Access
            'user_role' => $request->user_role,
            'username' => $request->username,
            'password' => $request->password

        ]);
        $notification = [
            'message' => 'Employee created successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('reportmanager.list')->with($notification);
    }


public function EditReportManager($id)
    {
        $emp = Subu::findOrFail($id);

        return view('hr_manager.reportmanager.edit_report_manager_list', compact('emp'));
    }



    public function UpdateReportManager(Request $request)
    {

        $pid = $request->id;
        $subu = Subu::findOrFail($pid);
        $user = User::findOrFail($subu->user_id);

        // Update the User record
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone_number,
        'role' => $request->user_role,
        'username' => $request->username,
        'password' => Hash::make($request->password), // Hash the password for security
        'address' => $request->permanent_address
    ]);

        Subu::findOrFail($pid)->update([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'photo' => $request->photo,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'dob' => $request->dob,
            'gender' => $request->gender,

            // Contact Information
            'permanent_address' => $request->permanent_address,
            'current_address' => $request->current_address,
            'emergency_contact' => $request->emergency_contact,
            // Employment Details
            'designation' => $request->designation,
            'department' => $request->department,
            'work_location' => $request->work_location,
            'doj' => $request->doj,
            'employment_type' => $request->employment_type,
            'created_by' => $request->created_by,
            // Bank Details
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            // Compensation Details
            'types' => $request->types,
            'pay_cycle' => $request->pay_cycle,

            // stiend
            // 'stipend_amount' => $request->stipend_amount,
            // 'stipend_allowance' => $request->stipend_allowance,
            // 'total_stipend_ammount' => $request->total_stipend_ammount,

            //consolidated
            // 'consolidated_amount' => $request->consolidated_amount,
            // 'consolidated_allowance' => $request->consolidated_allowance,
            // 'total_consolidated_ammount' => $request->total_consolidated_ammount,

            'total_leave_allowed' => $request->total_leave_allowed,
            'basic_salary' => $request->basic_salary,
            'house_rent_allowance' => $request->house_rent_allowance,
            'conveyance_allowance' => $request->conveyance_allowance,
            'lunch_allowance' => $request->lunch_allowance,
            'personal_pay' => $request->personal_pay,
            'medical_allowance' => $request->medical_allowance,
            'other_allowance' => $request->other_allowance,
            'leave_travel_allowance' => $request->leave_travel_allowance,
            'total_ammount' => $request->total_ammount,
            'professional_tax' => $request->professional_tax,
            'esic' => $request->esic,
            'net_salary_payable' => $request->net_salary_payable,

            // System Access

            'user_role' => $request->user_role,
            'username' => $request->username,
            'password' => $request->password


        ]);

        $notification = [
            'message'       => 'Employee updated successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('reportmanager.list')->with($notification);

    }

    // Delete an employee
    public function DeleteReportManager($id)
    {
        // Delete the employee by ID
        Subu::findOrFail($id)->delete();

        $notification = [
            'message' => 'Employee deleted successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('reportmanager.list')->with($notification);
    }

    public function ReportManagerView($id)
    {
        $test = Subu::findOrFail($id);
        return view('hr_manager.reportmanager.view_report_manager_lists', compact('test'));

    }
    public function accrueLeave()
{
    $employees = Subu::where('employment_type', 'permanent')->get();
        $currentYear = now()->year;
        $currentMonth = now()->month;

        foreach ($employees as $employee) {
            if (!$employee->permanent_date) continue;

            $permanentDate = Carbon::parse($employee->permanent_date);

            // Skip if permanent date is in the future
            if ($permanentDate->isFuture()) continue;

            // Calculate prorated months
            $monthsRemaining = ($permanentDate->year == $currentYear)
                ? 12 - $permanentDate->month + 1
                : 12;

            $monthlyEntitlement = 1.5;
            $proRatedEntitlement = round($monthsRemaining * $monthlyEntitlement, 1);

            $leaveBalance = LeaveBalance::where('employee_id', $employee->id)
                ->where('year', $currentYear)
                ->first();

            if (!$leaveBalance) {
                LeaveBalance::create([
                    'employee_id' => $employee->id,
                    'year' => $currentYear,
                    'annual_leave_entitlement' => $proRatedEntitlement,
                    'total_leave_balance' => $monthlyEntitlement,
                    'pl_balance' => 1,
                    'sl_balance' => 0.5,
                    'lop_days' => 0,
                    'updated_at' => now(),
                ]);
                // $this->info("Created leave for: {$employee->id}");
            } else {
                if ($leaveBalance->updated_at->month !== $currentMonth) {
                    $leaveBalance->pl_balance = min($leaveBalance->pl_balance + 1, 15);
                    $leaveBalance->sl_balance = min($leaveBalance->sl_balance + 0.5, 3);
                    $leaveBalance->total_leave_balance = min(
                        $leaveBalance->total_leave_balance + $monthlyEntitlement,
                        $leaveBalance->annual_leave_entitlement
                    );
                    $leaveBalance->updated_at = now();
                    $leaveBalance->save();
                    // $this->info("Updated leave for: {$employee->id}");
                }
            }
        }

        return redirect()->back()->with('success', 'update leave successfully.');
}




public function generatePayroll($year_month)
{
    $carbonDate = Carbon::parse($year_month);
    $year = $carbonDate->year;
    $month = $carbonDate->format('m');

    $employees = Subu::where('created_by', auth()->user()->id)
        ->whereHas('user', function ($query) {
            $query->whereIn('role', ['user', 'head', 'manager', 'reportmanager']);
        })
        ->latest()
        ->get();

    $payrollData = [];

    foreach ($employees as $employee) {
        $total_days = $carbonDate->daysInMonth;

        $holidays = Holiday::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->count();

        $sundays = collect(range(1, $total_days))->filter(function ($day) use ($carbonDate) {
            return Carbon::parse($carbonDate->format('Y-m') . '-' . $day)->isSunday();
        })->count();

        $working_days = $total_days - ($holidays + $sundays);

        // ✅ Fetch only APPROVED leave records
        $approvedLeaves = Leave::where('employee_id', $employee->id)
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->where('rm_status', 'rmapprove')
            ->where('m_status', 'mapprove')
            ->get();

        // ✅ Sum leave days safely
        $pl_days = $approvedLeaves->sum(function ($leave) {
            return (int) $leave->PL;
        });

        $sl_days = $approvedLeaves->sum(function ($leave) {
            return (int) $leave->SL;
        });

        $lop_days = $approvedLeaves->sum(function ($leave) {
            return (int) $leave->LOP;
        });

        // $present_days = $total_days - $lop_days;
        $attendance_present_days = Employeeattendance::where('employee_id', $employee->id)
    ->whereMonth('date', $month)
    ->whereYear('date', $year)
    ->where('status', 'Present')
    ->count();

$present_days = $attendance_present_days + $pl_days + $sl_days;

        $daily_salary = $employee->basic_salary / $total_days;
        $total_salary = $present_days * $daily_salary;

        $payrollData[] = [
            'employee_id' => $employee->id,
            'month' => $month,
            'year' => $year,
            'total_days' => $total_days,
            'working_days' => $working_days,
            'holidays' => $holidays,
            'sundays' => $sundays,
            'days_present' => $present_days,
            'lop_days' => $lop_days,
            'paid_leave_days' => $pl_days,
            'sick_leave_days' => $sl_days,
            'gross_salary' => $total_salary,
            'created_at' => now(),
            'updated_at' => now()
        ];
    }

    foreach ($payrollData as $data) {
        $existingPayroll = Payrolls::where('employee_id', $data['employee_id'])
            ->where('year', $data['year'])
            ->where('month', $data['month'])
            ->first();

        if ($existingPayroll) {
            $existingPayroll->update([
                'total_days' => $data['total_days'],
                'working_days' => $data['working_days'],
                'holidays' => $data['holidays'],
                'sundays' => $data['sundays'],
                'days_present' => $data['days_present'],
                'lop_days' => $data['lop_days'],
                'paid_leave_days' => $data['paid_leave_days'],
                'sick_leave_days' => $data['sick_leave_days'],
                'gross_salary' => $data['gross_salary'],
                'updated_at' => now(),
            ]);
        } else {
            Payrolls::create($data);
        }
    }

    return redirect()->back()->with('success', 'Payroll generated successfully.');
}





    public function PayrollList()
{
    // Fetch payrolls where the user_role is either 'user' or 'reportmanager' and created by the logged-in manager
    $payrolls = Payrolls::whereHas('payrool', function ($query) {
        $query->whereIn('user_role', ['user', 'reportmanager'])  // Check for both 'user' and 'reportmanager'
              ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
    })->latest()->get();

    return view('hr_manager.muster_roll.payroll', compact('payrolls'));
}


/////////////////////////////////////////////// salary structure of employees /////////////////////////////////////////////////////


public function EmpSalaryLists()
{
    // Fetch salary records where the user_role is either 'user' or 'reportmanager' and created by the logged-in manager
    $sals = Salary::whereHas('employeesalarystructureinhrm', function ($query) {
        $query->whereIn('user_role', ['user', 'reportmanager'])  // Check for both 'user' and 'reportmanager'
              ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
    })->latest()->get();

    return view('hr_manager.salary_structure.salary_list', compact('sals'));
}


 public function EmpAddSalaries()
    {
        // Get the logged-in user's (HR Manager's) ID
        $hrManagerId = auth()->user()->id;

        // Fetch only the employees created by this HR manager
        $salaries = Subu::where('created_by', $hrManagerId)->get();

        // Pass the filtered employees to the view
        return view('hr_manager.salary_structure.add_salary', compact('salaries'));
    }


public function getallEmployeeDetails($employee_id)
    {
        // ✅ Corrected Relationship Name (Use 'payroll', NOT 'payrolls')
        $employee = Subu::with('payroll')->where('id', $employee_id)->first();

        if ($employee) {
            return response()->json([
                'success' => true,
                'data' => $employee
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Employee not found'
        ]);
    }



public function EmpStoreSalaries(Request $request)
 {

     $request->validate([
         'employee_id' => 'required',
         'name' => 'required',
         'department' => 'required',
         'doj' => 'required',
         'gender' => 'required',
         'grade' => 'required',
         'account_number' => 'required',
         'ifsc_code' => 'required',
         'bank_name' => 'required',
         'branch_name' => 'required',
         'basic_salary' => 'required',
         'house_rent_allowance' => 'required',
         'conveyance_allowance' => 'required',
         'lunch_allowance' => 'required',
         'personal_pay' => 'required',
         'medical_allowance' => 'required',
         'other_allowance' => 'required',
         'leave_travel_allowance' => 'required',
        //  'total_ammount' => 'required',
         'professional_tax' => 'required',
         'esic' => 'required',
         'net_salary_payables' => 'required',
         'lop_days' => 'required',
         'standard_days' => 'required',
         'salary_for_the_month' => 'required',
         'no_of_working_day' => 'required',
         'total_leave_taken' => 'required',
         'remarks' => 'required'

     ]);

    //   dd($request->all());

     // Create employee record
     Salary::create([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'department' => $request->department,
        'doj' => $request->doj,
        'gender' => $request->gender,
        'grade' => $request->grade,
        'account_number' => $request->account_number,
        'ifsc_code' => $request->ifsc_code,
        'bank_name' => $request->bank_name,
        'branch_name' => $request->branch_name,
        'basic_salary' => $request->basic_salary,
        'house_rent_allowance' => $request->house_rent_allowance,
        'conveyance_allowance' => $request->conveyance_allowance,
        'lunch_allowance' => $request->lunch_allowance,
        'personal_pay' => $request->personal_pay,
        'medical_allowance' => $request->medical_allowance,
        'other_allowance' => $request->other_allowance,
        'leave_travel_allowance' => $request->leave_travel_allowance,
        // 'total_ammount' => $request->total_ammount,
        'professional_tax' => $request->professional_tax,
        'esic' => $request->esic,
        'net_salary_payables' => $request->net_salary_payables,
        'lop_days' => $request->lop_days,
        'standard_days' => $request->standard_days,
        'salary_for_the_month' => $request->salary_for_the_month,
        'no_of_working_day' => $request->no_of_working_day,
        'total_leave_taken' => $request->total_leave_taken,
        'remarks' => $request->remarks


     ]);


     $notification = [
         'message' => 'Employee created successfully',
         'alert-type' => 'success',
     ];

     return redirect()->route('empsalaries.lists')->with($notification);
 }


 public function EmpEditSalaries($id)
 {
     $sal = Salary::findOrFail($id);

     return view('hr_manager.salary_structure.edit_salary', compact('sal'));
 }



 public function EmpupdateSalaries(Request $request)
 {

     $pid = $request->id;

     Salary::findOrFail($pid)->update([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'department' => $request->department,
        'doj' => $request->doj,
        'gender' => $request->gender,
        'grade' => $request->grade,
        'account_number' => $request->account_number,
        'ifsc_code' => $request->ifsc_code,
        'bank_name' => $request->bank_name,
        'branch_name' => $request->branch_name,
        'basic_salary' => $request->basic_salary,
        'house_rent_allowance' => $request->house_rent_allowance,
        'conveyance_allowance' => $request->conveyance_allowance,
        'lunch_allowance' => $request->lunch_allowance,
        'personal_pay' => $request->personal_pay,
        'medical_allowance' => $request->medical_allowance,
        'other_allowance' => $request->other_allowance,
        'leave_travel_allowance' => $request->leave_travel_allowance,
        // 'total_ammount' => $request->total_ammount,
        'professional_tax' => $request->professional_tax,
        'esic' => $request->esic,
        'net_salary_payables' => $request->net_salary_payables,
        'lop_days' => $request->lop_days,
        'standard_days' => $request->standard_days,
        'salary_for_the_month' => $request->salary_for_the_month,
        'no_of_working_day' => $request->no_of_working_day,
        'total_leave_taken' => $request->total_leave_taken,
        'remarks' => $request->remarks


     ]);

     $notification = [
         'message'       => 'salary updated successfully',
         'alert-type'    => 'success'
     ];

     return redirect()->route('empsalaries.lists')->with($notification);

 }

 // Delete an employee
 public function EmpDeleteSalaries($id)
 {
     // Delete the employee by ID
     Salary::findOrFail($id)->delete();

     $notification = [
         'message' => 'Employee deleted successfully',
         'alert-type' => 'success'
     ];

     return redirect()->route('empsalaries.lists')->with($notification);
 }
 public function EmpSalaryView($id)
 {
     // Now the $id is passed correctly as a parameter
     $employee = Salary::findOrFail($id); // Fetch the employee based on the $id
     $payslip = Subu::findOrFail($employee->employee_id); // Fetch the payslip based on employee's id

     // Return the view with the data
     return view('hr_manager.salary_structure.download_salary_slip', compact('employee', 'payslip'));
 }
 public function makePermanent($employeeId)
 {
     $employee = Subu::find($employeeId);
     if ($employee) {
         $employee->employment_type = 'permanent';
         $employee->save();

         // Delete old leave balance if exists
         LeaveBalance::where('employee_id', $employee->id)->delete();

         // Create new leave balance for permanent employees
         LeaveBalance::create([
             'employee_id' => $employee->id,
             'year' => now()->year,
             'annual_leave_entitlement' => 18,
             'pl_balance' => 1.5,
             'sl_balance' => 3,
             'lop_days' => 0,
         ]);

         return back()->with('success', 'Employee is now permanent with a new leave balance.');
     }

     return back()->with('error', 'Employee not found.');
 }

// ======================================================================================
     // Approve permanent of employees
// ======================================================================================

 public function ApprovePermanentstatusinHRM()
 {
     // Fetch all make-permanent requests with employee details
     $requests = Makepermanent::with('employee')->get();
     return view('hr_manager.pending_approval.approval_request.permanent_approval', compact('requests'));
    //  hr_manager.approval_request.approval_permanent
 }


public function updatePermanentStatusinHRM(Request $request, $id)
{
    $action = $request->input('action'); // mapprove or mreject
    $reason = $request->input('rejection_reason'); // optional, only for rejection

    $requestEntry = Makepermanent::findOrFail($id);
    $employee_id = $requestEntry->employee_id;
    $requestEntry->mstatus = $action;

    if ($action === 'mreject') {
        $requestEntry->m_rejection_reason = $reason;
    } else {
        $requestEntry->m_rejection_reason = null; // Clear old reason if approving again
    }

    if ($action === 'mreject') {
        $requestEntry->m_rejection_reason = $reason;
        Subu::where('id', $employee_id)->update([
            'permanent_date' => null,
            'employment_type' => 'non_permanent',
        ]);
    } else {
        $requestEntry->m_rejection_reason = null; // Clear old reason if approving again

        // ✅ Update permanent_date in subus table

        Subu::where('id', $employee_id)->update([
            'permanent_date' => Carbon::today(),
            'employment_type' => 'permanent',
        ]);


    }
    $requestEntry->save();

    return back()->with('success', 'Request has been ' . ucfirst($action) . '.');
}



/////////////////////////////////////update request/////////////////////////////////////

public function UpdateRequest()
 {
     $employee = Auth::user()->subu()->first();

     return view('hr_manager.hrm.request.update_request', compact('employee'));
 }


 public function submitByHrm(Request $request)
 {
     $type = $request->input('request_type');
     $user = auth()->user();
     $employee = Subu::where('user_id', $user->id)->first();
     switch ($type) {
         case 'salary-increment':
             $request->validate([
                 'current_salary' => 'required|numeric',
                 'expected_increment' => 'required|numeric',
             ]);
             break;

         case 'make-permanent':
             $request->validate([
                 'check_in_status' => 'required|in:on', // checkbox returns "on" if checked
             ]);

             // $employee = Auth::guard('employee')->user(); // assuming employee is logged in

             Makepermanent::create([
                 'employee_id' => $employee->id,
                 'user_id' => $user->id,
                 'request_type' => $type,
                 'check_in_status' => $request->has('check_in_status'), // will be true/false
             ]);

             return back()->with('success', 'Make Permanent request submitted successfully!');
             break;

         case 'account-details-update':
             $request->validate([
                 'bank_name' => 'required|string',
                 'branch_name' => 'required|string',
                 'account_number' => 'required|string',
                 'ifsc_code' => 'required|string',
             ]);
             $employee->update([
                 'bank_name' => $request->input('bank_name'),
                 'branch_name' => $request->input('branch_name'),
                 'account_number' => $request->input('account_number'),
                 'ifsc_code' => $request->input('ifsc_code'),
             ]);

             return back()->with('success', 'Account details updated successfully!');

             break;
             case 'update-profile':
                 // $request->validate([
                 //     'bank_name' => 'required|string',
                 //     'branch_name' => 'required|string',
                 //     'account_number' => 'required|string',
                 //     'ifsc_code' => 'required|string',
                 // ]);
                 $employee->update([
                     'name' => $request->input('name'),
                     'email' => $request->input('email'),
                     'phone_number' => $request->input('phone_number'),
                     'current_address_line1' => $request->input('current_address_line1'),
                     'current_address_line2' => $request->input('current_address_line2'),
                     'current_city' => $request->input('current_city'),
                     'current_state' => $request->input('current_state'),
                     'current_district' => $request->input('current_district'),
                     'current_pin' => $request->input('current_pin'),
                 ]);

                 return back()->with('success', 'Account details updated successfully!');

                 break;

         case 'any-issue':
             $request->validate([
                 'issue_description' => 'required|string',
             ]);
             break;
     }

     // You can store the other requests similarly...
     return back()->with('success', 'Form submitted successfully!');
 }

}
