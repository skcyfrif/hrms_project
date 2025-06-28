<?php

namespace App\Http\Controllers\hr;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\HrHead;
use App\Models\HrManager;
use App\Models\Subu;
use App\Models\Employeeattendance;
use App\Models\ProfileUpdateRequest;
use App\Models\AccountUpdateRequest;
use App\Models\Leave;
use App\Models\Leavebalance;
use App\Models\Salary;
use App\Models\Employee;
use App\Models\Mypayslip;
use App\Models\Expenseclaim;
use App\Models\LeaveRejection;
use App\Models\ClaimRejection;
use App\Models\Payrolls;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Models\Termination;
use App\Mail\TerminationMail;





use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;





use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class HrController extends Controller
{

    //
    public function HrheadDashboard()
    {
        return view('hr_head.index');
    } //End mehtod


    public function HrheadDashboards()
    {
        // Get the logged-in user
        $user = Auth::user();


        // Get the related employee (Subu) for the logged-in user
        $employee = $user->subu; // Assuming the relationship is hasOne
        $employyeData = Subu::where('user_id', $user->id)->first();
        $leaveBalanceData = LeaveBalance::where('employee_id', $employyeData->id)->first();
        // $totalMembers = Subu::where('created_by', $user->id)->count();
        $totalHrManagers = Subu::where('user_role', 'manager')->where('created_by', $user->id)->get();
        $totalEmployees = Subu::whereIn('created_by', $totalHrManagers->pluck('user_id'))->whereIn('user_role', ['user', 'reportmanager'])->count();
        $totalMembers = $totalHrManagers->count() + $totalEmployees;

        // Get today’s attendance for the logged-in HR Head
            $today = Carbon::today()->toDateString();
            $attendances = Employeeattendance::where('employee_id', $employee->id)
                            ->whereDate('date', $today)
                            ->first();

        $today = Carbon::today()->toDateString();
        $presentCount = Employeeattendance::whereDate('date', $today)
                        ->where('status', 'Present') // Adjust based on how you track presence
                        ->count();

        $pendingLeaveCountemplyee = Leave::where('hr_status', 'hrpending')
                                    ->whereHas('employeeleavestatusinrm', function($query) {
                                        $query->where('user_role', 'manager');
                                    })->count();

        $pendingClaimCount = Expenseclaim::where('status', 'pending')
                            ->whereHas('subu', function($query) {
                                $query->where('user_role', 'manager');
                            })->count();
        // Now you can access the attendances of the employee
        $attendance = $employee->attendances()->latest()->first(); // Get the latest attendance

        // You can also fetch the leave balance and other related data as needed
        $leaveBalance = $employee->leaveBalances()->latest()->first();

        // Return the data to the view
        return view('hr_head.my_dashboard', compact('employee', 'attendances', 'attendance', 'leaveBalance', 'pendingClaimCount', 'leaveBalanceData', 'totalMembers', 'presentCount', 'pendingLeaveCountemplyee'));
    }


    public function HrheadLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function HrheadProfile()
    {
        $id             = Auth::user()->id;
        $profileData    = User::find($id);

        return view('hr_head.hrhead_profile_view' , compact('profileData'));
    }

    public function HrheadProfileStore(Request $request)
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

    public function HrheadChangePassword()
    {
        $id             = Auth::user()->id;
        $profileData    = User::find($id);

        return view('hr_head.hrhead_change_password', compact('profileData'));
    }

    public function HrheadUpdatePassword(Request $request)
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


                // Hr manager

    public function HrmanagerList()
{
    // Fetch employees and managers added by the logged-in HR head
    $managers = Subu::where('created_by', auth()->user()->id)->latest()->get();

    return view('hr_head.create_employee.add_employee.employee_list', compact('managers'));
}



    public function AddHrManager()
    {
        $hasRecords = Subu::exists(); // true if any row exists
        return view('hr_head.create_employee.add_employee.add_employee', [
            'hasRecords' => $hasRecords
        ]);
    }


    public function StoreHrManager(Request $request)
    {

        $request->validate([
            // 'employee_id' => 'required',
            'name' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
            'email' => 'required|email|max:255',
            'phone_number' => 'required|digits:10',
            'dob' => 'required|date|before:today',
            'gender' => 'required|in:male,female,other',


             // Contact Information

            'permanent_address_line1' => 'required|string|max:255',
            'permanent_address_line2' => 'required|string|max:255',
            'permanent_city' => 'required|string|max:100',
            'permanent_district' => 'required|string|max:100',
            'permanent_state' => 'required|string|max:100',
            'permanent_pin' => 'required|digits:6',

            'current_address_line1' => 'required|string|max:255',
            'current_address_line2' => 'nullable|string|max:255',
            'current_city' => 'required|string|max:100',
            'current_district' => 'required|string|max:100',
            'current_state' => 'required|string|max:100',
            'current_pin' => 'required|digits:6',

            'emergency_contact' => 'required|digits:10',


               // Employment Details
            'designation' => 'required|string|max:100',
            'department' => 'required|string|max:100',
            'work_location' => 'required|string|max:100',
            'doj' => 'required',
            'employment_type' => 'required',
            'created_by' => 'required',

            // Bank Details
            'account_number' => 'required|numeric|digits_between:9,18',
            'ifsc_code'      => 'required|regex:/^[A-Z]{4}0[A-Z0-9]{6}$/i',
            'bank_name'      => 'required|string|max:100',
            'branch_name'    => 'required|string|max:100',


            // Compensation Details
            'types' => 'required',
            'pay_cycle' => 'required',
            'total_leave_allowed'       => 'required|numeric|min:0',
            'basic_salary'              => 'required|numeric|min:0',
            'house_rent_allowance'      => 'required|numeric|min:0',
            'conveyance_allowance'      => 'required|numeric|min:0',
            'lunch_allowance'           => 'required|numeric|min:0',
            'personal_pay'              => 'required|numeric|min:0',
            'medical_allowance'         => 'required|numeric|min:0',
            'other_allowance'           => 'required|numeric|min:0',
            'leave_travel_allowance'    => 'required|numeric|min:0',
            'total_ammount'             => 'required|numeric|min:0',
            'professional_tax'          => 'required|numeric|min:0',
            'esic'                      => 'required|numeric|min:0',
            'net_salary_payable'        => 'required|numeric|min:0',
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

        // Get the logged-in HR ID
    $createdBy = auth()->id();

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
            // 'employee_id' => $request->employee_id,
            'employee_id' => $generatedEmployeeId,
            'user_id' => $user->id,
            'name' => $request->name,

            'photo' => $photoPath,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'dob' => $request->dob,
            'gender' => $request->gender,



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
            'permanent_date' => now()->toDateString(),
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

        return redirect()->route('hrmanager.list')->with($notification);
    }
    public function EditHrManager($id)
    {
        $manager = Subu::findOrFail($id);

        return view('hr_head.create_employee.add_employee.edit_employee', compact('manager'));
    }



    public function UpdateHrManager(Request $request)
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

    // Update the Subu record
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
            // 'current_address' => $request->current_address,
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
            'created_by' => $request->created_by,

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
            'message'       => 'hr manager updated successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('hrmanager.list')->with($notification);

    }

    // Delete an employee
    public function DeleteHrManager($id)
    {
        // Delete the employee by ID
        Subu::findOrFail($id)->delete();

        $notification = [
            'message' => 'hr manager deleted successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('hrmanager.list')->with($notification);
    }

    public function HrManagerView($id)
    {
        $test = Subu::findOrFail($id);
        return view('hr_head.create_employee.view_employee.view_employee_list', compact('test'));
    }


    public function viewsOfferLetter($id)
    {
        $employee = Subu::findOrFail($id); // Fetch the employee by ID
        return view('hr_head.create_employee.appointment_letter.appointment_letter', compact('employee')); // Pass data to view
    }
    public function viewAllEmployees($managerId)
{
    // Get the logged-in HR Head's ID
    $hrHeadId = auth()->user()->id;

    // Check if the manager belongs to the logged-in HR Head
    $manager = Subu::where('id', $managerId)
        ->where('created_by', $hrHeadId)
        ->first();

    if (!$manager) {
        return redirect()->back()->with('error', 'Manager not found or unauthorized access.');
    }

    // Fetch all employees created by this manager
    $employees = Subu::where('created_by', $manager->user_id)->get();

    return view('hr_head.create_employee.view_all_employee.view_all_employees', compact('employees', 'manager'));
}

/////////////////// salary structure //////////////////



public function HrmSalaryLists()
{
    // Fetch salary records where the user_role is either 'user' or 'reportmanager' and created by the logged-in manager
    $sals = Salary::whereHas('employeesalarystructureinhrm', function ($query) {
        $query->whereIn('user_role', ['manager'])  // Check for both 'user' and 'reportmanager'
              ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
    })->latest()->get();

    return view('hr_head.payroll_management.salary_structure.salary_list', compact('sals'));
}




public function HrmAddSalaries()
    {
        // Get the logged-in user's (HR Manager's) ID
        $hrManagerId = auth()->user()->id;

        // Fetch only the employees created by this HR manager
        $salaries = Subu::where('created_by', $hrManagerId)->get();

        // Pass the filtered employees to the view
        return view('hr_head.payroll_management.salary_structure.add_salary', compact('salaries'));
    }


    public function HrmStoreSalaries(Request $request)
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
        $employee = Salary::latest()->first();
        $payslip = Subu::findOrFail($employee->employee_id);
        Mail::to($payslip->email)->send(new ContactMail($employee, $payslip));
        return redirect()->route('hrmsalaries.lists')->with($notification);
    }



    public function HrmEditSalaries($id)
    {
        $sal = Salary::findOrFail($id);

        return view('hr_head.payroll_management.salary_structure.edit_salary', compact('sal'));
    }



    public function HrmupdateSalaries(Request $request)
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

        return redirect()->route('hrmsalaries.lists')->with($notification);

    }

    // Delete an employee
    public function HrmDeleteSalaries($id)
    {
        // Delete the employee by ID
        Salary::findOrFail($id)->delete();

        $notification = [
            'message' => 'Salary deleted successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('hrmsalaries.lists')->with($notification);
    }
    public function HrmSalaryView($id)
    {
        // Now the $id is passed correctly as a parameter
        $employee = Salary::findOrFail($id); // Fetch the employee based on the $id
        $payslip = Subu::findOrFail($employee->employee_id); // Fetch the payslip based on employee's id

        // Return the view with the data
        return view('hr_head.payroll_management.salary_structure.view_salary_slip', compact('employee', 'payslip'));
    }






///////////// view pay slip ////////////////

public function PayslipPageHr()
{
    // Get the years from the current year back to 2009
    $years = range(date('Y'), 2009);

    // Define the months array
    $months = [
        '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
        '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
        '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
    ];

    // Get the authenticated user
    $user = auth()->user();

    // Find the employee details for the logged-in user
    $employee = Subu::where('user_id', $user->id)->first();

    // Ensure $employee is found before passing it
    if (!$employee) {
        return redirect()->back()->with('error', 'hr  record not found.');
    }

    return view('hr_head.hrhead.PayrollandCompensation.hr_payslips_list', compact('years', 'months', 'employee'));
}

public function HrPayslipView(Request $request)
{
    $user = auth()->user();

    $employee = Subu::where('user_id', $user->id)->first();


    if (!$employee) {
        return response()->json(['error' => 'Hr not found'], 404);
    }


    $year = $request->input('year', now()->year);
    $month = $request->input('month', now()->format('m'));

    $payslip = Salary::where('employee_id', $employee->id)
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->first();

    if (!$payslip) {
        return response()->json(['error' => 'Payslip not found for the selected month'], 404);
    }

    return view('hr_head.hrhead.PayrollandCompensation.view_hr_payslip', compact('payslip'));
}













// pay slips
public function PayslipLists()
    {
//         //
        $pays = Mypayslip::latest()->get();

        return view('hr_head.payroll_management.payslip_structure.payslip_list' , compact('pays'));

    }


public function AddPayslips()
    {
        $abcd = Subu::all();
        $rama = Employee::all();
        $sitaa = HrManager::all();



        return view('hr_head.payroll_management.payslip_structure.add_payslip_list', compact('abcd', 'rama', 'sitaa'));
    }


public function StorePayslips(Request $request)
    {

        $request->validate([
            'employee_id' => 'required',
            'name' => 'required',
            'month' => 'required',
            'year' => 'required',
            'grade' => 'required',
            'lop_days' => 'required',
            'refund_days' => 'required',
            'standard_days' => 'required',
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
            'advance' => 'required',
            'net_salary_payable' => 'required'

        ]);


        // Insert payslip data
        Mypayslip::create([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'month' => $request->month,
            'year' => $request->year,
            'grade' => $request->grade,
            'lop_days' => $request->lop_days,
            'refund_days' => $request->refund_days,
            'standard_days' => $request->standard_days,
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
            'advance' => $request->advance,
            'net_salary_payable' => $request->net_salary_payable


        ]);
        $notification = [
            'message' => 'payslip created successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('mypayslip.lists')->with($notification);
    }


public function EditPayslip($id)
    {
        $pay = Mypayslip::findOrFail($id);

        return view('hr_head.payroll_management.payslip_structure.edit_payslip_list', compact('pay'));
    }



public function UpdatePayslips(Request $request)
    {

        $pid = $request->id;

        Mypayslip::findOrFail($pid)->update([
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'month' => $request->month,
            'year' => $request->year,
            'grade' => $request->grade,
            'lop_days' => $request->lop_days,
            'refund_days' => $request->refund_days,
            'standard_days' => $request->standard_days,
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
            'advance' => $request->advance,
            'net_salary_payable' => $request->net_salary_payable


        ]);

        $notification = [
            'message'       => 'Payslip updated successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('mypayslip.lists')->with($notification);

    }

// Delete an employee
public function DeletePayslips($id)
    {
        // Delete the employee by ID
        Mypayslip::findOrFail($id)->delete();

        $notification = [
            'message' => 'payslip deleted successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('mypayslip.lists')->with($notification);
    }
public function DownloadPayslips($id)
    {
        // Fetch the payslip record using the ID
        $employee = Mypayslip::findOrFail($id);

        // Fetch the corresponding employee details using employee_id
        $payslip = Subu::findOrFail($employee->employee_id);

        // Pass both payslip and employee data to the view
        return view('hr_head.payroll_management.payslip_structure.employee_payslip_download', compact('employee', 'payslip'));

    }

///////////////////////attendances of hr head///////////////////
public function HrHeadAttendanceList(Request $request)
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
        return view('hr_head.hrhead.hr_head_attendace.hr_head_attendance_list' , compact('atens', 'employee', 'years', 'currentYear'));
    }
    public function AddHrHeadAttendance()
    {
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();
    return view('hr_head.hrhead.hr_head_attendace.add_hr_head_attendance_list', compact('user', 'employee'));

    }





    public function StoreHrHeadAttendance(Request $request)
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


// ✅ Step 2: Check if date falls within an approved leave
    $onLeave = Leave::where('employee_id', $request->employee_id)
        ->whereDate('leave_from', '<=', $request->date)
        ->whereDate('leave_to', '>=', $request->date)
        ->where('admin_status', 'adminapprove')
        ->exists();

    if ($onLeave) {
        return redirect()->back()->with([
            'message' => 'Cannot mark attendance: This date falls within an approved leave period.',
            'alert-type' => 'error'
        ]);
    }


    // Insert employee data
    Employeeattendance::create([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'date' => $request->date,
        'check_in_time' => $request->check_in_time,
        'status' => $request->status,
        'remarks' => $request->remarks,
    ]);

    $notification = [
        'message' => 'Attendance created successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('hrhead.attendance')->with($notification);
    }

    public function EditHrHeadAttendance($id)
    {
    $aten = Employeeattendance::findOrFail($id);
    return view('hr_head.hrhead.hr_head_attendace.edit_hr_head_attendance_list', compact('aten'));
    }

    public function UpdateHrHeadAttendance(Request $request, $id)
{
    Employeeattendance::findOrFail($id)->update([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'date' => $request->date,
        'check_in_time' => $request->check_in_time,
        'status' => $request->status,
        'remarks' => $request->remarks,
    ]);

    $notification = [
        'message' => 'Attendance updated successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('hrhead.attendance')->with($notification);
}
    public function DeleteHrHeadAttendance($id)
    {
        Employeeattendance::findOrFail($id)->delete();

        $notification = [
            'message'       => 'attaindance deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('hrhead.attendance')->with($notification);
    } //End method


// ======================================================================================
     // Check leave balance of HRHead
// ======================================================================================



public function CheckLeaveofHrHead()
    {
        $user = Auth::user();

        $employee = Subu::with(['leaveBalances', 'leave'])->where('user_id', $user->id)->first();
    // dd($employee->toArray());


        if (!$employee) {
            return redirect()->back()->with('error', 'Employee not found!');
        }

        // Get current year
        $currentYear = date('Y');

        // Fetch the leave balance record for the current year
        $leaveBalance = $employee->leaveBalances->where('year', $currentYear)->first();
        $totalleaveTillYet = $employee->leaveBalances->where('year', $currentYear)->sum('total_leave_balance');

        $totalleaveTakenPL = $employee->leave ?$employee->leave
        ->where('employee_id', $employee->id)
        ->sum('PL') : 0;

        $totalleaveTakenSL = $employee->leave ? $employee->leave
        ->where('employee_id', $employee->id)
        ->sum('SL') : 0;


        $totalleaveTakenLOP = $employee->leave ? $employee->leave->where('employee_id', $employee->id)->sum('LOP') : 0;
        // Calculate total leave days from payroll records for the current year
        $totalLopDays = $employee->payrolls->where('year', $currentYear)->sum('lop_days');

        return view('hr_head.hrhead.leave.leavebalance.check_leave_balance', compact(
            'employee',
            'leaveBalance',
            'totalLopDays',
            'totalleaveTillYet',
            'totalleaveTakenPL',
            'totalleaveTakenSL',
            'totalleaveTakenLOP'
        ));
    }





//////////////////Apply Leave of hrhead//////////////////

public function HrHeadlistLeave()
{
        $user = auth()->user();
        $employye = Subu::where('user_id', $user->id)->first();
        $tests = Leave::where('employee_id', $employye->id)->latest()->get();

return view('hr_head.hrhead.leave.apply_leave.leave_list' , compact('tests', 'employye'));

}

public function AddHrHeadLeave()
{
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();


return view('hr_head.hrhead.leave.apply_leave.add_leave', compact('user', 'employee'));

} //End method

public function StoreHrHeadLeave(Request $request)
{
// Validate input
$request->validate([
    'employee_id' => 'required|exists:subus,id',
    'name' => 'required',
    'designation' => 'required',
    'department' => 'required',
    'leave_from' => 'required|date',
    'leave_to' => 'required|date|after_or_equal:leave_from',
    'total_days' => 'required|numeric|min:1',
    'reason' => 'required|in:PL,SL,LOP',
    'remarks' => 'nullable',
    'upload' => 'nullable|file',
]);


// ✅ Step 2: Overlapping Leave Check
    $overlap = Leave::where('employee_id', $request->employee_id)
        ->where(function ($query) use ($request) {
            $query->whereBetween('leave_from', [$request->leave_from, $request->leave_to])
                  ->orWhereBetween('leave_to', [$request->leave_from, $request->leave_to])
                  ->orWhere(function ($query) use ($request) {
                      $query->where('leave_from', '<=', $request->leave_from)
                            ->where('leave_to', '>=', $request->leave_to);
                  });
        })
        ->exists();

    if ($overlap) {
        return back()->withErrors(['leave_range' => 'You already have a leave that overlaps with the selected dates.'])->withInput();
    }


$employee = Subu::find($request->employee_id);
$leaveType = $request->reason;
$totalDays = $request->total_days;

// Initialize
$plBalanceDeducted = 0;
$slDaysDeducted = 0;
$lopDaysAdded = 0;

// Handle permanent employee
if ($employee->employment_type === 'permanent') {
    $leaveBalance = Leavebalance::where('employee_id', $employee->id)
                    ->where('year', now()->year)
                    ->first();


    $remainingDays = $totalDays;

    // CASE 1: LOP - try PL (optional: SL), then LOP
    if ($leaveType === 'LOP') {
        if ($leaveBalance->pl_balance > 0) {
            $plToUse = min($remainingDays, floor($leaveBalance->pl_balance));
            $leaveBalance->pl_balance -= $plToUse;
            $plBalanceDeducted = $plToUse;
            $remainingDays -= $plToUse;
        }



        if ($remainingDays > 0) {
            $leaveBalance->lop_days += $remainingDays;
            $lopDaysAdded = $remainingDays;
        }
    }

    // CASE 2: PL
    elseif ($leaveType === 'PL') {
        if ($leaveBalance->pl_balance >= $totalDays) {
            $leaveBalance->pl_balance -= $totalDays;
            $plBalanceDeducted = $totalDays;
        } else {
            $plToUse = floor($leaveBalance->pl_balance);
            $leaveBalance->pl_balance -= $plToUse;
            $plBalanceDeducted = $plToUse;
            $remaining = $totalDays - $plToUse;
            $leaveBalance->lop_days += $remaining;
            $lopDaysAdded = $remaining;
        }
    }

    // CASE 3: SL
    elseif ($leaveType === 'SL') {
        if ($leaveBalance->sl_balance >= $totalDays) {
            $leaveBalance->sl_balance -= $totalDays;
            $slDaysDeducted = $totalDays;
        } else {
            $slToUse = $leaveBalance->sl_balance;
            $leaveBalance->sl_balance = 0;
            $slDaysDeducted = $slToUse;
            $remaining = $totalDays - $slToUse;
            $leaveBalance->lop_days += $remaining;
            $lopDaysAdded = $remaining;
        }
    }

    //$leaveBalance->save();
}

// Handle non-permanent employee
else {
    $leaveBalance = Leavebalance::where('employee_id', $employee->id)
    ->where('year', now()->year)
    ->first();

        if (!$leaveBalance) {
        $leaveBalance = Leavebalance::create([
        'employee_id' => $employee->id,
        'year' => now()->year,
        'annual_leave_entitlement' => 0,
        'total_leave_balance' => 0,
        'pl_balance' => 0,
        'sl_balance' => 0,
        'lop_days' => 0
        ]);
        }


    if ($leaveType !== 'LOP') {
        return back()->with('error', 'Non-permanent employees are only entitled to LOP.');
    }

    //$leaveBalance->lop_days += $totalDays;
    $lopDaysAdded = $totalDays;
    $leaveBalance->save();
}

// Handle file upload
$uploadPath = null;
if ($request->hasFile('upload')) {
    $upload = $request->file('upload');
    $uploadName = time() . '_' . $upload->getClientOriginalName();
    $uploadPath = 'leaveupload/' . $uploadName;
    $upload->move(public_path('leaveupload'), $uploadName);
}

// Store leave record
Leave::create([
    'employee_id'   => $request->employee_id,
    'name'          => $request->name,
    'designation'   => $request->designation,
    'department'    => $request->department,
    'leave_from'    => $request->leave_from,
    'leave_to'      => $request->leave_to,
    'total_days'    => $totalDays,
    'reason'        => $leaveType,
    'PL'            => $plBalanceDeducted,
    'SL'            => $slDaysDeducted,
    'LOP'           => $lopDaysAdded,
    'remarks'       => $request->remarks,
    'upload'        => $uploadPath,
]);

return redirect()->route('hrheadleave.list')->with([
    'message' => 'Leave applied successfully!',
    'alert-type' => 'success'
]);

}

public function EdiHrHeadLeave($id)
{
$test = Leave::findOrFail($id);
return view('hr_head.hrhead.leave.apply_leave.edit_leave', compact('test'));
}

public function UpdateHrHeadLeave(Request $request, $id)
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

return redirect()->route('hrheadleave.list')->with($notification);
}

public function DeleteHrHeadLeave($id)
{
    Leave::findOrFail($id)->delete();

    $notification = [
        'message'       => 'leave deleted successfully',
        'alert-type'    => 'success'
    ];

    return redirect()->route('hrheadleave.list')->with($notification);
} //End method


//////////////////////////////////HR Head Management/Leave Status//////////////////////////////////

public function HrHeadLeaveStatus()
{
    $user = auth()->user();
    $employye = Subu::where('user_id', $user->id)->first();
    $approvals = Leave::with('leavestatusofhrhead')->where('employee_id', $employye->id)->latest()->get();

    return view('hr_head.hrhead.leave.leave_status.hrhead_leave_status', [
        'approvals' => $approvals,
        'hrHeadName' => $employye->name, // or $employye->full_name if that's the field
    ]);
}




// ================================================================================
                    // Expense Claim Form of HRHEAD
    // ================================================================================
    public function ListClaimFormofHrHead()
    {
        $user = auth()->user();
        $employyee = Subu::where('user_id', $user->id)->first();
        $claims = Expenseclaim::where('employee_id', $employyee->id)->latest()->get();

        // $claims = Expenseclaim::latest()->get();
        return view('hr_head.hrhead.claim.apply_claim.expense_claim_form_list' , compact('claims', 'employyee'));


    }
    public function AddClaimFormofHrHead()
    {
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();
        return view('hr_head.hrhead.claim.apply_claim.add_expense_claim_form', compact('user', 'employee'));

    } //End method

    public function StoreclaimFormofHrHead(Request $request)
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
        'admin_approval' => 'required',
        'approval_date' => 'nullable|date',
        'reimbursed' => 'required|numeric',
        // 'processed_date' => 'nullable|date',
    ], [
        'expense_date.before_or_equal' => 'The expense date cannot be after the claim date.',
        'amount.numeric' => 'The amount must be a valid number.',
    ]);

    // Insert employee data
    Expenseclaim::create($request->all());

    return redirect()->route('claim.formhrhead')->with([
        'message' => 'Claim applied successfully',
        'alert-type' => 'success'
    ]);
}

public function EditClaimFormofHrHead($id)
{
    $claim = Expenseclaim::findOrFail($id);
    return view('hr_head.hrhead.claim.apply_claim.edit_expense_claim_form', compact('claim'));
}

public function UpdateClaimFormofHrHead(Request $request, $id)
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
        'admin_approval' => 'required',
        'approval_date' => 'nullable|date',
        'reimbursed' => 'required|numeric',
        // 'processed_date' => 'nullable|date',
    ], [
        'expense_date.before_or_equal' => 'The expense date cannot be after the claim date.',
        'amount.numeric' => 'The amount must be a valid number.',
    ]);

    Expenseclaim::findOrFail($id)->update($request->all());

    return redirect()->route('claim.formhrhead')->with([
        'message' => 'Claim updated successfully',
        'alert-type' => 'success'
    ]);
}

    public function DeleteClaimFormofHrHead($id)
    {
        Expenseclaim::findOrFail($id)->delete();

        $notification = [
            'message'       => 'claim deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('claim.formhrhead')->with($notification);
    } //End method

 /////////////////////////////track claim approval status of hrhead/////////////////////////////


 public function trackClaimStatusofHrHead()
{
    $user = auth()->user();
    $employye = Subu::where('user_id', $user->id)->first();
    $approvals = Expenseclaim::with(['claimstatusofemployee', 'latestRejectionReason'])
                    ->where('employee_id', $employye->id)
                    ->latest()
                    ->get();

    return view('hr_head.hrhead.claim.claim_status.track_claim_approval_status', compact('approvals', 'employye'));

}





        ///////// All attendances status of Hr Managers //////////


        public function viewAllHrManagersAttendances(Request $request)
{
    $month = $request->input('month', now()->format('m'));
    $currentYear = now()->year;
    $intMonth = (int)$month;

    $loggedInHrHeadId = auth()->id();

    $hrHeads = Subu::where('user_role', 'manager')
        ->where('created_by', $loggedInHrHeadId)
        ->get();

    foreach ($hrHeads as $head) {
        $attendances = $head->attendance()
            ->whereMonth('date', $month)
            ->whereYear('date', $currentYear)
            ->get()
            ->keyBy('date');

        $leaves = Leave::where('employee_id', $head->id)
            ->where('hr_status', 'hrapprove')
            ->where(function ($query) use ($currentYear, $intMonth) {
                $query->whereMonth('leave_from', '<=', $intMonth)
                      ->whereYear('leave_from', '<=', $currentYear)
                      ->whereMonth('leave_to', '>=', $intMonth)
                      ->whereYear('leave_to', '>=', $currentYear);
            })
            ->get();

        $daysInMonth = now()->setMonth($intMonth)->daysInMonth;
        $records = collect();

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = now()->setDate($currentYear, $intMonth, $day)->format('Y-m-d');

            if (isset($attendances[$date])) {
                $records->push($attendances[$date]);
            } else {
                $onLeave = $leaves->first(function ($leave) use ($date) {
                    return $date >= $leave->leave_from && $date <= $leave->leave_to;
                });

                if ($onLeave) {
                    $records->push((object)[
                        'date' => $date,
                        'status' => 'On Leave',
                        'check_in_time' => null,
                        'created_at' => null,
                    ]);
                }

            }
        }

        $head->filteredAttendances = $records->sortBy('date')->values();
    }

    return view('hr_head.all_employee_status.attendance_status.hr_manager_attendance_status', compact('hrHeads', 'month'));
}



                    // Download HRM Attendance Report


