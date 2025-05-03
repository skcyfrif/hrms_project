<?php

namespace App\Http\Controllers\hr;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Models\HrHead;
use App\Models\HrManager;
use App\Models\Subu;
use App\Models\Employeeattendance;
use App\Models\Leave;
use App\Models\Leavebalance;
use App\Models\Salary;
use App\Models\Employee;
use App\Models\Mypayslip;
use App\Models\Expenseclaim;
use App\Models\LeaveRejection;
use App\Models\ClaimRejection;
use Carbon\Carbon;






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


        $today = Carbon::today()->toDateString();
        $presentCount = Employeeattendance::whereDate('date', $today)
                        ->where('status', 'Present') // Adjust based on how you track presence
                        ->count();

        $pendingLeaveCountemplyee = Leave::where('m_status', 'mpending')
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
        return view('hr_head.my_dashboard', compact('employee', 'attendance', 'leaveBalance', 'pendingClaimCount', 'leaveBalanceData', 'totalMembers', 'presentCount', 'pendingLeaveCountemplyee'));
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
            // 'photo' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
            'email' => 'required',
            'phone_number' => 'required',
            'dob' => 'required',
            'gender' => 'required',

             // Contact Information
            // 'permanent_address' => 'required',
            // 'current_address' => 'required',
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
            // 'photo' => $request->photo,
            'photo' => $photoPath,
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

// salary structure

public function SalaryLists()
{
    //
    $sals = Salary::latest()->get();

    return view('hr_head.payroll_management.salary_structure.salary_list' , compact('sals'));
    // return view('payroll_management.salary_list');
    // D:\Laravel-project\update by soumya sir\laravel-project-main-updated\resources\views\hr_head\payroll_management\salary_structure\add_salary.blade.php
}

