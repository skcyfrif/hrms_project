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

}