public function downloadHrmAttendanceReport(Request $request)
{
    $month     = $request->query('month', now()->format('m'));
    $year      = now()->year;
    $managerId = auth()->id();
    $loggedInUserName = auth()->user()->name ?? 'Unknown';

    // Fetch HR managers
    $heads = Subu::where('user_role', 'manager')
        ->where('created_by', $managerId)
        ->get();

    $monthName = \Carbon\Carbon::createFromDate($year, $month, 1)->format('F');
    $fileName  = "{$monthName}_Attendance_Report_HrManager-{$year}.csv";

    $headers  = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => "attachment; filename={$fileName}",
    ];

    $callback = function () use ($heads, $month, $year, $loggedInUserName, $monthName) {
        $out = fopen('php://output', 'w');

        // ✅ Custom heading
        fputcsv($out, [
            "Name: {$loggedInUserName}",
            '',
            '',
            '',
            '',
            '',
            "Month: {$monthName} {$year}"
        ]);

        // ✅ Blank line
        fputcsv($out, []);

        // ✅ Table headers
        fputcsv($out, ['Date', 'Emp ID', 'Name', 'Status', 'Check-in', 'System Time']);

        foreach ($heads as $head) {
            // key existing attendances by date
            $att = $head->attendance()
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get()
                ->keyBy('date');

            // get approved leaves
            $leaves = Leave::where('employee_id', $head->id)
                ->where('hr_status', 'hrapprove')
                ->whereYear('leave_from', $year)
                ->whereMonth('leave_from', '<=', (int)$month)
                ->whereMonth('leave_to', '>=', (int)$month)
                ->get();

            $days = now()->setMonth((int)$month)->daysInMonth;

            for ($d = 1; $d <= $days; $d++) {
                $date = now()->setDate($year, (int)$month, $d)->format('Y-m-d');
                $row  = $att[$date] ?? null;

                if (!$row && $leaves->first(fn($l) => $date >= $l->leave_from && $date <= $l->leave_to)) {
                    $row = (object)[
                        'date'           => $date,
                        'status'         => 'On Leave',
                        'check_in_time'  => null,
                        'created_at'     => null
                    ];
                }

                if ($row) {
                    fputcsv($out, [
                        \Carbon\Carbon::parse($row->date)->format('d/M/Y'),
                        $head->employee_id,
                        $head->name,
                        $row->status ?? 'Present',
                        $row->check_in_time
                            ? \Carbon\Carbon::parse($row->check_in_time)->format('h:i A')
                            : '---',
                        $row->created_at
                            ? \Carbon\Carbon::parse($row->created_at)->format('H:i')
                            : '---',
                    ]);
                }
            }
        }

        fclose($out);
        flush();
    };

    return response()->stream($callback, 200, $headers);
}







        ///////// All attendances status of Reportmanager //////////



        public function viewAllRmAttendances(Request $request)
{
    $month = (int) $request->input('month'); // Cast to integer
    $currentYear = now()->year;
    $managerId = $request->input('manager_id');

    $loggedInHRHead = auth()->user();

    $managers = Subu::where('user_role', 'manager')
        ->where('created_by', $loggedInHRHead->id)
        ->get();

    $employees = collect();

    if ($managerId && $month) {
        $manager = Subu::find($managerId);
        $employees = Subu::where('user_role', 'reportmanager')
            ->where('created_by', $manager?->user_id)
            ->get();

        foreach ($employees as $employee) {
            // Attendance records
            $attendances = $employee->attendances()
                ->whereMonth('date', $month)
                ->whereYear('date', $currentYear)
                ->get()
                ->keyBy(fn($a) => \Carbon\Carbon::parse($a->date)->format('Y-m-d'));

            // Approved leaves
            $leaves = Leave::where('employee_id', $employee->id)
                ->where('m_status', 'mapprove')
                ->whereMonth('leave_from', '<=', $month)
                ->whereMonth('leave_to', '>=', $month)
                ->whereYear('leave_from', '<=', $currentYear)
                ->whereYear('leave_to', '>=', $currentYear)
                ->get();

            $daysInMonth = \Carbon\Carbon::create($currentYear, $month, 1)->daysInMonth;
            $records = collect();

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = \Carbon\Carbon::create($currentYear, $month, $day)->format('Y-m-d');

                if (isset($attendances[$date])) {
                    $records->push($attendances[$date]);
                } else {
                    $onLeave = $leaves->first(function ($leave) use ($date) {
                        return $date >= $leave->leave_from && $date <= $leave->leave_to;
                    });

                    if ($onLeave) {
                        $records->push((object)[
                            'date' => $date,
                            'status' => 'On Leave',
                            'check_in_time' => null,
                            'created_at' => null,
                        ]);
                    }
                }
            }

            $employee->filteredAttendances = $records->sortBy('date')->values();
        }
    }

    return view('hr_head.all_employee_status.attendance_status.rm_attendance_status', compact(
        'managers',
        'managerId',
        'month',
        'employees'
    ));
}