public function AddSalaries()
{
$salaries = Subu::all();
$sima = Employee::all();  // Fetch data from the Employee table
$mys = HrManager::all();  // Fetch data from the Employee table
// return view('admin.payroll_management.salary_structure.add_salary', compact('salaries', 'sima'));
return view('hr_head.payroll_management.salary_structure.add_salary', compact('salaries', 'sima', 'mys'));
}
public function getallEmployeeDetailed($employee_id)
{
    // Fetch the employee data from the database
    $employee = Subu::where('id', $employee_id)->first();

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

public function StoreSalaries(Request $request)
{

    $request->validate([
        'employee_id' => 'required',
        'name' => 'required',
        'department' => 'required',
        'designation' => 'required',
        'email' => 'required',
        'phone_number' => 'required',
        'account_number' => 'required',
        'ifsc_code' => 'required',
        'bank_name' => 'required',
        'branch_name' => 'required',
        'basic_salary' => 'required',
        'allowances' => 'required',
        'deductions' => 'required',
        'bonuses' => 'required',
        'overtime_pay' => 'required',
        'salary_for_the_month' => 'required',
        'no_of_working_day' => 'required',
        'total_leave_taken' => 'required',
        'payment_date' => 'required',
        'amount' => 'required',
        'payment_method' => 'required',
        'remarks' => 'required'

    ]);
    // dd($request->all());exit;

    // Create employee record
    Salary::create([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'department' => $request->department,
        'designation' => $request->designation,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'account_number' => $request->account_number,
        'ifsc_code' => $request->ifsc_code,
        'bank_name' => $request->bank_name,
        'branch_name' => $request->branch_name,
        'basic_salary' => $request->basic_salary,
        'allowances' => $request->allowances,
        'deductions' => $request->deductions,
        'bonuses' => $request->bonuses,
        'overtime_pay' => $request->overtime_pay,
        'salary_for_the_month' => $request->salary_for_the_month,
        'no_of_working_day' => $request->no_of_working_day,
        'total_leave_taken' => $request->total_leave_taken,
        'payment_date' => $request->payment_date,
        'amount' => $request->amount,
        'payment_method' => $request->payment_method,
        'remarks' => $request->remarks


    ]);
    $notification = [
        'message' => 'Employee created successfully',
        'alert-type' => 'success',
    ];

    return redirect()->route('salaries.lists')->with($notification);
}


public function EditSalaries($id)
{
    $sal = Salary::findOrFail($id);

    return view('hr_head.payroll_management.salary_structure.edit_salary', compact('sal'));
}



public function updateSalaries(Request $request)
{

    $pid = $request->id;

    Salary::findOrFail($pid)->update([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'department' => $request->department,
        'designation' => $request->designation,
        'email' => $request->email,
        'phone_number' => $request->phone_number,
        'account_number' => $request->account_number,
        'ifsc_code' => $request->ifsc_code,
        'bank_name' => $request->bank_name,
        'branch_name' => $request->branch_name,
        'basic_salary' => $request->basic_salary,
        'allowances' => $request->allowances,
        'deductions' => $request->deductions,
        'bonuses' => $request->bonuses,
        'overtime_pay' => $request->overtime_pay,
        'salary_for_the_month' => $request->salary_for_the_month,
        'no_of_working_day' => $request->no_of_working_day,
        'total_leave_taken' => $request->total_leave_taken,
        'payment_date' => $request->payment_date,
        'amount' => $request->amount,
        'payment_method' => $request->payment_method,
        'remarks' => $request->remarks


    ]);

    $notification = [
        'message'       => 'Property type updated successfully',
        'alert-type'    => 'success'
    ];

    return redirect()->route('salaries.lists')->with($notification);

}

// Delete an employee
public function DeleteSalaries($id)
{
    // Delete the employee by ID
    Salary::findOrFail($id)->delete();

    $notification = [
        'message' => 'Employee deleted successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('salaries.lists')->with($notification);
}
public function SalaryViews()
{

    return view('hr_head.payroll_management.salary_structure.view_salary_list');
}


// pay slips
public function PayslipLists()
    {
//         //
        $pays = Mypayslip::latest()->get();

        return view('hr_head.payroll_management.payslip_structure.payslip_list' , compact('pays'));
        // return view('payroll_management.payslip_list');
    }

// public function AddPayslip()
// {
// return view('payroll_management.add_payslip_list');
// }
public function AddPayslips()
    {
        $abcd = Subu::all();
        $rama = Employee::all();  // Fetch data from the Employee table
        $sitaa = HrManager::all();  // Fetch data from the Employee table



        // return view('admin.payroll_management.payslip_structure.add_payslip_list', compact('abcd', 'rama',));
        return view('hr_head.payroll_management.payslip_structure.add_payslip_list', compact('abcd', 'rama', 'sitaa'));
    }
    // public function getEmployeeDetailedforpayslip($employee_id)
    // {
    //     // Fetch the employee data from the database
    //     $asdf = Subu::where('id', $employee_id)->first();
    //     $asdf = Employee::where('id', $employee_id)->first();
    //     $asdf = HrManager::where('id', $employee_id)->first();


    //     if ($asdf) {
    //         return response()->json([
    //             'success' => true,
    //             'data' => $asdf
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Employee not found'
    //     ]);
    // }

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
public function HrHeadAttendanceList()
    {
        // $atens = Employeeattendance::latest()->get();
        $user = auth()->user();
        $employyye = Subu::where('user_id', $user->id)->first();
        $atens = Employeeattendance::where('employee_id', $employyye->id)->latest()->get();
        return view('hr_head.hrhead.hr_head_attendace.hr_head_attendance_list' , compact('atens', 'employyye'));
    }
    public function AddHrHeadAttendance()
    {
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();
        // return view('employee.employeeattendancerecord.add_employee_attendance_list');
    return view('hr_head.hrhead.hr_head_attendace.add_hr_head_attendance_list', compact('user', 'employee'));

    } //End method


    public function StoreHrHeadAttendance(Request $request)
    {
    // Validation
    $request->validate([
        'employee_id' => 'required',
        'name' => 'required',
        'date' => 'required',
        'check_in_time' => 'required',
        'status' => 'required',
        'remarks' => 'required'
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
    return view('hr_head.hrhead.leave.leavebalance.check_leave_balance');
    }



//////////////////Apply Leave of hrhead//////////////////

public function HrHeadlistLeave()
{
    $user = auth()->user();
    $employsye = Subu::where('user_id', $user->id)->first();
    $tests = Leave::where('employee_id', $employsye->id)->latest()->get();

return view('hr_head.hrhead.leave.apply_leave.leave_list' , compact('tests', 'employsye'));

}

public function AddHrHeadLeave()
{
    $user = auth()->user();
    $employee = Subu::where('user_id', $user->id)->first();

return view('hr_head.hrhead.leave.apply_leave.add_leave', compact('user', 'employee'));

} //End method

public function StoreHrHeadLeave(Request $request)
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

return redirect()->route('hrheadleave.list')->with($notification);
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

    return view('hr_head.hrhead.leave.leave_status.hrhead_leave_status', compact('approvals'));
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
        'reimbursed' => 'required',
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
        'reimbursed' => 'required',
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

    return view('hr_head.hrhead.claim.claim_status.track_claim_approval_status', compact('approvals'));

}





        ///////// All attendances status of Hr Managers/reporting manager/employee //////////


        public function viewAllHrManagersAttendances(Request $request)
        {
            $month = $request->input('month');
            $currentYear = now()->year;

            $loggedInHrHeadId = auth()->id(); // get current logged in HR head

            // Get HR managers created by this HR head
            $hrHeads = Subu::where('user_role', 'manager')
                        ->where('created_by', $loggedInHrHeadId)
                        ->get();

            foreach ($hrHeads as $head) {
                $attendanceQuery = $head->attendance();

                if ($month) {
                    $attendanceQuery->whereMonth('date', $month)
                                    ->whereYear('date', $currentYear);
                } else {
                    $attendanceQuery->whereYear('date', $currentYear);
                }

                // Get all matching records as a collection
                $head->filteredAttendances = $attendanceQuery->orderBy('date')->get();
            }
            return view('hr_head.all_employee_status.attendance_status.hr_manager_attendance_status', compact('hrHeads', 'month'));
        }


        public function viewAllRmAttendances(Request $request)
{
    $month = $request->input('month');
    $currentYear = now()->year;
    $managerId = $request->input('manager_id');

    $loggedInHRHead = auth()->user(); // Get logged-in HR Head

    // Get all managers under this HR Head
    $managers = Subu::where('user_role', 'manager')
        ->where('created_by', $loggedInHRHead->id)
        ->get();

    $employees = collect();

    if ($managerId && $month) {
        // Get all report managers created by the selected manager
        $employees = Subu::where('user_role', 'reportmanager')
            ->where('created_by', Subu::find($managerId)?->user_id)
            ->get();

        foreach ($employees as $employee) {
            $attendances = $employee->attendances()
                ->whereMonth('date', $month)
                ->whereYear('date', $currentYear)
                ->orderBy('date')
                ->get();

            $employee->filteredAttendances = $attendances;
        }
    }

    return view('hr_head.all_employee_status.attendance_status.rm_attendance_status', compact(
        'managers',
        'managerId',
        'month',
        'employees'
    ));
}



public function viewAllEmployeeAttendances(Request $request)
{
    $month = $request->input('month');
    $currentYear = now()->year;
    $managerId = $request->input('manager_id');

    $loggedInHRHead = auth()->user(); // Get logged-in HR Head

    // Get all managers under this HR Head
    $managers = Subu::where('user_role', 'manager')
        ->where('created_by', $loggedInHRHead->id)
        ->get();

    $employees = collect();

    if ($managerId && $month) {
        // Get all report managers created by the selected manager
        $employees = Subu::where('user_role', 'user')
            ->where('created_by', Subu::find($managerId)?->user_id)
            ->get();

        foreach ($employees as $employee) {
            $attendances = $employee->attendances()
                ->whereMonth('date', $month)
                ->whereYear('date', $currentYear)
                ->orderBy('date')
                ->get();

            $employee->filteredAttendances = $attendances;
        }
    }

    return view('hr_head.all_employee_status.attendance_status.employees_attendance', compact(
        'managers',
        'managerId',
        'month',
        'employees'
    ));
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
            $leave->hr_status = 'hrapprove';
            $leave->save();
            return redirect()->back()->with('success', 'Leave Approved Successfully');
        }

public function rejectLeaveofHrm($id)
        {
            $leave = Leave::findOrFail($id);
            $leave->hr_status = 'hrreject';
            $leave->save();
            return redirect()->back()->with('error', 'Leave Rejected');
        }

        // leave approval status of employees when reject open a dialouge box

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

            $leave->hr_status = 'hrreject';
            $leave->save();

            // Insert Rejection Reason
            LeaveRejection::create([
                'leave_id' => $request->leave_id,
                'employee_id' => $request->employee_id,
                'rejected_by' => auth()->user()->id,
                'status' => 'hrreject',
                'reason' => $request->reason,
            ]);

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




