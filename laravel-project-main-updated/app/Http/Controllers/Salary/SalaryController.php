<?php

namespace App\Http\Controllers\Salary;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use App\Models\Subu;
use App\Models\Mypayslip;
use App\Models\Employee;
use App\Models\HrManager;
use App\Models\HrHead;



use Illuminate\Http\Request;

class SalaryController extends Controller
{

    public function SalaryList()
    {
        //
        $sals = Salary::latest()->get();

        return view('admin.payroll_management.salary_structure.salary_list' , compact('sals'));
        // return view('payroll_management.salary_list');
    }

    public function AddSalary()
{
    $salaries = Subu::all();
    $sima = Employee::all();  // Fetch data from the Employee table
    $mys = HrManager::all();  // Fetch data from the Employee table
    // return view('admin.payroll_management.salary_structure.add_salary', compact('salaries', 'sima'));
    return view('admin.payroll_management.salary_structure.add_salary', compact('salaries', 'sima', 'mys'));
}
    public function getallEmployeeDetails($employee_id)
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

public function StoreSalary(Request $request)
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

        return redirect()->route('salary.list')->with($notification);
    }


    public function EditSalary($id)
    {
        $sal = Salary::findOrFail($id);

        return view('admin.payroll_management.salary_structure.edit_salary', compact('sal'));
    }



    public function updateSalary(Request $request)
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

        return redirect()->route('salary.list')->with($notification);

    }

    // Delete an employee
    public function DeleteSalary($id)
    {
        // Delete the employee by ID
        Salary::findOrFail($id)->delete();

        $notification = [
            'message' => 'Employee deleted successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('salary.list')->with($notification);
    }
    public function SalaryView()
    {

        return view('admin.payroll_management.salary_structure.view_salary_list');
    }







    // pay slip
//     public function PayslipList()
//     {
// //         //
//         $pays = Mypayslip::latest()->get();

//         return view('admin.payroll_management.payslip_structure.payslip_list' , compact('pays'));
//         // return view('payroll_management.payslip_list');
//     }

//     // public function AddPayslip()
//     // {
//     // return view('payroll_management.add_payslip_list');
//     // }
//     public function AddPayslip()
//     {
//         $abcd = Subu::all();
//         return view('admin.payroll_management.payslip_structure.add_payslip_list', compact('abcd'));
//     }
// public function StorePayslip(Request $request)
//     {

//         $request->validate([
//             'employee_id' => 'required',
//             'name' => 'required',
//             'grade' => 'required',
//             'lop_days' => 'required',
//             'refund_days' => 'required',
//             'standard_days' => 'required',
//             'basic_salary' => 'required',
//             'house_rent_allowance' => 'required',
//             'conveyance_allowance' => 'required',
//             'lunch_allowance' => 'required',
//             'personal_pay' => 'required',
//             'medical_allowance' => 'required',
//             'other_allowance' => 'required',
//             'leave_travel_allowance' => 'required',
//             'total_ammount' => 'required',
//             'professional_tax' => 'required',
//             'esic' => 'required',
//             'advance' => 'required',
//             'net_salary_payable' => 'required'

//         ]);


//          // Insert payslip data
//         Mypayslip::create([
//             'employee_id' => $request->employee_id,
//             'name' => $request->name,
//             'grade' => $request->grade,
//             'lop_days' => $request->lop_days,
//             'refund_days' => $request->refund_days,
//             'standard_days' => $request->standard_days,
//             'basic_salary' => $request->basic_salary,
//             'house_rent_allowance' => $request->house_rent_allowance,
//             'conveyance_allowance' => $request->conveyance_allowance,
//             'lunch_allowance' => $request->lunch_allowance,
//             'personal_pay' => $request->personal_pay,
//             'medical_allowance' => $request->medical_allowance,
//             'other_allowance' => $request->other_allowance,
//             'leave_travel_allowance' => $request->leave_travel_allowance,
//             'total_ammount' => $request->total_ammount,
//             'professional_tax' => $request->professional_tax,
//             'esic' => $request->esic,
//             'advance' => $request->advance,
//             'net_salary_payable' => $request->net_salary_payable


//         ]);
//         $notification = [
//             'message' => 'payslip created successfully',
//             'alert-type' => 'success',
//         ];

//         return redirect()->route('mypayslip.list')->with($notification);
//     }


//     public function EditPayslip($id)
//     {
//         $pay = Mypayslip::findOrFail($id);

//         return view('admin.payroll_management.payslip_structure.edit_payslip_list', compact('pay'));
//     }



//     public function UpdatePayslip(Request $request)
//     {

//         $pid = $request->id;

//         Mypayslip::findOrFail($pid)->update([
//             'employee_id' => $request->employee_id,
//             'name' => $request->name,
//             'grade' => $request->grade,
//             'lop_days' => $request->lop_days,
//             'refund_days' => $request->refund_days,
//             'standard_days' => $request->standard_days,
//             'basic_salary' => $request->basic_salary,
//             'house_rent_allowance' => $request->house_rent_allowance,
//             'conveyance_allowance' => $request->conveyance_allowance,
//             'lunch_allowance' => $request->lunch_allowance,
//             'personal_pay' => $request->personal_pay,
//             'medical_allowance' => $request->medical_allowance,
//             'other_allowance' => $request->other_allowance,
//             'leave_travel_allowance' => $request->leave_travel_allowance,
//             'total_ammount' => $request->total_ammount,
//             'professional_tax' => $request->professional_tax,
//             'esic' => $request->esic,
//             'advance' => $request->advance,
//             'net_salary_payable' => $request->net_salary_payable


//         ]);

//         $notification = [
//             'message'       => 'Payslip updated successfully',
//             'alert-type'    => 'success'
//         ];

//         return redirect()->route('mypayslip.list')->with($notification);

//     }

//     // Delete an employee
//     public function DeletePayslip($id)
//     {
//         // Delete the employee by ID
//         Mypayslip::findOrFail($id)->delete();

//         $notification = [
//             'message' => 'payslip deleted successfully',
//             'alert-type' => 'success'
//         ];

//         return redirect()->route('mypayslip.list')->with($notification);
//     }
//     public function DownloadPayslip($id)
// {
//     // Fetch the payslip record using the ID
//     $employee = Mypayslip::findOrFail($id);

//     // Fetch the corresponding employee details using employee_id
//      $payslip = Subu::findOrFail($employee->employee_id);

//     // Pass both payslip and employee data to the view
//     return view('admin.payroll_management.payslip_structure.employee_payslip_download', compact('employee', 'payslip'));

// }

}