// Download RMAttendanceReport

public function DownloadRMAttendanceReport(Request $request)
{
    $managerId = $request->query('manager_id');
    $month     = (int)$request->query('month', now()->month);
    $year      = now()->year;

    // 1️⃣ Get manager
    $manager = Subu::find($managerId);
    $managerName = $manager ? $manager->name : 'Unknown';

    // 2️⃣ Prepare employees
    $employees = collect();
    if ($manager && $month) {
        $employees = Subu::where('user_role', 'reportmanager')
            ->where('created_by', $manager->user_id)
            ->get()
            ->map(function ($emp) use ($month, $year) {
                $att = $emp->attendance()
                    ->whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->get()
                    ->keyBy('date');

                $leaves = Leave::where('employee_id', $emp->id)
                    ->where('m_status', 'mapprove')
                    ->whereYear('leave_from', '<=', $year)
                    ->whereYear('leave_to', '>=', $year)
                    ->whereMonth('leave_from', '<=', $month)
                    ->whereMonth('leave_to', '>=', $month)
                    ->get();

                $rows = collect();
                $days = now()->setMonth($month)->daysInMonth;

                for ($d = 1; $d <= $days; $d++) {
                    $date = now()->setDate($year, $month, $d)->format('Y-m-d');
                    $rec = $att[$date] ?? null;

                    if (!$rec && $leaves->first(fn($l) => $date >= $l->leave_from && $date <= $l->leave_to)) {
                        $rec = (object)[
                            'date'          => $date,
                            'status'        => 'On Leave',
                            'check_in_time' => null,
                            'created_at'    => null,
                        ];
                    }

                    if ($rec) {
                        $rows->push($rec);
                    }
                }

                $emp->filteredAttendances = $rows;
                return $emp;
            });
    }

    while (ob_get_level()) {
        ob_end_clean();
    }

    $monthName = \Carbon\Carbon::createFromDate($year, $month, 1)->format('F');
    $fileName = "{$monthName}_Attendance_Reporting_Manager-{$year}.csv";

    $headers = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => "attachment; filename={$fileName}",
    ];

    $callback = function () use ($employees, $managerName, $monthName, $year) {
        $out = fopen('php://output', 'w');

        // ✅ 1. Custom heading row
        fputcsv($out, [
            "Name: {$managerName}",
            '',
            '',
            'Attendance Report',
            '',
            '',
            '',
            "Month: {$monthName} {$year}"
        ]);

        // ✅ 2. Blank row
        fputcsv($out, []);

        // ✅ 3. Table headers
        fputcsv($out, ['Date', 'Employee ID', 'Name', 'Status', 'Check-in', 'System Time']);

        // ✅ 4. Table body
        foreach ($employees as $e) {
            foreach ($e->filteredAttendances as $a) {
                fputcsv($out, [
                    \Carbon\Carbon::parse($a->date)->format('d/M/Y'),
                    $e->employee_id,
                    $e->name,
                    $a->status ?? 'Present',
                    $a->check_in_time
                        ? \Carbon\Carbon::parse($a->check_in_time)->format('h:i A')
                        : '---',
                    $a->created_at
                        ? \Carbon\Carbon::parse($a->created_at)->format('H:i')
                        : '---',
                ]);
            }
        }

        fclose($out);
        flush();
    };

    return response()->stream($callback, 200, $headers);
}








        ///////// All attendance status of Employees //////////


