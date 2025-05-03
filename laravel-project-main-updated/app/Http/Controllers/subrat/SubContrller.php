<?php

namespace App\Http\Controllers\subrat;

use App\Http\Controllers\Controller;
use App\Models\Subu;
use App\Models\User;
use App\Models\HrManager;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class SubContrller extends Controller
{
    // // Display the list of employees
    // public function SubList()
    // {
    //     $tests = Subu::latest()->get();
    //     // $managers = HrManager::latest()->get();
    //     // $sams = Employee::latest()->get();
    //     return view('admin.employee_management.employee_directory.employee_list', compact('tests'));
    // }

    // // Add a new employee
    // public function AddSub()
    // {

    // return view('admin.employee_management.employee_directory.add_employee_list');
    // }


    // // Store employee data in the database
    // public function StoreSub(Request $request)
    // {

    //     $request->validate([
    //         'employee_id' => 'required',
    //         'name' => 'required',
    //         // 'photo' => 'required',
    //         'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the image
    //         'email' => 'required',
    //         'phone_number' => 'required',
    //         'dob' => 'required',
    //         'gender' => 'required',

    //          // Contact Information
    //         // 'permanent_address' => 'required',
    //         'permanent_address_line1' => 'required',
    //         'permanent_address_line2' => 'required',
    //         'permanent_city' => 'required',
    //         'permanent_district' => 'required',
    //         'permanent_state' => 'required',
    //         'permanent_pin' => 'required',
    //         'current_address_line1' => 'required',
    //         'current_address_line2' => 'nullable',
    //         'current_city' => 'required',
    //         'current_district' => 'required',
    //         'current_state' => 'required',
    //         'current_pin' => 'required',

    //         // 'current_address' => 'required',
    //         'emergency_contact' => 'required',

    //            // Employment Details
    //         'designation' => 'required',
    //         'department' => 'required',
    //         'work_location' => 'required',
    //         'doj' => 'required',
    //         'employment_type' => 'required',
    //         'created_by' => 'required',

    //         // Bank Details
    //         'account_number' => 'required',
    //         'ifsc_code' => 'required',
    //         'bank_name' => 'required',
    //         'branch_name' => 'required',


    //         // Compensation Details
    //         'types' => 'required',
    //         'pay_cycle' => 'required',
    //         'total_leave_allowed' => 'required',
    //         'basic_salary' => 'required',
    //         'house_rent_allowance' => 'required',
    //         'conveyance_allowance' => 'required',
    //         'lunch_allowance' => 'required',
    //         'personal_pay' => 'required',
    //         'medical_allowance' => 'required',
    //         'other_allowance' => 'required',
    //         'leave_travel_allowance' => 'required',
    //         'total_ammount' => 'required',
    //         'professional_tax' => 'required',
    //         'esic' => 'required',
    //         'net_salary_payable' => 'required',

    //          // System Access
    //         'user_role' => 'required',
    //         'username' => 'required',
    //         'password' => 'required'

    //     ]);

    // $photoPath = null;
    // if ($request->hasFile('photo')) {
    //     $photo = $request->file('photo');
    //     $photoName = time() . '_' . $photo->getClientOriginalName(); // Generate a unique name
    //     $photoPath = 'photos/' . $photoName;
    //     $photo->move(public_path('photos'), $photoName); // Move file to public/resume
    // }

    //     // dd($request->all());exit;

    //     // Create employee record

    //     $user = User::create([
    //         // 'employee_id'        => $request->employee_id,
    //         'name'        => $request->name,
    //         'email'       => $request->email,
    //         'phone'       => $request->phone_number,
    //         'role'   => $request->user_role,
    //         'username'    => $request->username,
    //         'password'    => Hash::make($request->password), // Hash the password
    //         'address'     => $request->permanent_address  // You can also use current_address if needed
    //     ]);
    //     Subu::create([
    //         'employee_id' => $request->employee_id,
    //         'user_id' => $user->id,
    //         'name' => $request->name,
    //         // 'photo' => $request->photo,
    //         'photo' => $photoPath,
    //         'email' => $request->email,
    //         'phone_number' => $request->phone_number,
    //         'dob' => $request->dob,
    //         'gender' => $request->gender,


    //         // Contact Information
    //         // 'permanent_address' => $request->permanent_address,
    //         'permanent_address_line1' => $request->permanent_address_line1,
    //         'permanent_address_line2' => $request->permanent_address_line2,
    //         'permanent_city' => $request->permanent_city,
    //         'permanent_district' => $request->permanent_district,
    //         'permanent_state' => $request->permanent_state,
    //         'permanent_pin' => $request->permanent_pin,
    //         'current_address_line1' => $request->current_address_line1,
    //         'current_address_line2' => $request->current_address_line2,
    //         'current_city' => $request->current_city,
    //         'current_district' => $request->current_district,
    //         'current_state' => $request->current_state,
    //         'current_pin' => $request->current_pin,

    //         // 'current_address' => $request->current_address,
    //         'emergency_contact' => $request->emergency_contact,

    //          // Employment Details
    //         'designation' => $request->designation,
    //         'department' => $request->department,
    //         'work_location' => $request->work_location,
    //         'doj' => $request->doj,
    //         'employment_type' => $request->employment_type,
    //         'created_by' => $request->created_by,

    //         // Bank Details
    //         'account_number' => $request->account_number,
    //         'ifsc_code' => $request->ifsc_code,
    //         'bank_name' => $request->bank_name,
    //         'branch_name' => $request->branch_name,

    //         // Compensation Details
    //         'types' => $request->types,
    //         'pay_cycle' => $request->pay_cycle,
    //         'total_leave_allowed' => $request->total_leave_allowed,
    //         'basic_salary' => $request->basic_salary,
    //         'house_rent_allowance' => $request->house_rent_allowance,
    //         'conveyance_allowance' => $request->conveyance_allowance,
    //         'lunch_allowance' => $request->lunch_allowance,
    //         'personal_pay' => $request->personal_pay,
    //         'medical_allowance' => $request->medical_allowance,
    //         'other_allowance' => $request->other_allowance,
    //         'leave_travel_allowance' => $request->leave_travel_allowance,
    //         'total_ammount' => $request->total_ammount,
    //         'professional_tax' => $request->professional_tax,
    //         'esic' => $request->esic,
    //         'net_salary_payable' => $request->net_salary_payable,

    //          // System Access
    //         'user_role' => $request->user_role,
    //         'username' => $request->username,
    //         'password' => $request->password

    //     ]);
    //     $notification = [
    //         'message' => 'Employee created successfully',
    //         'alert-type' => 'success',
    //     ];

    //     return redirect()->route('subrat.list')->with($notification);
    // }


    // public function EditSub($id)
    // {
    //     $test = Subu::findOrFail($id);

    //     return view('admin.employee_management.employee_directory.edit_employee_list', compact('test'));
    // }



    // public function UpdateStep(Request $request)
    // {

    //     $pid = $request->id;
    //     $subu = Subu::findOrFail($pid);
    //     $user = User::findOrFail($subu->user_id);

    //     // Update the User record
    // $user->update([
    //     'name' => $request->name,
    //     'email' => $request->email,
    //     'phone' => $request->phone_number,
    //     'role' => $request->user_role,
    //     'username' => $request->username,
    //     'password' => Hash::make($request->password), // Hash the password for security
    //     'address' => $request->permanent_address
    // ]);

    //     Subu::findOrFail($pid)->update([
    //         'employee_id' => $request->employee_id,
    //         'name' => $request->name,
    //         'photo' => $request->photo,
    //         // 'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'email' => $request->email,
    //         'phone_number' => $request->phone_number,
    //         'dob' => $request->dob,
    //         'gender' => $request->gender,

    //         // Contact Information
    //         // 'permanent_address' => $request->permanent_address,
    //         'permanent_address_line1' => $request->permanent_address_line1,
    //         'permanent_address_line2' => $request->permanent_address_line2,
    //         'permanent_city' => $request->permanent_city,
    //         'permanent_district' => $request->permanent_district,
    //         'permanent_state' => $request->permanent_state,
    //         'permanent_pin' => $request->permanent_pin,
    //         'current_address_line1' => $request->current_address_line1,
    //         'current_address_line2' => $request->current_address_line2,
    //         'current_city' => $request->current_city,
    //         'current_district' => $request->current_district,
    //         'current_state' => $request->current_state,
    //         'current_pin' => $request->current_pin,

    //         // 'current_address' => $request->current_address,
    //         'emergency_contact' => $request->emergency_contact,
    //         // Employment Details
    //         'designation' => $request->designation,
    //         'department' => $request->department,
    //         'work_location' => $request->work_location,
    //         'doj' => $request->doj,
    //         'employment_type' => $request->employment_type,
    //         'created_by' => $request->created_by,
    //         // Bank Details
    //         'account_number' => $request->account_number,
    //         'ifsc_code' => $request->ifsc_code,
    //         'bank_name' => $request->bank_name,
    //         'branch_name' => $request->branch_name,
    //         // Compensation Details
    //         'types' => $request->types,
    //         'pay_cycle' => $request->pay_cycle,
    //         'total_leave_allowed' => $request->total_leave_allowed,
    //         'basic_salary' => $request->basic_salary,
    //         'house_rent_allowance' => $request->house_rent_allowance,
    //         'conveyance_allowance' => $request->conveyance_allowance,
    //         'lunch_allowance' => $request->lunch_allowance,
    //         'personal_pay' => $request->personal_pay,
    //         'medical_allowance' => $request->medical_allowance,
    //         'other_allowance' => $request->other_allowance,
    //         'leave_travel_allowance' => $request->leave_travel_allowance,
    //         'total_ammount' => $request->total_ammount,
    //         'professional_tax' => $request->professional_tax,
    //         'esic' => $request->esic,
    //         'net_salary_payable' => $request->net_salary_payable,

    //         // System Access

    //         'user_role' => $request->user_role,
    //         'username' => $request->username,
    //         'password' => $request->password


    //     ]);

    //     $notification = [
    //         'message'       => 'Employee updated successfully',
    //         'alert-type'    => 'success'
    //     ];

    //     return redirect()->route('subrat.list')->with($notification);

    // }

    // // Delete an employee
    // public function DeleteSub($id)
    // {
    //     // Delete the employee by ID
    //     Subu::findOrFail($id)->delete();

    //     $notification = [
    //         'message' => 'Employee deleted successfully',
    //         'alert-type' => 'success'
    //     ];

    //     return redirect()->route('subrat.list')->with($notification);
    // }
    // public function SubView($id)
    // {
    //     $test = Subu::findOrFail($id);
    //     return view('admin.employee_management.employee_directory.view_employee_list', compact('test'));
    // }
    // public function viewOfferLetter($id)
    // {
    //     $employee = Subu::findOrFail($id); // Fetch the employee by ID
    //     return view('admin.employee_management.employee_directory.offer_letter', compact('employee')); // Pass data to view
    // }




}
