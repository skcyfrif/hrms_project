<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //

    public function AttendanceList()
    {
        $tests = Attendance::latest()->get();

        return view('employee.attendance_list' , compact('tests'));
        // return view('employee.attendance_list');
    }

    public function AddAttendance()
    {
        return view('employee.add_attendance_list');
    } //End method


    public function StoreAttendance(Request $request)
    {
    // Validation
    $request->validate([
        'employee_id' => 'required',
        'name' => 'required',
        'date' => 'required',
        'check_in_time' => 'required',
        'check_out_time' => 'required',
        'work_hours' => 'required',
        'status' => 'required',
        'remarks' => 'required'
    ]);
    // Insert employee data
    Attendance::create([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'date' => $request->date,
        'check_in_time' => $request->check_in_time,
        'check_out_time' => $request->check_out_time,
        'work_hours' => $request->work_hours,
        'status' => $request->status,
        'remarks' => $request->remarks,
    ]);

    $notification = [
        'message' => 'Attendance created successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('attendance.list')->with($notification);
    }

    public function EditAttendance($id)
    {
    $test = Attendance::findOrFail($id);
    return view('employee.edit_attendance_list', compact('test'));
    }

    public function UpdateAttendance(Request $request, $id)
{
    Attendance::findOrFail($id)->update([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'date' => $request->date,
        'check_in_time' => $request->check_in_time,
        'check_out_time' => $request->check_out_time,
        'work_hours' => $request->work_hours,
        'status' => $request->status,
        'remarks' => $request->remarks,
    ]);

    $notification = [
        'message' => 'Attendance updated successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('attendance.list')->with($notification);
}
    public function DeleteAttendance($id)
    {
        Attendance::findOrFail($id)->delete();

        $notification = [
            'message'       => 'attaindance deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('attendance.list')->with($notification);
    } //End method

    
    public function AttendanceView($id)
{
    // Find the attendance record by the provided ID
    $test = Attendance::findOrFail($id);

    // Pass the single record to the view
    return view('employee.view_attendance_list', compact('test'));
}




            // Attendance Reports
            public function AttendanceReport()
            {
                // $tests = Attendance::latest()->get();

                // return view('employee.attendance_list' , compact('tests'));
                return view('admin.reports&analytics.attendance_report');
            }

}