public function viewAllEmployeeAttendances(Request $request)
{
    $month = (int) $request->input('month'); // Cast to integer
    $currentYear = now()->year;
    $managerId = $request->input('manager_id');

    $loggedInHRHead = auth()->user();

    $managers = Subu::where('user_role', 'manager')
        ->where('created_by', $loggedInHRHead->id)
        ->get();

    $employees = collect();

    if ($managerId && $month) {
        $manager = Subu::find($managerId);
        $employees = Subu::where('user_role', 'user')
            ->where('created_by', $manager?->user_id)
            ->get();

        foreach ($employees as $employee) {
            // Attendance records
            $attendances = $employee->attendances()
                ->whereMonth('date', $month)
                ->whereYear('date', $currentYear)
                ->get()
                ->keyBy(fn($a) => \Carbon\Carbon::parse($a->date)->format('Y-m-d'));

            // Approved leaves
            $leaves = Leave::where('employee_id', $employee->id)
                ->where('m_status', 'mapprove')
                ->whereMonth('leave_from', '<=', $month)
                ->whereMonth('leave_to', '>=', $month)
                ->whereYear('leave_from', '<=', $currentYear)
                ->whereYear('leave_to', '>=', $currentYear)
                ->get();

            $daysInMonth = \Carbon\Carbon::create($currentYear, $month, 1)->daysInMonth;
            $records = collect();

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $date = \Carbon\Carbon::create($currentYear, $month, $day)->format('Y-m-d');

                if (isset($attendances[$date])) {
                    $records->push($attendances[$date]);
                } else {
                    $onLeave = $leaves->first(function ($leave) use ($date) {
                        return $date >= $leave->leave_from && $date <= $leave->leave_to;
                    });

                    if ($onLeave) {
                        $records->push((object)[
                            'date' => $date,
                            'status' => 'On Leave',
                            'check_in_time' => null,
                            'created_at' => null,
                        ]);
                    }
                }
            }

            $employee->filteredAttendances = $records->sortBy('date')->values();
        }
    }

    return view('hr_head.all_employee_status.attendance_status.employees_attendance', compact(
        'managers',
        'managerId',
        'month',
        'employees'
    ));
}

