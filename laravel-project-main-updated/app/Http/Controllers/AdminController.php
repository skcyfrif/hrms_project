<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Subu;
use App\Models\Employeeattendance;
use App\Models\ProfileUpdateRequest;
use App\Models\AccountUpdateRequest;

use App\Models\Mypayslip;
use App\Models\Salary;
use App\Models\Employee;
// use App\Models\HrHead;
use App\Models\HrManager;
use App\Models\LeaveRejection;
use App\Models\Leave;
use App\Models\Expenseclaim;
use App\Models\ClaimRejection;
use Carbon\Carbon;
use App\Models\Payrolls;
use App\Models\Leavebalance;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Termination;
use App\Mail\TerminationMail;












use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        return view('admin.index');
    } //End mehtod


    public function AdminDashboards()
{
    // Count total by role directly from the 'subus' table
    $totalHrHeads = Subu::where('user_role', 'head')->count();
    $totalHrManagers = Subu::where('user_role', 'manager')->count();
    $totalReportManagers = Subu::where('user_role', 'reportmanager')->count();
    $totalUsers = Subu::where('user_role', 'user')->count();

    // (Optional) total employees if you need a combined count
    $totalEmployees = $totalHrHeads + $totalHrManagers + $totalUsers + $totalReportManagers;

    return view('admin.my_dashboard', compact(
        'totalHrHeads',
        'totalHrManagers',
        'totalReportManagers',
        'totalUsers',
        'totalEmployees'
    ));
}

public function showHrHeads()
{
    $hrHeads = Subu::with('createdByAdmin')->where('user_role', 'head')->get();
    return view('admin.employee_details_in_dashboard.all_hr_head', compact('hrHeads'));
}


public function showHrM()
{
    // Fetch HR Heads from the database
    // $hrm = Subu::where('user_role', 'manager')->get();
    $hrm = Subu::with('creator')->where('user_role', 'manager')->get();


    // Pass the data to the view
    return view('admin.employee_details_in_dashboard.all_hr_manager', compact('hrm'));
    // \admin\\.blade.php
}
public function ShowRM()
{
    // Fetch HR Heads from the database
    // $rm = Subu::where('user_role', 'reportmanager')->get();
    $rm = Subu::with('creator')->where('user_role', 'reportmanager')->get();


    // Pass the data to the view
    return view('admin.employee_details_in_dashboard.all_reportmanager', compact('rm'));
}

public function ShowEmply()
{
    // Eager load 'creator' to avoid N+1 issue
    $emps = Subu::with('creator')->where('user_role', 'user')->get();

    return view('admin.employee_details_in_dashboard.all_employee', compact('emps'));
}











    public function AdminLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    } // End method

    public function AdminLogin()
    {
        return view('admin.admin_login');
    }

    public function AdminProfile()
    {
        $id             = Auth::user()->id;
        $profileData    = User::find($id);

        return view('admin.admin_profile_view' , compact('profileData'));
    }

    public function AdminProfileStore(Request $request)
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

    public function AdminChangePassword()
    {
        $id             = Auth::user()->id;
        $profileData    = User::find($id);

        return view('admin.admin_change_password', compact('profileData'));
    }

    public function AdminUpdatePassword(Request $request)
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

    /////////Admin User all method //////////

    public function AllAdmin()
        {
            $alladmin = User::where('role' , 'admin')->get();

            return view('backend.pages.admin.all_admin' , compact('alladmin'));
        }

///////// All Hr Head //////////
public function viewAllHrHeads()
{
    // Get all HR heads with their attendance data
    $hrHeads = Subu::with('attendance')->where('user_role', 'head')->get();

    return view('admin.View_All_Employees.all_hr_head.all_hr_head_list', compact('hrHeads'));
}




public function viewManagersByHrHead($hrHeadId)
{
    // Find the HR Head by ID
    $hrHead = Subu::where('id', $hrHeadId)->first();
    // Check if HR Head exists
    if (!$hrHead) {
        return redirect()->back()->with('error', 'HR Head not found.');
    }
    // Get the user ID of the HR Head
    $user_id = $hrHead->user_id;
    // Fetch all managers created by this HR Head
    $managers = Subu::where('created_by', $user_id)
                    ->where('user_role', 'manager')
                    ->get();

  // Stop execution to inspect data

    return view('admin.View_All_Employees.all_hr_managers.all_hr_managers', compact('hrHead', 'managers'));
}

public function viewEmployeesByManager($managerId)
    {
        // Find the HR Head by ID
        $hrManager = Subu::where('id', $managerId)->first();
        // Check if HR Head exists
        if (!$hrManager) {
            return redirect()->back()->with('error', 'HR Manager not found.');
        }
        // Get the user ID of the HR Head
        $user_id = $hrManager->user_id;
        // Fetch all managers created by this HR Head
        $employees = Subu::where('created_by', $user_id)
                 ->whereIn('user_role', ['user', 'reportmanager'])
                 ->get();


        // Stop execution to inspect data

        return view('admin.View_All_Employees.all_employee.all_employee', compact('hrManager', 'employees'));

    }

    public function EmployeeView($id)
    {
        $test = Subu::findOrFail($id);
        return view('admin.View_All_Employees.all_employee.view_employee_list', compact('test'));
    }
    public function HrHeadView($id)
    {
        $test = Subu::findOrFail($id);
        return view('admin.View_All_Employees.all_hr_head.view_hr_head_list', compact('test'));
    }
    public function HrManagerView($id)
    {
        $test = Subu::findOrFail($id);
        return view('admin.View_All_Employees.all_hr_managers.view_hr_manager_list', compact('test'));
    }


    public function PayslipList()
        {

            $pays = Mypayslip::latest()->get();

            return view('admin.payroll_management.payslip_structure.payslip_list' , compact('pays'));
            // return view('payroll_management.payslip_list');
        }


    public function AddPayslip()
        {
            $abcd = Subu::all();
            $rama = Employee::all();  // Fetch data from the Employee table
            $sitaa = HrManager::all();  // Fetch data from the Employee table



            // return view('admin.payroll_management.payslip_structure.add_payslip_list', compact('abcd', 'rama',));
            return view('admin.payroll_management.payslip_structure.add_payslip_list', compact('abcd', 'rama', 'sitaa'));
        }

    public function StorePayslip(Request $request)
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

            return redirect()->route('mypayslip.list')->with($notification);
        }


    public function EditPayslip($id)
        {
            $pay = Mypayslip::findOrFail($id);

            return view('admin.payroll_management.payslip_structure.edit_payslip_list', compact('pay'));
        }



    public function UpdatePayslip(Request $request)
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

            return redirect()->route('mypayslip.list')->with($notification);

        }

    // Delete an employee
    public function DeletePayslip($id)
        {
            // Delete the employee by ID
            Mypayslip::findOrFail($id)->delete();

            $notification = [
                'message' => 'payslip deleted successfully',
                'alert-type' => 'success'
            ];

            return redirect()->route('mypayslip.list')->with($notification);
        }
    public function DownloadPayslip($id)
        {
            // Fetch the payslip record using the ID
            $employee = Mypayslip::findOrFail($id);

            // Fetch the corresponding employee details using employee_id
            $payslip = Subu::findOrFail($employee->employee_id);

            // Pass both payslip and employee data to the view
            return view('admin.payroll_management.payslip_structure.employee_payslip_download', compact('employee', 'payslip'));

        }




/////////////////////////////// All  attendances status of hr head ///////////////////////////////



public function viewAllHrHeadsAttendances(Request $request)
{
    // Get selected month or default to current month
    $month = $request->input('month', now()->format('m'));
    $currentYear = now()->year;
    $intMonth = (int)$month; // Ensure month is an integer

    // Get all HR Heads
    $hrHeads = Subu::where('user_role', 'head')->get();

    foreach ($hrHeads as $head) {
        // Attendance for the selected month
        $attendances = $head->attendance()
            ->whereMonth('date', $month)
            ->whereYear('date', $currentYear)
            ->get()
            ->keyBy('date');

        // Approved leaves for the selected month
        $leaves = Leave::where('employee_id', $head->id)
            ->where('admin_status', 'adminapprove')
            // ->where('m_status', 'mapprove')
            ->whereMonth('leave_from', '<=', $intMonth)
            ->whereMonth('leave_to', '>=', $intMonth)
            ->get();

        // Prepare combined attendance + leave records
        $daysInMonth = now()->setMonth($intMonth)->daysInMonth;
        $records = collect();

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = now()->setDate($currentYear, $intMonth, $day)->format('Y-m-d');

            if (isset($attendances[$date])) {
                // Attendance record exists
                $records->push($attendances[$date]);
            } else {
                // Check if it's an approved leave
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
                // else {
                //     // Mark as Absent (no attendance, no leave)
                //     $records->push((object)[
                //         'date' => $date,
                //         'status' => 'Absent',
                //         'check_in_time' => null,
                //         'created_at' => null,
                //     ]);
                // }
            }
        }

        // Sort records by date
        $head->filteredAttendances = $records->sortBy('date')->values();
    }

    return view('admin.employee_management.attendancestatus.hr_head_attendance_status', compact('hrHeads', 'month'));
}