/// Download Employee Attendance Report

public function DownloadEmpLoyeeAttendanceReport(Request $request)
{
    $managerId = $request->query('manager_id');
    $month     = (int)$request->query('month', now()->month);
    $year      = now()->year;

    // Find manager and get name
    $manager = Subu::find($managerId);
    $managerName = $manager ? $manager->name : 'Unknown';

    // Prepare employee collection
    $employees = collect();
    if ($manager && $month) {
        $employees = Subu::where('user_role', 'user')
            ->where('created_by', $manager->user_id)
            ->get()
            ->map(function($emp) use($month, $year) {
                $att = $emp->attendance()
                    ->whereYear('date', $year)
                    ->whereMonth('date', $month)
                    ->get()
                    ->keyBy('date');

                $leaves = Leave::where('employee_id', $emp->id)
                    ->where('m_status','mapprove')
                    ->whereYear('leave_from','<=', $year)
                    ->whereYear('leave_to',  '>=', $year)
                    ->whereMonth('leave_from','<=', $month)
                    ->whereMonth('leave_to',  '>=', $month)
                    ->get();

                $rows = collect();
                $days = now()->setMonth($month)->daysInMonth;

                for ($d = 1; $d <= $days; $d++) {
                    $date = now()->setDate($year, $month, $d)->format('Y-m-d');
                    $rec  = $att[$date] ?? null;

                    if (!$rec && $leaves->first(fn($l)=> $date >= $l->leave_from && $date <= $l->leave_to)) {
                        $rec = (object)[
                            'date'          => $date,
                            'status'        => 'On Leave',
                            'check_in_time' => null,
                            'created_at'    => null,
                        ];
                    }

                    if ($rec) {
                        $rows->push($rec);
                    }
                }

                $emp->filteredAttendances = $rows;
                return $emp;
            });
    }

    while (ob_get_level()) {
        ob_end_clean();
    }

    $monthName = \Carbon\Carbon::createFromDate($year, $month, 1)->format('F');
    $fileName = "{$monthName}_Attendance_Employee-{$year}.csv";

    $headers = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => "attachment; filename={$fileName}",
    ];

    $callback = function() use($employees, $managerName, $monthName, $year) {
        $out = fopen('php://output', 'w');

        // ✅ 1. Add custom CSV header
        fputcsv($out, [
            "Name: {$managerName}",
            '',
            '',

            '',
            '',
            '',
            "Month: {$monthName} {$year}"
        ]);

        // ✅ 2. Blank line
        fputcsv($out, []);

        // ✅ 3. Table headers
        fputcsv($out, ['Date', 'Employee ID', 'Name', 'Status', 'Check-in', 'System Time']);

        // ✅ 4. Data rows
        foreach ($employees as $e) {
            foreach ($e->filteredAttendances as $a) {
                fputcsv($out, [
                    \Carbon\Carbon::parse($a->date)->format('d/M/Y'),
                    $e->employee_id,
                    $e->name,
                    $a->status ?: 'Present',
                    $a->check_in_time
                        ? \Carbon\Carbon::parse($a->check_in_time)->format('h:i A')
                        : '---',
                    $a->created_at
                        ? \Carbon\Carbon::parse($a->created_at)->format('H:i')
                        : '---',
                ]);
            }
        }

        fclose($out);
        flush();
    };

    return response()->stream($callback, 200, $headers);
}











    ///////////////////////////////////////////////leave status of all Hr Managers/reporting manager/employee///////////////////////////////////////////////

    public function viewAllHrManagersLeaves(Request $request)
{
    $loggedInHRHead = auth()->user();

    $selectedMonth = $request->input('month');
    $selectedYear = $request->input('year');

    $managers = Subu::with(['leave' => function ($query) use ($selectedMonth, $selectedYear) {
        if ($selectedMonth && $selectedYear) {
            $query->whereMonth('leave_from', $selectedMonth)
                  ->whereYear('leave_from', $selectedYear);
        }
    }])
    ->where('user_role', 'manager')
    ->where('created_by', $loggedInHRHead->id)
    ->get();

    // Pass selected filters to view
    return view('hr_head.all_employee_status.leavestatus.leavestatus_all_hr_manager', [
        'hrHeads' => $managers,
        'selectedMonth' => $selectedMonth,
        'selectedYear' => $selectedYear,
    ]);
}


public function viewAllReportManagersLeaves(Request $request)
{


    $loggedInHRHead = auth()->user();

    $selectedHrManagerId = $request->input('hr_manager_id');
    $selectedMonth = $request->input('month');
    $selectedYear = $request->input('year');

    // Fetch HR Managers created by this HR Head
    $hrManagers = Subu::where('user_role', 'manager')
                      ->where('created_by', $loggedInHRHead->id)
                      ->get();

    // If a manager is selected, fetch their report managers
    $reportManagers = collect();

    if ($selectedHrManagerId) {
        $hrManager = Subu::find($selectedHrManagerId);

        $reportManagers = Subu::with(['leave' => function ($query) use ($selectedMonth, $selectedYear) {
                if ($selectedMonth && $selectedYear) {
                    $query->whereMonth('leave_from', $selectedMonth)
                          ->whereYear('leave_from', $selectedYear);
                }
            }])
            ->where('user_role', 'reportmanager')
            ->where('created_by', $hrManager?->user_id) // <-- correct lookup
            ->get();
    }
    // dd($reportManagers);


    return view('hr_head.all_employee_status.leavestatus.leavestatus_all_report_manager', [
        'hrManagers' => $hrManagers,
        'reportManagers' => $reportManagers,
        'selectedHrManagerId' => $selectedHrManagerId,
        'selectedMonth' => $selectedMonth,
        'selectedYear' => $selectedYear,
    ]);


}