public function viewAllHrmanagerAttendances(Request $request)
{
    // Get selected month or default to current month
    $month = $request->input('month', now()->format('m'));
    $currentYear = now()->year;
    $intMonth = (int)$month; // Ensure month is an integer

    // Get all HR Heads
    $hrHeads = Subu::where('user_role', 'manager')->get();

    foreach ($hrHeads as $head) {
        // Attendance for the selected month
        $attendances = $head->attendance()
            ->whereMonth('date', $month)
            ->whereYear('date', $currentYear)
            ->get()
            ->keyBy('date');

        // Approved leaves for the selected month
        $leaves = Leave::where('employee_id', $head->id)
            ->where('hr_status', 'hrapprove')
            // ->where('m_status', 'mapprove')
            ->whereMonth('leave_from', '<=', $intMonth)
            ->whereMonth('leave_to', '>=', $intMonth)
            ->get();

        // Prepare combined attendance + leave records
        $daysInMonth = now()->setMonth($intMonth)->daysInMonth;
        $records = collect();

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = now()->setDate($currentYear, $intMonth, $day)->format('Y-m-d');

            if (isset($attendances[$date])) {
                // Attendance record exists
                $records->push($attendances[$date]);
            } else {
                // Check if it's an approved leave
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

        // Sort records by date
        $head->filteredAttendances = $records->sortBy('date')->values();
    }
    return view('admin.employee_management.attendancestatus.all_hr_managers_attendance', compact('hrHeads', 'month'));
}

public function viewAllreportmanagerAttendances(Request $request)
{
     // Get selected month or default to current month
    $month = $request->input('month', now()->format('m'));
    $currentYear = now()->year;
    $intMonth = (int)$month; // Ensure month is an integer

    // Get all HR Heads
    $hrHeads = Subu::where('user_role', 'reportmanager')->get();

    foreach ($hrHeads as $head) {
        // Attendance for the selected month
        $attendances = $head->attendance()
            ->whereMonth('date', $month)
            ->whereYear('date', $currentYear)
            ->get()
            ->keyBy('date');

        // Approved leaves for the selected month
        $leaves = Leave::where('employee_id', $head->id)
            ->where('m_status', 'mapprove')
            // ->where('m_status', 'mapprove')
            ->whereMonth('leave_from', '<=', $intMonth)
            ->whereMonth('leave_to', '>=', $intMonth)
            ->get();

        // Prepare combined attendance + leave records
        $daysInMonth = now()->setMonth($intMonth)->daysInMonth;
        $records = collect();

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = now()->setDate($currentYear, $intMonth, $day)->format('Y-m-d');

            if (isset($attendances[$date])) {
                // Attendance record exists
                $records->push($attendances[$date]);
            } else {
                // Check if it's an approved leave
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

        // Sort records by date
        $head->filteredAttendances = $records->sortBy('date')->values();
    }
    return view('admin.employee_management.attendancestatus.all_report_managers_attendance', compact('hrHeads', 'month'));
}


public function viewAllEmployeesAttendances(Request $request)
{
     // Get selected month or default to current month
    $month = $request->input('month', now()->format('m'));
    $currentYear = now()->year;
    $intMonth = (int)$month; // Ensure month is an integer

    // Get all HR Heads
    $hrHeads = Subu::where('user_role', 'user')->get();

    foreach ($hrHeads as $head) {
        // Attendance for the selected month
        $attendances = $head->attendance()
            ->whereMonth('date', $month)
            ->whereYear('date', $currentYear)
            ->get()
            ->keyBy('date');

        // Approved leaves for the selected month
        $leaves = Leave::where('employee_id', $head->id)
            ->where('m_status', 'mapprove')
            // ->where('m_status', 'mapprove')
            ->whereMonth('leave_from', '<=', $intMonth)
            ->whereMonth('leave_to', '>=', $intMonth)
            ->get();

        // Prepare combined attendance + leave records
        $daysInMonth = now()->setMonth($intMonth)->daysInMonth;
        $records = collect();

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = now()->setDate($currentYear, $intMonth, $day)->format('Y-m-d');

            if (isset($attendances[$date])) {
                // Attendance record exists
                $records->push($attendances[$date]);
            } else {
                // Check if it's an approved leave
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

        // Sort records by date
        $head->filteredAttendances = $records->sortBy('date')->values();
    }


    return view('admin.employee_management.attendancestatus.all_employees_attendance', compact('hrHeads', 'month'));
}









public function downloadHRHeadAttendanceReport(Request $request)
{
    $type  = $request->query('type', 'monthly');
    $month = (int) $request->query('month', now()->month);
    $year  = (int) $request->query('year', now()->year);

    $fileName = "employee_attendance_report_{$type}_{$month}_{$year}.csv";

    $headers = [
        "Content-Type"        => "text/csv",
        "Content-Disposition" => "attachment; filename={$fileName}",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0",
    ];

    $callback = function () use ($month, $year) {
        $handle = fopen('php://output', 'w');

        // CSV Headers
        fputcsv($handle, ['Date', 'Employee ID', 'Name', 'Status', 'Check-in', 'System Time']);

        $employees = Subu::where('user_role', 'head')->get();

        foreach ($employees as $emp) {
            // Attendance records
            $att = $emp->attendance()
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get()
                ->keyBy('date');

            // Leave records
            $monthStart = now()->setDate($year, $month, 1)->startOfDay();
            $monthEnd   = now()->setDate($year, $month, 1)->endOfMonth()->endOfDay();

            $leaves = Leave::where('employee_id', $emp->id)
                ->where('admin_status', 'adminapprove')
                ->where(function ($q) use ($monthStart, $monthEnd) {
                    $q->whereBetween('leave_from', [$monthStart, $monthEnd])
                      ->orWhereBetween('leave_to', [$monthStart, $monthEnd])
                      ->orWhere(function ($q2) use ($monthStart, $monthEnd) {
                          $q2->where('leave_from', '<=', $monthStart)
                             ->where('leave_to', '>=', $monthEnd);
                      });
                })
                ->get();

            // Loop through each day of the month
            $days = now()->setDate($year, $month, 1)->daysInMonth;
            for ($d = 1; $d <= $days; $d++) {
                $date = now()->setDate($year, $month, $d)->format('Y-m-d');
                $record = $att[$date] ?? null;

                // Check if this date is within any approved leave
                $onLeave = $leaves->first(fn($l) =>
                    $date >= \Carbon\Carbon::parse($l->leave_from)->format('Y-m-d') &&
                    $date <= \Carbon\Carbon::parse($l->leave_to)->format('Y-m-d')
                );

                if (!$record && $onLeave) {
                    $record = (object)[
                        'date'          => $date,
                        'status'        => 'On Leave',
                        'check_in_time' => null,
                        'created_at'    => null,
                    ];
                }

                if ($record) {
                    fputcsv($handle, [
                        \Carbon\Carbon::parse($record->date)->format('d/M/Y'),
                        $emp->employee_id,
                        $emp->name,
                        $record->status ?: 'Present',
                        $record->check_in_time
                            ? \Carbon\Carbon::parse($record->check_in_time)->format('h:i A')
                            : '---',
                        $record->created_at
                            ? \Carbon\Carbon::parse($record->created_at)->format('H:i:s')
                            : '---',
                    ]);
                }
            }
        }

        fclose($handle);
        flush();
    };

    return response()->stream($callback, 200, $headers);
}




public function downloadHRMAttendanceReport(Request $request)
{
    $type  = $request->query('type', 'monthly');
    $month = (int) $request->query('month', now()->month);
    $year  = (int) $request->query('year', now()->year);

    $fileName = "employee_attendance_report_{$type}_{$month}_{$year}.csv";

    $headers = [
        "Content-Type"        => "text/csv",
        "Content-Disposition" => "attachment; filename={$fileName}",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0",
    ];

    $callback = function () use ($month, $year) {
        $handle = fopen('php://output', 'w');

        // CSV Headers
        fputcsv($handle, ['Date', 'Employee ID', 'Name', 'Status', 'Check-in', 'System Time']);

        $employees = Subu::where('user_role', 'manager')->get();

        foreach ($employees as $emp) {
            // Attendance records
            $att = $emp->attendance()
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get()
                ->keyBy('date');

            // Leave records
            $monthStart = now()->setDate($year, $month, 1)->startOfDay();
            $monthEnd   = now()->setDate($year, $month, 1)->endOfMonth()->endOfDay();

            $leaves = Leave::where('employee_id', $emp->id)
                ->where('hr_status', 'hrapprove')
                ->where(function ($q) use ($monthStart, $monthEnd) {
                    $q->whereBetween('leave_from', [$monthStart, $monthEnd])
                      ->orWhereBetween('leave_to', [$monthStart, $monthEnd])
                      ->orWhere(function ($q2) use ($monthStart, $monthEnd) {
                          $q2->where('leave_from', '<=', $monthStart)
                             ->where('leave_to', '>=', $monthEnd);
                      });
                })
                ->get();

            // Loop through each day of the month
            $days = now()->setDate($year, $month, 1)->daysInMonth;
            for ($d = 1; $d <= $days; $d++) {
                $date = now()->setDate($year, $month, $d)->format('Y-m-d');
                $record = $att[$date] ?? null;

                // Check if this date is within any approved leave
                $onLeave = $leaves->first(fn($l) =>
                    $date >= \Carbon\Carbon::parse($l->leave_from)->format('Y-m-d') &&
                    $date <= \Carbon\Carbon::parse($l->leave_to)->format('Y-m-d')
                );

                if (!$record && $onLeave) {
                    $record = (object)[
                        'date'          => $date,
                        'status'        => 'On Leave',
                        'check_in_time' => null,
                        'created_at'    => null,
                    ];
                }

                if ($record) {
                    fputcsv($handle, [
                        \Carbon\Carbon::parse($record->date)->format('d/M/Y'),
                        $emp->employee_id,
                        $emp->name,
                        $record->status ?: 'Present',
                        $record->check_in_time
                            ? \Carbon\Carbon::parse($record->check_in_time)->format('h:i A')
                            : '---',
                        $record->created_at
                            ? \Carbon\Carbon::parse($record->created_at)->format('H:i:s')
                            : '---',
                    ]);
                }
            }
        }

        fclose($handle);
        flush();
    };

    return response()->stream($callback, 200, $headers);
}




public function downloadRManagerAttendanceReport(Request $request)
{
    $type  = $request->query('type', 'monthly');
    $month = (int) $request->query('month', now()->month);
    $year  = (int) $request->query('year', now()->year);

    $fileName = "employee_attendance_report_{$type}_{$month}_{$year}.csv";

    $headers = [
        "Content-Type"        => "text/csv",
        "Content-Disposition" => "attachment; filename={$fileName}",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0",
    ];

    $callback = function () use ($month, $year) {
        $handle = fopen('php://output', 'w');

        // CSV Headers
        fputcsv($handle, ['Date', 'Employee ID', 'Name', 'Status', 'Check-in', 'System Time']);

        $employees = Subu::where('user_role', 'reportmanager')->get();

        foreach ($employees as $emp) {
            // Attendance records
            $att = $emp->attendance()
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get()
                ->keyBy('date');

            // Leave records
            $monthStart = now()->setDate($year, $month, 1)->startOfDay();
            $monthEnd   = now()->setDate($year, $month, 1)->endOfMonth()->endOfDay();

            $leaves = Leave::where('employee_id', $emp->id)
                ->where('m_status', 'mapprove')
                ->where(function ($q) use ($monthStart, $monthEnd) {
                    $q->whereBetween('leave_from', [$monthStart, $monthEnd])
                      ->orWhereBetween('leave_to', [$monthStart, $monthEnd])
                      ->orWhere(function ($q2) use ($monthStart, $monthEnd) {
                          $q2->where('leave_from', '<=', $monthStart)
                             ->where('leave_to', '>=', $monthEnd);
                      });
                })
                ->get();

            // Loop through each day of the month
            $days = now()->setDate($year, $month, 1)->daysInMonth;
            for ($d = 1; $d <= $days; $d++) {
                $date = now()->setDate($year, $month, $d)->format('Y-m-d');
                $record = $att[$date] ?? null;

                // Check if this date is within any approved leave
                $onLeave = $leaves->first(fn($l) =>
                    $date >= \Carbon\Carbon::parse($l->leave_from)->format('Y-m-d') &&
                    $date <= \Carbon\Carbon::parse($l->leave_to)->format('Y-m-d')
                );

                if (!$record && $onLeave) {
                    $record = (object)[
                        'date'          => $date,
                        'status'        => 'On Leave',
                        'check_in_time' => null,
                        'created_at'    => null,
                    ];
                }

                if ($record) {
                    fputcsv($handle, [
                        \Carbon\Carbon::parse($record->date)->format('d/M/Y'),
                        $emp->employee_id,
                        $emp->name,
                        $record->status ?: 'Present',
                        $record->check_in_time
                            ? \Carbon\Carbon::parse($record->check_in_time)->format('h:i A')
                            : '---',
                        $record->created_at
                            ? \Carbon\Carbon::parse($record->created_at)->format('H:i:s')
                            : '---',
                    ]);
                }
            }
        }

        fclose($handle);
        flush();
    };

    return response()->stream($callback, 200, $headers);
}



public function downloadEMPloyeeAttendanceReport(Request $request)
{
    $type  = $request->query('type', 'monthly');
    $month = (int) $request->query('month', now()->month);
    $year  = (int) $request->query('year', now()->year);

    $fileName = "employee_attendance_report_{$type}_{$month}_{$year}.csv";

    $headers = [
        "Content-Type"        => "text/csv",
        "Content-Disposition" => "attachment; filename={$fileName}",
        "Pragma"              => "no-cache",
        "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
        "Expires"             => "0",
    ];

    $callback = function () use ($month, $year) {
        $handle = fopen('php://output', 'w');

        // CSV Headers
        fputcsv($handle, ['Date', 'Employee ID', 'Name', 'Status', 'Check-in', 'System Time']);

        $employees = Subu::where('user_role', 'user')->get();

        foreach ($employees as $emp) {
            // Attendance records
            $att = $emp->attendance()
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->get()
                ->keyBy('date');

            // Leave records
            $monthStart = now()->setDate($year, $month, 1)->startOfDay();
            $monthEnd   = now()->setDate($year, $month, 1)->endOfMonth()->endOfDay();

            $leaves = Leave::where('employee_id', $emp->id)
                ->where('m_status', 'mapprove')
                ->where(function ($q) use ($monthStart, $monthEnd) {
                    $q->whereBetween('leave_from', [$monthStart, $monthEnd])
                      ->orWhereBetween('leave_to', [$monthStart, $monthEnd])
                      ->orWhere(function ($q2) use ($monthStart, $monthEnd) {
                          $q2->where('leave_from', '<=', $monthStart)
                             ->where('leave_to', '>=', $monthEnd);
                      });
                })
                ->get();

            // Loop through each day of the month
            $days = now()->setDate($year, $month, 1)->daysInMonth;
            for ($d = 1; $d <= $days; $d++) {
                $date = now()->setDate($year, $month, $d)->format('Y-m-d');
                $record = $att[$date] ?? null;

                // Check if this date is within any approved leave
                $onLeave = $leaves->first(fn($l) =>
                    $date >= \Carbon\Carbon::parse($l->leave_from)->format('Y-m-d') &&
                    $date <= \Carbon\Carbon::parse($l->leave_to)->format('Y-m-d')
                );

                if (!$record && $onLeave) {
                    $record = (object)[
                        'date'          => $date,
                        'status'        => 'On Leave',
                        'check_in_time' => null,
                        'created_at'    => null,
                    ];
                }

                if ($record) {
                    fputcsv($handle, [
                        \Carbon\Carbon::parse($record->date)->format('d/M/Y'),
                        $emp->employee_id,
                        $emp->name,
                        $record->status ?: 'Present',
                        $record->check_in_time
                            ? \Carbon\Carbon::parse($record->check_in_time)->format('h:i A')
                            : '---',
                        $record->created_at
                            ? \Carbon\Carbon::parse($record->created_at)->format('H:i:s')
                            : '---',
                    ]);
                }
            }
        }

        fclose($handle);
        flush();
    };

    return response()->stream($callback, 200, $headers);
}



///////////////////////////////////////////////leave status of all hrhead///////////////////////////////////////////////

public function viewAllHrHeadsLeaves(Request $request)
{
    $month = $request->input('month', now()->month); // numeric month (1-12)
    $year = $request->input('year', now()->year);    // full year (e.g., 2025)

    try {
        $monthStart = \Carbon\Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $monthEnd = \Carbon\Carbon::createFromDate($year, $month, 1)->endOfMonth();
        $selectedMonth = $monthStart->format('Y-m');

        $currentMonth = now()->format('Y-m');
        if ($selectedMonth > $currentMonth) {
            return redirect()->back()->with('error', 'You cannot select a future month.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Invalid month or year selected.');
    }

    $hrHeads = Subu::with(['leave' => function ($query) use ($monthStart, $monthEnd) {
        $query->where(function ($q) use ($monthStart, $monthEnd) {
            $q->whereBetween('leave_from', [$monthStart, $monthEnd])
              ->orWhereBetween('leave_to', [$monthStart, $monthEnd])
              ->orWhere(function ($q2) use ($monthStart, $monthEnd) {
                  $q2->where('leave_from', '<=', $monthStart)
                     ->where('leave_to', '>=', $monthEnd);
              });
        });
    }])
    ->where('user_role', 'head')
    ->whereHas('leave')
    ->get();

    return view('admin.employee_management.leavestatus.hr_head_leave_status', compact('hrHeads', 'selectedMonth', 'month', 'year'));
}



///////////////////////////////////////////////leave status of all hr manager///////////////////////////////////////////////



public function viewAllHrmLeaves(Request $request)
{
    $month = $request->input('month', now()->month); // numeric month (1-12)
    $year = $request->input('year', now()->year);    // full year (e.g., 2025)

    try {
        $monthStart = \Carbon\Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $monthEnd = \Carbon\Carbon::createFromDate($year, $month, 1)->endOfMonth();
        $selectedMonth = $monthStart->format('Y-m');

        $currentMonth = now()->format('Y-m');
        if ($selectedMonth > $currentMonth) {
            return redirect()->back()->with('error', 'You cannot select a future month.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Invalid month or year selected.');
    }

    $hrHeads = Subu::with(['leave' => function ($query) use ($monthStart, $monthEnd) {
        $query->where(function ($q) use ($monthStart, $monthEnd) {
            $q->whereBetween('leave_from', [$monthStart, $monthEnd])
              ->orWhereBetween('leave_to', [$monthStart, $monthEnd])
              ->orWhere(function ($q2) use ($monthStart, $monthEnd) {
                  $q2->where('leave_from', '<=', $monthStart)
                     ->where('leave_to', '>=', $monthEnd);
              });
        });
    }])
    ->where('user_role', 'manager')
    ->whereHas('leave')
    ->get();


    return view('admin.employee_management.leavestatus.all_hr_managers_leave', compact('hrHeads', 'selectedMonth', 'month', 'year'));
}


///////////////////////////////////////////////leave status of all reporting manager///////////////////////////////////////////////



public function viewAllRmLeaves(Request $request)
{
    $month = $request->input('month', now()->month); // numeric month (1-12)
    $year = $request->input('year', now()->year);    // full year (e.g., 2025)

    try {
        $monthStart = \Carbon\Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $monthEnd = \Carbon\Carbon::createFromDate($year, $month, 1)->endOfMonth();
        $selectedMonth = $monthStart->format('Y-m');

        $currentMonth = now()->format('Y-m');
        if ($selectedMonth > $currentMonth) {
            return redirect()->back()->with('error', 'You cannot select a future month.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Invalid month or year selected.');
    }

    $hrHeads = Subu::with(['leave' => function ($query) use ($monthStart, $monthEnd) {
        $query->where(function ($q) use ($monthStart, $monthEnd) {
            $q->whereBetween('leave_from', [$monthStart, $monthEnd])
              ->orWhereBetween('leave_to', [$monthStart, $monthEnd])
              ->orWhere(function ($q2) use ($monthStart, $monthEnd) {
                  $q2->where('leave_from', '<=', $monthStart)
                     ->where('leave_to', '>=', $monthEnd);
              });
        });
    }])
    ->where('user_role', 'reportmanager')
    ->whereHas('leave')
    ->get();


    return view('admin.employee_management.leavestatus.all_rm_leavestatus', compact('hrHeads', 'selectedMonth', 'month', 'year'));
}


/////////////////////////////////////////////// leave status of all Employees ///////////////////////////////////////////////



public function viewAllEmployeeLeaves(Request $request)
{
    $month = $request->input('month', now()->month); // numeric month (1-12)
    $year = $request->input('year', now()->year);    // full year (e.g., 2025)

    try {
        $monthStart = \Carbon\Carbon::createFromDate($year, $month, 1)->startOfMonth();
        $monthEnd = \Carbon\Carbon::createFromDate($year, $month, 1)->endOfMonth();
        $selectedMonth = $monthStart->format('Y-m');

        $currentMonth = now()->format('Y-m');
        if ($selectedMonth > $currentMonth) {
            return redirect()->back()->with('error', 'You cannot select a future month.');
        }
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Invalid month or year selected.');
    }

    $hrHeads = Subu::with(['leave' => function ($query) use ($monthStart, $monthEnd) {
        $query->where(function ($q) use ($monthStart, $monthEnd) {
            $q->whereBetween('leave_from', [$monthStart, $monthEnd])
              ->orWhereBetween('leave_to', [$monthStart, $monthEnd])
              ->orWhere(function ($q2) use ($monthStart, $monthEnd) {
                  $q2->where('leave_from', '<=', $monthStart)
                     ->where('leave_to', '>=', $monthEnd);
              });
        });
    }])
    ->where('user_role', 'user')
    ->whereHas('leave')
    ->get();

    return view('admin.employee_management.leavestatus.all_employee_leavestatus', compact('hrHeads', 'selectedMonth', 'month', 'year'));
}






    ///////////////////////////////////////////////Claim status of all employees///////////////////////////////////////////////

    public function viewAllHrHeadsClaims(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');

    $hrHeads = Subu::where('user_role', 'head')
        ->whereHas('claim', function ($query) use ($month, $year) {
            if ($month && $year) {
                $query->whereMonth('claim_date', $month)
                      ->whereYear('claim_date', $year);
            } elseif ($month) {
                $query->whereMonth('claim_date', $month);
            } elseif ($year) {
                $query->whereYear('claim_date', $year);
            }
        })
        ->with(['claim' => function ($query) use ($month, $year) {
            if ($month && $year) {
                $query->whereMonth('claim_date', $month)
                      ->whereYear('claim_date', $year);
            } elseif ($month) {
                $query->whereMonth('claim_date', $month);
            } elseif ($year) {
                $query->whereYear('claim_date', $year);
            }
        }])
        ->get();

    return view('admin.employee_management.claimstatus.hr_head_claim_status', compact('hrHeads', 'month', 'year'));
}

public function viewAllHrmClaims(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');

    $hrHeads = Subu::where('user_role', 'manager')
        ->whereHas('claim', function ($query) use ($month, $year) {
            if ($month && $year) {
                $query->whereMonth('claim_date', $month)
                      ->whereYear('claim_date', $year);
            } elseif ($month) {
                $query->whereMonth('claim_date', $month);
            } elseif ($year) {
                $query->whereYear('claim_date', $year);
            }
        })
        ->with(['claim' => function ($query) use ($month, $year) {
            if ($month && $year) {
                $query->whereMonth('claim_date', $month)
                      ->whereYear('claim_date', $year);
            } elseif ($month) {
                $query->whereMonth('claim_date', $month);
            } elseif ($year) {
                $query->whereYear('claim_date', $year);
            }
        }])
        ->get();

    return view('admin.employee_management.claimstatus.all_hr_managers_claim', compact('hrHeads', 'month', 'year'));
}


public function viewAllRmClaims(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');

    $hrHeads = Subu::where('user_role', 'reportmanager')
        ->whereHas('claim', function ($query) use ($month, $year) {
            if ($month && $year) {
                $query->whereMonth('claim_date', $month)
                      ->whereYear('claim_date', $year);
            } elseif ($month) {
                $query->whereMonth('claim_date', $month);
            } elseif ($year) {
                $query->whereYear('claim_date', $year);
            }
        })
        ->with(['claim' => function ($query) use ($month, $year) {
            if ($month && $year) {
                $query->whereMonth('claim_date', $month)
                      ->whereYear('claim_date', $year);
            } elseif ($month) {
                $query->whereMonth('claim_date', $month);
            } elseif ($year) {
                $query->whereYear('claim_date', $year);
            }
        }])
        ->get();

    return view('admin.employee_management.claimstatus.all_report_managers_claim', compact('hrHeads', 'month', 'year'));
}

public function viewAllEmployeeClaims(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');

    $hrHeads = Subu::where('user_role', 'user')
        ->whereHas('claim', function ($query) use ($month, $year) {
            if ($month && $year) {
                $query->whereMonth('claim_date', $month)
                      ->whereYear('claim_date', $year);
            } elseif ($month) {
                $query->whereMonth('claim_date', $month);
            } elseif ($year) {
                $query->whereYear('claim_date', $year);
            }
        })
        ->with(['claim' => function ($query) use ($month, $year) {
            if ($month && $year) {
                $query->whereMonth('claim_date', $month)
                      ->whereYear('claim_date', $year);
            } elseif ($month) {
                $query->whereMonth('claim_date', $month);
            } elseif ($year) {
                $query->whereYear('claim_date', $year);
            }
        }])
        ->get();
    return view('admin.employee_management.claimstatus.all_employee_claim', compact('hrHeads', 'month', 'year'));
}









    ///////////////////////////////////////leave approval status of hrhead///////////////////////////////////////

    public function LeaveApprovalStatusofhrHead()
    {
        // Fetch salary records where the user_role is either 'user' or 'reportmanager' and created by the logged-in manager
    $approvals = Leave::whereHas('employeeleavestatusinhrm', function ($query) {
        $query->whereIn('user_role', ['head'])  // Check for both 'user' and 'reportmanager'
              ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
    })->latest()->get();

    return view('admin.requeststatusof_hr_head.hrhead_leave_aproval.leavestatus', compact('approvals'));
    }

public function approveLeaveofhrHead($id)
        {
            $leave = Leave::findOrFail($id);
            if ($leave->admin_status == 'adminapprove' || $leave->admin_status == 'adminpending') {
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
            $leave->admin_status = 'adminapprove';
            $leave->save();
            return redirect()->back()->with('success', 'Leave Approved Successfully');
        }

// public function rejectLeaveSubmitofhrHead($id)
//         {
//             $leave = Leave::findOrFail($id);
//             $leave->admin_status = 'adminreject';
//             $leave->save();
//             return redirect()->back()->with('error', 'Leave Rejected');
//         }

        // leave approval status of hr head when reject open a dialouge box

        public function rejectLeaveSubmitbyAdmin(Request $request)
        {
            $request->validate([
                'leave_id' => 'required',
                'employee_id' => 'required',
                'reason' => 'required|string|max:255',
                'rejected_by' => 'required',
            ]);

            // Update Leave status
            $leave = Leave::findOrFail($request->leave_id);

            if ($leave->admin_status !== 'adminreject') {

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
                $leave->admin_status = 'adminreject';
                $leave->save();

                // Save rejection reason
                LeaveRejection::create([
                    'leave_id' => $request->leave_id,
                    'employee_id' => $request->employee_id,
                    'rejected_by' => auth()->user()->id,
                    'status' => 'adminreject',
                    'reason' => $request->reason,
                ]);
            }

            return redirect()->back()->with('error', 'Leave Rejected Successfully');
        }



////////////////////////////////////////claim approval of HR Head////////////////////////////////////////


public function ClaimApprovalStatustoHrhead()
{
    $claims = Expenseclaim::whereHas('employeeclaimstatusinhrm', function ($query) {
    $query->whereIn('user_role', ['head'])  // Check for both 'user' and 'reportmanager'
    // $query->where('user_role', 'head')
          ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
})->latest()->get();

// dd($claims);

return view('admin.requeststatusof_hr_head.hrhead_claim_aproval.hhead_claim_status', compact('claims'));
}

public function approveClaimOfHrhead($id)
        {
            $claim = Expenseclaim::findOrFail($id);
            $claim->status = 'approve';
            $claim->save();
            return redirect()->back()->with('success', 'Claim Approved Successfully');
        }

public function rejectClaimOfHrhead($id)
        {
            $claim = Expenseclaim::findOrFail($id);
            $claim->status = 'reject';
            $claim->save();
            return redirect()->back()->with('error', 'Claim Rejected');
        }


public function rejectClaimSubmitbyAdmin(Request $request)
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



/////////////////////// Add hrhead(employees) in admin ///////////////////////


    // Display the list of employees
    public function SubList()
    {

    $tests = Subu::where('created_by', auth()->user()->id)->latest()->get();


        return view('admin.employee_management.employee_directory.employee_list', compact('tests'));
    }

    // Add a new employee

    public function AddSub()
    {
        $hasRecords = Subu::exists(); // true if any row exists

        return view('admin.employee_management.employee_directory.add_employee_list', [
            'hasRecords' => $hasRecords
        ]);
    }



    // Store employee data in the database
    public function StoreSub(Request $request)
    {

        $request->validate([
            // 'employee_id' => 'required',
            'name' => 'required',
            // 'photo' => 'required',
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

        // dd($request->all());exit;

        // Create employee record

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
            'permanent_date' => now()->toDateString(),

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
            'message' => 'Employee created successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('subrat.list')->with($notification);
    }


    public function EditSub($id)
    {
        $test = Subu::findOrFail($id);

        return view('admin.employee_management.employee_directory.edit_employee_list', compact('test'));
    }



    public function UpdateStep(Request $request)
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
            'message'       => 'Employee updated successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('subrat.list')->with($notification);

    }

    // Delete an employee
    public function DeleteSub($id)
    {
        // Delete the employee by ID
        Subu::findOrFail($id)->delete();

        $notification = [
            'message' => 'Employee deleted successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('subrat.list')->with($notification);
    }
    public function SubView($id)
    {
        $test = Subu::findOrFail($id);
        return view('admin.employee_management.employee_directory.view_employee_list', compact('test'));
    }
    public function viewOfferLetter($id)
    {
        $employee = Subu::findOrFail($id); // Fetch the employee by ID
        return view('admin.employee_management.employee_directory.offer_letter', compact('employee')); // Pass data to view
    }



    //////////////////////////////////////////Pay roll//////////////////////////////////////////


public function PayrollListOfHr()
{
    // Fetch payrolls where the user_role is either 'user' or 'reportmanager' and created by the logged-in manager
    $payrolls = Payrolls::whereHas('payrool', function ($query) {
        $query->whereIn('user_role', ['head'])  // Check for both 'user' and 'reportmanager'
              ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
    })->latest()->get();

    return view('admin.payroll_management.muster_roll.payrool.payroll', compact('payrolls'));
}




/////////////////// salary structure //////////////////



public function HrSalaryLists()
{
    // Fetch salary records where the user_role is either 'user' or 'reportmanager' and created by the logged-in manager
    $sals = Salary::whereHas('employeesalarystructureinhrm', function ($query) {
        $query->whereIn('user_role', ['head'])  // Check for both 'user' and 'reportmanager'
              ->where('created_by', auth()->user()->id);  // Filter by logged-in manager's ID
    })->latest()->get();

    return view('admin.payroll_management.muster_roll.salary_structure.salary_list', compact('sals'));
}

public function HrAddSalaries()
    {
        // Get the logged-in user's (HR Manager's) ID
        $hrManagerId = auth()->user()->id;

        // Fetch only the employees created by this HR manager
        $salaries = Subu::where('created_by', $hrManagerId)->get();

        // Pass the filtered employees to the view
        return view('admin.payroll_management.muster_roll.salary_structure.add_salary', compact('salaries'));
    }

    public function HrStoreSalaries(Request $request)
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
        return redirect()->route('hrsalaries.lists')->with($notification);
    }



    public function HrEditSalaries($id)
    {
        $sal = Salary::findOrFail($id);

        return view('admin.payroll_management.muster_roll.salary_structure.edit_salary', compact('sal'));
    }



    public function HrupdateSalaries(Request $request)
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

        return redirect()->route('hrsalaries.lists')->with($notification);

    }

    // Delete an employee
    public function HrDeleteSalaries($id)
    {
        // Delete the employee by ID
        Salary::findOrFail($id)->delete();

        $notification = [
            'message' => 'Salary deleted successfully',
            'alert-type' => 'success'
        ];

        return redirect()->route('hrsalaries.lists')->with($notification);
    }
    public function HrSalaryView($id)
    {
        // Now the $id is passed correctly as a parameter
        $employee = Salary::findOrFail($id); // Fetch the employee based on the $id
        $payslip = Subu::findOrFail($employee->employee_id); // Fetch the payslip based on employee's id

        // Return the view with the data
        return view('admin.payroll_management.muster_roll.salary_structure.view_salary_slip', compact('employee', 'payslip'));
    }


    /////////////////request form update/ update profile information/////////////




public function UpdateProfileInfo()
{
    $requests = ProfileUpdateRequest::with('employee')
                ->whereHas('employee', function ($query) {
                    $query->where('user_role', 'head');
                })
                ->orderBy('created_at', 'desc')
                ->get();

    return view('admin.requeststatusof_hr_head.profile_requests', compact('requests'));
}



public function approve($id)
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

    $profileUpdateRequest->admin_status = 'adminapproved';
    $profileUpdateRequest->save();

    return redirect()->back()->with('success', 'Profile update approved and applied.');
}



public function reject($id)
{
    $request = ProfileUpdateRequest::findOrFail($id);
    $request->update(['admin_status' => 'adminrejected']);

    return back()->with('info', 'Request rejected.');
}




/////////////////////bank accounts details update///////////////
public function accountUpdateRequests()
{

     $requests = AccountUpdateRequest::with('account')
                ->whereHas('account', function ($query) {
                    $query->where('user_role', 'head');
                })
                ->orderBy('created_at', 'desc')
                ->get();
    // $requests = AccountUpdateRequest::with('account')
    //         ->orderBy('created_at', 'desc')
    //         ->get();
    return view('admin.requeststatusof_hr_head.account_requests', compact('requests'));
}





public function approveAccountRequest($id)
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
    $request->admin_status = 'adminapproved';
    $request->save();

    return back()->with('success', 'Account details approved and updated.');
}




public function rejectAccountRequest($id)
{
    $request = AccountUpdateRequest::findOrFail($id);
    $request->update(['admin_status' => 'adminrejected']);

    return back()->with('success', 'Account details update request rejected.');
}




////////////// Termination letter //////////////

// List all terminations
//     public function indexTer()
// {
//     // Get terminations where the related subus have the role 'head'
//     $terminations = Termination::with(['subu' => function ($query) {
//         $query->where('user_role', 'head');
//     }])->get();

//     return view('admin.terminations.index', compact('terminations'));
// }




public function indexTer()
{
    $terminations = Termination::with(['subu:id,employee_id,name']) // only fetch necessary fields
        ->whereHas('subu', function ($query) {
            $query->where('user_role', 'head');
        })
        ->get();

    return view('admin.terminations.index', compact('terminations'));
}





    public function createTer()
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
    return view('admin.terminations.create', compact('allUsers'));
}



    // Store the termination reason in the database
   public function storeTer(Request $request)
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

    return redirect()->route('terminations.hr')->with($notification);
}





    // Show termination details in a popup
    public function showTer($id)
    {
        $termination = Termination::with('subu')->findOrFail($id);
        return response()->json($termination);
    }




    // Generate the termination letter for the employee
    public function terminationLetterTer($id)
    {
        $termination = Termination::with('subu')->findOrFail($id);
     Mail::to($termination->subu->email)->send(new TerminationMail($termination));

        return view('admin.terminations.letter', compact('termination'));
    }



}