public function viewAllEmployeesLeaves(Request $request)
{
    $loggedInHRHead = auth()->user();

    $selectedHrManagerId = $request->input('hr_manager_id');
    $selectedMonth = $request->input('month');
    $selectedYear = $request->input('year');

    // Fetch HR Managers created by this HR Head
    $hrManagers = Subu::where('user_role', 'manager')
                      ->where('created_by', $loggedInHRHead->id)
                      ->get();

    // Employees leave data
    $employees = collect();

    if ($selectedHrManagerId) {
        $hrManager = Subu::find($selectedHrManagerId);

        $employees = Subu::with(['leave' => function ($query) use ($selectedMonth, $selectedYear) {
            if ($selectedMonth && $selectedYear) {
                $query->whereMonth('leave_from', $selectedMonth)
                      ->whereYear('leave_from', $selectedYear);
            }
        }])
        ->where('user_role', 'user')
        ->where('created_by', $hrManager?->user_id)
        ->get();
    }

    return view('hr_head.all_employee_status.leavestatus.leavestatus_all_employees', [
        'hrManagers' => $hrManagers,
        'employees' => $employees,
        'selectedHrManagerId' => $selectedHrManagerId,
        'selectedMonth' => $selectedMonth,
        'selectedYear' => $selectedYear,
    ]);
}


///////////////////////////////////////////////Claim status of all Hr Managers/reporting manager/employee///////////////////////////////////////////////

public function viewAllHrManagersClaim(Request $request)
{
    $loggedInHRHead = auth()->user();

    $selectedMonth = $request->input('month');
    $selectedYear = $request->input('year');

    $managers = Subu::with(['claim' => function ($query) use ($selectedMonth, $selectedYear) {
        if ($selectedMonth && $selectedYear) {
            $query->whereMonth('claim_date', $selectedMonth)
                  ->whereYear('claim_date', $selectedYear);
        }
    }])
    ->where('user_role', 'manager')
    ->where('created_by', $loggedInHRHead->id)
    ->get();

    return view('hr_head.all_employee_status.claimstatus.claimstatus_all_hr_manager', [
        'hrHeads' => $managers,
        'selectedMonth' => $selectedMonth,
        'selectedYear' => $selectedYear,
    ]);
}


public function viewAllReportManagerClaims(Request $request)
{
    $loggedInHRHead = auth()->user();

    $selectedHrManagerId = $request->input('hr_manager_id');
    $selectedMonth = $request->input('month');
    $selectedYear = $request->input('year');

    // Fetch HR Managers created by this HR Head
    $hrManagers = Subu::where('user_role', 'manager')
                      ->where('created_by', $loggedInHRHead->id)
                      ->get();

    // Employees leave data
    $employees = collect();

    if ($selectedHrManagerId) {
        $hrManager = Subu::find($selectedHrManagerId);

        $employees = Subu::with(['claim' => function ($query) use ($selectedMonth, $selectedYear) {
            if ($selectedMonth && $selectedYear) {
                $query->whereMonth('claim_date', $selectedMonth)
                      ->whereYear('claim_date', $selectedYear);

            }
        }])
        ->where('user_role', 'reportmanager')
        ->where('created_by', $hrManager?->user_id)
        ->get();
    }

    return view('hr_head.all_employee_status.claimstatus.claimstatus_all_rm', [
        'hrManagers' => $hrManagers,
        'employees' => $employees,
        'selectedHrManagerId' => $selectedHrManagerId,
        'selectedMonth' => $selectedMonth,
        'selectedYear' => $selectedYear,
    ]);
}



public function viewAllEmployeesClaims(Request $request)
{
    $loggedInHRHead = auth()->user();

    $selectedHrManagerId = $request->input('hr_manager_id');
    $selectedMonth = $request->input('month');
    $selectedYear = $request->input('year');

    // Fetch HR Managers created by this HR Head
    $hrManagers = Subu::where('user_role', 'manager')
                      ->where('created_by', $loggedInHRHead->id)
                      ->get();

    // Employees leave data
    $employees = collect();

    if ($selectedHrManagerId) {
        $hrManager = Subu::find($selectedHrManagerId);

        $employees = Subu::with(['claim' => function ($query) use ($selectedMonth, $selectedYear) {
            if ($selectedMonth && $selectedYear) {
                $query->whereMonth('claim_date', $selectedMonth)
                      ->whereYear('claim_date', $selectedYear);

            }
        }])
        ->where('user_role', 'user')
        ->where('created_by', $hrManager?->user_id)
        ->get();
    }

    return view('hr_head.all_employee_status.claimstatus.claimstatus_all_employees', [
        'hrManagers' => $hrManagers,
        'employees' => $employees,
        'selectedHrManagerId' => $selectedHrManagerId,
        'selectedMonth' => $selectedMonth,
        'selectedYear' => $selectedYear,
    ]);
}







///////////////////////////////////////leave approval status of hrmanager///////////////////////////////////////

public function LeaveApprovalStatusofhrm()
        {
            // Fetch salary records where the user_role is either 'user' or 'reportmanager' and created by the logged-in manager
        $approvals = Leave::whereHas('employeeleavestatusinhrm', function ($query) {
            $query->whereIn('user_role', ['manager'])  // Check for both 'user' and 'reportmanager'
                  ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
        })->latest()->get();

        return view('hr_head.hrm.leave_aproval.leavestatus', compact('approvals'));
        }

    public function approveLeaveofHrm($id)
            {
                $leave = Leave::findOrFail($id);
                if ($leave->hr_status == 'hrreject' || $leave->hr_status == 'hrpending') {
                    $employeeId = $leave->employee_id;
                    $year = \Carbon\Carbon::parse($leave->leave_from)->year;

                    $leaveBalance = Leavebalance::where('employee_id', $employeeId)
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
                $leave->hr_status = 'hrapprove';
                $leave->save();
                return redirect()->back()->with('success', 'Leave Approved Successfully');
            }

    // public function rejectLeaveSubmitofHrm($id)
    //         {
    //             $leave = Leave::findOrFail($id);
    //             $leave->hr_status = 'hrreject';
    //             $leave->save();
    //             return redirect()->back()->with('error', 'Leave Rejected');
    //         }

            // leave approval status of hr managers when reject open a dialouge box

            public function rejectLeaveSubmitofHrm(Request $request)
            {
                $request->validate([
                    'leave_id' => 'required',
                    'employee_id' => 'required',
                    'reason' => 'required|string|max:255',
                    'rejected_by' => 'required',
                ]);

                // Update Leave status
                $leave = Leave::findOrFail($request->leave_id);

                if ($leave->hr_status !== 'hrreject') {

                    $employeeId = $leave->employee_id;
                    $year = \Carbon\Carbon::parse($leave->leave_from)->year;

                    $leaveBalance = Leavebalance::where('employee_id', $employeeId)
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
                    $leave->hr_status = 'hrreject';
                    $leave->save();

                    // Save rejection reason
                    LeaveRejection::create([
                        'leave_id' => $request->leave_id,
                        'employee_id' => $request->employee_id,
                        'rejected_by' => auth()->user()->id,
                        'status' => 'hrreject',
                        'reason' => $request->reason,
                    ]);
                }

                return redirect()->back()->with('error', 'Leave Rejected Successfully');
            }




   // claim approval of HR manager
public function ClaimApprovalStatustoHrm()
{
    $claims = Expenseclaim::whereHas('employeeclaimstatusinhrm', function ($query) {
    $query->whereIn('user_role', ['manager'])  // Check for both 'user' and 'reportmanager'
          ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
          })->latest()->get();

return view('hr_head.hrm.claim_aproval.hrm_claim_status', compact('claims'));

}

public function approveClaimOfhrm($id)
        {
            $claim = Expenseclaim::findOrFail($id);
            $claim->status = 'approve';
            $claim->save();
            return redirect()->back()->with('success', 'Claim Approved Successfully');
        }

public function rejectClaimOfhrm($id)
        {
            $claim = Expenseclaim::findOrFail($id);
            $claim->status = 'reject';
            $claim->save();
            return redirect()->back()->with('error', 'Claim Rejected');
        }


public function rejectClaimSubmitbyHrHead(Request $request)
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


    //////////////////////////////////////////Pay roll//////////////////////////////////////////


public function PayrollListOfHrm()
{
    // Fetch payrolls where the user_role is either 'user' or 'reportmanager' and created by the logged-in manager
    $payrolls = Payrolls::whereHas('payrool', function ($query) {
        $query->whereIn('user_role', ['manager'])  // Check for both 'user' and 'reportmanager'
              ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
    })->latest()->get();

    return view('hr_head.payroll_management.muster_roll.payroll', compact('payrolls'));
}


/////////// request /////////////////////
    public function UpdateRequestHr()
    {
        $employee = Auth::user()->subu()->first();

        return view('hr_head.hrhead.request.hr_update_request', compact('employee'));
    }


    public function submitByHrHead(Request $request)
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
            // Handle salary increment logic...
            break;

        case 'account-details-update':
            $request->validate([
                'bank_name' => 'required|string',
                'branch_name' => 'required|string',
                'account_number' => 'required|string',
                'ifsc_code' => 'required|string',
            ]);

           AccountUpdateRequest::create([
                'employee_id' => $employee->id,
                'bank_name' => $request->input('bank_name'),
                'branch_name' => $request->input('branch_name'),
                'account_number' => $request->input('account_number'),
                'ifsc_code' => $request->input('ifsc_code'),
                'admin_status' => 'adminpending',
            ]);

            return back()->with('success', 'Account update request sent for admin approval');


        case 'update-profile':
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone_number' => 'required|string|max:20',
                'current_address_line1' => 'nullable|string',
                'current_address_line2' => 'nullable|string',
                'current_city' => 'nullable|string',
                'current_state' => 'nullable|string',
                'current_district' => 'nullable|string',
                'current_pin' => 'nullable|string|max:10',
            ]);

            ProfileUpdateRequest::create([
                'employee_id' => $employee->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'current_address_line1' => $request->current_address_line1,
                'current_address_line2' => $request->current_address_line2,
                'current_city' => $request->current_city,
                'current_state' => $request->current_state,
                'current_district' => $request->current_district,
                'current_pin' => $request->current_pin,
                'admin_status' => 'adminpending',
            ]);

            return back()->with('success', 'Profile update request sent for admin approval.');

        case 'any-issue':
            $request->validate([
                'issue_description' => 'required|string',
            ]);
            // Handle issue report logic...
            break;
    }

    return back()->with('success', 'Form submitted successfully!');
}




public function viewMyProfileUpdateRequests()
{
    $employee = Auth::user()->subu()->first();


    if (!$employee) {
        return redirect()->back()->with('error', 'No employee record found.');
    }

    // Fetch all profile update requests for this employee
    $requests = ProfileUpdateRequest::where('employee_id', $employee->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

    return view('hr_head.hrhead.request_approval.profile_update', compact('requests'));
}


public function viewMyaccountUpdateRequests()
{
    $employee = Auth::user()->subu()->first();


    if (!$employee) {
        return redirect()->back()->with('error', 'No employee record found.');
    }

    // Fetch all profile update requests for this employee
    $requests = AccountUpdateRequest::where('employee_id', $employee->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

    return view('hr_head.hrhead.request_approval.account_update-status', compact('requests'));
}








/////////////////request form update/ update profile information/////////////



public function UpdateProfileOfHrm()
{
    $hrHeadId = auth()->id(); // logged-in HR Head ID

    $requests = ProfileUpdateRequest::with('employee')
        ->whereHas('employee', function ($query) use ($hrHeadId) {
            $query->where('created_by', $hrHeadId);  // or 'hr_head_id', whatever your column is
        })
        ->orderBy('created_at', 'desc')
        ->get();

    return view('hr_head.request.profile_requests', compact('requests'));
}




public function approveByHr($id)
{
    $profileUpdateRequest = ProfileUpdateRequest::findOrFail($id);
    $employee = Subu::findOrFail($profileUpdateRequest->employee_id);

    $updateData = [
        'name' => $profileUpdateRequest->name,
        'email' => $profileUpdateRequest->email,
        'phone_number' => $profileUpdateRequest->phone_number,
        'current_address_line1' => $profileUpdateRequest->current_address_line1,
        'current_address_line2' => $profileUpdateRequest->current_address_line2,
        'current_city' => $profileUpdateRequest->current_city,
        'current_state' => $profileUpdateRequest->current_state,
        'current_district' => $profileUpdateRequest->current_district,
        'current_pin' => $profileUpdateRequest->current_pin,
    ];

    $employee->update($updateData);

    $profileUpdateRequest->hr_status = 'hrapproved';
    $profileUpdateRequest->save();

    return redirect()->back()->with('success', 'Profile update approved and applied.');
}



public function rejectByHr($id)
{
    $request = ProfileUpdateRequest::findOrFail($id);
    $request->update(['hr_status' => 'hrrejected']);

    return back()->with('info', 'Request rejected.');
}


/////////////////////bank accounts details update///////////////
public function accountUpdateRequestsOfHrm()

{
$hrHeadId = auth()->id(); // logged-in HR Head ID

    $requests = AccountUpdateRequest::with('account')
        ->whereHas('account', function ($query) use ($hrHeadId) {
            $query->where('created_by', $hrHeadId)
                  ->where('user_role', 'manager'); // filter by role
        })
        ->orderBy('created_at', 'desc')
        ->get();

    return view('hr_head.hrhead.request_approval.account_update', compact('requests'));
}



/////////// accountdetails update request approve and reject ////////////

public function approveAccountRequestByHr($id)
{
    $request = AccountUpdateRequest::findOrFail($id);
    $employee = Subu::findOrFail($request->employee_id);

    $updateData = [
        'bank_name' => $request->bank_name,
        'branch_name' => $request->branch_name,
        'account_number' => $request->account_number,
        'ifsc_code' => $request->ifsc_code,
    ];

    $employee->update($updateData);
    $request->hr_status = 'hrapproved';
    $request->save();

    return back()->with('success', 'Account details approved and updated.');
}




public function rejectAccountRequestByHr($id)
{
    $request = AccountUpdateRequest::findOrFail($id);
    $request->update(['hr_status' => 'hrrejected']);

    return back()->with('success', 'Account details update request rejected.');
}



////////////// Termination letter //////////////


// List all terminations
    public function index()
    {


$terminations = Termination::with(['subu:id,employee_id,name']) // only fetch necessary fields
        ->whereHas('subu', function ($query) {
            $query->where('user_role', 'manager');
        })
        ->get();


        return view('hr_head.terminations.index', compact('terminations'));
    }


    public function create()
{
    $loggedInHRHeadId = Auth::id(); // HR Head's user_id

    // Step 1: Get all HR Managers created by this HR Head
    $hrManagers = Subu::where('created_by', $loggedInHRHeadId)->get();

    // Step 2: Get all Employees created by those HR Managers
    $employeeIds = $hrManagers->pluck('id'); // HR Managers' IDs
    $employees = Subu::whereIn('created_by', $employeeIds)->get();

    // Merge both HR Managers and Employees into a single collection
    $allUsers = $hrManagers->merge($employees);
    $notification = [
                    'message'       => 'claim deleted successfully',
                    'alert-type'    => 'success'
                ];

        // return redirect()->route('claim.formhrhead')->with($notification);
    return view('hr_head.terminations.create', compact('allUsers'));
}



    // Store the termination reason in the database
   public function store(Request $request)
{
    $request->validate([
        'employee_id' => 'required',
        'reason' => 'required|string',
    ]);

    Termination::create([
        'employee_id' => $request->employee_id,
        'reason' => $request->reason,
    ]);

    $notification = [
        'message'    => 'Termination Added successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('terminations.index')->with($notification);
}







    // Generate the termination letter for the employee
    public function terminationLetter($id)
    {
        $termination = Termination::with('subu')->findOrFail($id);
     Mail::to($termination->subu->email)->send(new TerminationMail($termination));

        return view('hr_head.terminations.letter', compact('termination'));
    }



}




