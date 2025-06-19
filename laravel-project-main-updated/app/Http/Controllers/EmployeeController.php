<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Models\Employeeattendance;
use App\Models\Leave;
use App\Models\Leavebalance;
use App\Models\Makepermanent;
use App\Models\Subu;
use App\Models\Salary;
use App\Models\ProfileUpdateRequest;
use App\Models\AccountUpdateRequest;
use App\Models\Payrolls;
use App\Models\Mypayslip;
// use App\Http\Controllers\Carbon;
use Carbon\Carbon;
use App\Models\Holiday;
use App\Models\Expenseclaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function EmployeeDashboard()
    {
        return view('employee.index');
    } //End mehtod

    // In your EmployeeController
    public function EmployeeDashboards()
    {
        // Get the logged-in user
        $user = Auth::user();

        // Get the related employee (Subu) for the logged-in user
        $employee = $user->subu;
        $employyeData = Subu::where('user_id', $user->id)->first();
        // dd($employyeData->id);
        $leaveBalanceData = Leavebalance::where('employee_id', $employyeData->id)->first();

        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Get all attendance records for the current month and year
        $attendances = $employee->attendances()
                                ->whereYear('date', $currentYear)
                                ->whereMonth('date', $currentMonth)
                                ->get();

        // Get the latest attendance record
        $attendance = $employee->attendances()->latest()->first();
        $reportingManager = \App\Models\Subu::find($employee->assigned_to); // Assuming assigned_to is a user ID

        // You can also fetch the leave balance and other related data as needed
        $leaveBalance = $employee->leaveBalances()->latest()->first();

        // Prepare the attendance data for plotting
        $attendanceData = [];
        $daysInMonth = now()->daysInMonth; // Get the number of days in the current month
        $startOfMonth = now()->startOfMonth(); // Get the start date of the month

        // Loop through all the days of the month
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $date = $startOfMonth->copy()->addDays($i - 1); // Calculate the specific date for the month
            $attendanceOnDate = $attendances->where('date', $date->toDateString())->first(); // Get attendance for the specific date

            // If attendance exists for that date, push the data into the array
            if ($attendanceOnDate) {
                $checkInTime = $attendanceOnDate->check_in_time;
                $color = $this->getColorForCheckInTime($checkInTime); // Determine the color based on check-in time

                $attendanceData[] = [
                    'date' => $date->toDateString(), // Format date (YYYY-MM-DD)
                    'check_in_time' => $checkInTime, // Check-in time
                    'color' => $color, // Color for the bar
                ];
            } else {
                // If no attendance for that date, push null or a placeholder
                $attendanceData[] = [
                    'date' => $date->toDateString(),
                    'check_in_time' => null,
                    'color' => 'gray', // No attendance -> gray color
                ];
            }
        }

        // Return the data to the view
        return view('employee.my_dashboard', compact('employee', 'attendance', 'attendanceData', 'leaveBalance', 'reportingManager', 'leaveBalanceData'));
    }

    private function getColorForCheckInTime($checkInTime)
{
    if (!$checkInTime) {
        return 'gray'; // No check-in
    }

    // Force today's date with the check-in time (e.g. '09:34:00')
    $time = Carbon::createFromFormat('H:i:s', Carbon::parse($checkInTime)->format('H:i:s'));

    $onTime = Carbon::createFromTime(9, 0, 0);
    $slightlyLate = Carbon::createFromTime(9, 15, 0);

    if ($time->lte($onTime)) {
        return 'blue'; // On time
    } elseif ($time->lte($slightlyLate)) {
        return 'orange'; // Slightly late
    } else {
        return 'red'; // Late
    }
}





    public function EmployeeLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function EmployeeProfile()
    {
        $id             = Auth::user()->id;
        $profileData    = User::find($id);

        return view('employee.employee_profile_view' , compact('profileData'));
    }

    public function EmployeeProfileStore(Request $request)
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

    public function EmployeeChangePassword()
    {
        $id             = Auth::user()->id;
        $profileData    = User::find($id);

        return view('employee.employee_change_password', compact('profileData'));
    }

    public function EmployeeUpdatePassword(Request $request)
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



    // ================================================================================
                    // attendance record
    // ================================================================================

    public function EmployeeAttendance(Request $request)
    {
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();

        $query = Employeeattendance::where('employee_id', $employee->id);

        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('date', $request->month)
                  ->whereYear('date', $request->year);
        }

        $atens = $query->latest()->get();

        $currentYear = now()->year;
        $years = range(2019, $currentYear);

        return view('employee.employeeattendancerecord.employee_attendance_list', compact('atens', 'employee', 'years', 'currentYear'));
    }



    public function AddEmployeeAttendance()
    {
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();
        // return view('employee.employeeattendancerecord.add_employee_attendance_list');
    return view('employee.employeeattendancerecord.add_employee_attendance_list', compact('user', 'employee'));

    } //End method


    public function StoreEmployeeAttendance(Request $request)
{
    // Validation
    $request->validate([
        'employee_id' => 'required',
        'name' => 'required',
        'date' => 'required|date',
        'check_in_time' => 'required',
        'status' => 'required',
        // 'remarks' => 'required'
    ]);

    // Check if attendance already exists for the current date
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
        ->where('m_status', 'mapprove')
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
        'approved_by_manager' => $request->approved_by_manager, // Use the correct column name
    ]);

    $notification = [
        'message' => 'Attendance created successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('employee.attendance')->with($notification);
}


    public function EditEmployeeAttendance($id)
    {
    $aten = Employeeattendance::findOrFail($id);
    return view('employee.employeeattendancerecord.edit_employee_attendance_list', compact('aten'));
    }

    public function UpdateEmployeeAttendance(Request $request, $id)
{
    Employeeattendance::findOrFail($id)->update([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'date' => $request->date,
        'check_in_time' => $request->check_in_time,
        // 'check_out_time' => $request->check_out_time,
        // 'work_hours' => $request->work_hours,
        'status' => $request->status,
        'remarks' => $request->remarks,
    ]);

    $notification = [
        'message' => 'Attendance updated successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('employee.attendance')->with($notification);
}
    public function DeleteEmployeeAttendance($id)
    {
        Employeeattendance::findOrFail($id)->delete();

        $notification = [
            'message'       => 'attaendance deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('employee.attendance')->with($notification);
    } //End method

// ================================================================================
                    // leave management/apply leave
// =================================================================================
    public function ListLeave()
    {
        $user = auth()->user();
        $employye = Subu::where('user_id', $user->id)->first();
        $tests = Leave::where('employee_id', $employye->id)->latest()->get();
        // Leave::latest()->get();
        return view('employee.leavemanagement.apply_leave.apply_for_leave' , compact('tests', 'employye'));

        // return view('employee.leavemanagement.apply_for_leave');
    }
    public function AddLeave()
    {
        // return view('employee.leavemanagement.add_apply_for_leave');
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();

    // Return the view with the user and employee data
    return view('employee.leavemanagement.apply_leave.add_apply_for_leave', compact('user', 'employee'));

    }
    public function StoreLeave(Request $request)
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

        return redirect()->route('leave.apply')->with([
            'message' => 'Leave applied successfully!',
            'alert-type' => 'success'
        ]);
    }





public function EdiLeave($id)
    {
    $test = Leave::findOrFail($id);
    return view('employee.leavemanagement.apply_leave.edit_apply_for_leave', compact('test'));
    }

public function UpdateLeave(Request $request, $id)
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
        'remarks' => $request->remarks,
        'upload' => $request->upload,
    ]);

    $notification = [
        'message' => 'leave updated successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('leave.apply')->with($notification);
    }
public function DeleteLeave($id)
    {
        Leave::findOrFail($id)->delete();

        $notification = [
            'message'       => 'leave deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('leave.apply')->with($notification);
    } //End method





// ======================================================================================
     // Check leave balance
// ======================================================================================

public function CheckLeave()
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
    // $totalleaveTakenPL = $employee->leave
    // ->where('employee_id', $employee->id)
    // ->sum('PL');
    $totalleaveTakenPL = $employee->leave ?$employee->leave
    ->where('employee_id', $employee->id)
    ->sum('PL') : 0;
    // $totalleaveTakenSL = $employee->leave
    // ->where('employee_id', $employee->id)
    // ->sum('SL');
    $totalleaveTakenSL = $employee->leave ? $employee->leave
    ->where('employee_id', $employee->id)
    ->sum('SL') : 0;


    $totalleaveTakenLOP = $employee->leave ? $employee->leave->where('employee_id', $employee->id)->sum('LOP') : 0;
    // Calculate total leave days from payroll records for the current year
    $totalLopDays = $employee->payrolls->where('year', $currentYear)->sum('lop_days');
    // dd($totalLopDays);
    // dd($employee->leave->pluck('SL'));

    // $totalPaidLeaveDays = $employee->payrolls->where('year', $currentYear)->sum('paid_leave_days');
    // $totalSickLeaveDays = $employee->payrolls->where('year', $currentYear)->sum('sick_leave_days');
// dd();
    return view('employee.leavemanagement.leavebalance.check_leave_balance', compact(
        'employee',
        'leaveBalance',
        'totalLopDays',
        // 'totalPaidLeaveDays',
        // 'totalSickLeaveDays',
        'totalleaveTillYet',
        'totalleaveTakenPL',
        'totalleaveTakenSL',
        'totalleaveTakenLOP'
    ));
}




// ======================================================================================
    // Track Leave Approval Status
// ======================================================================================

    public function trackLeaveStatus()
    {
    $user = auth()->user();
    $employye = Subu::where('user_id', $user->id)->first();
    $approvals = Leave::with('leavestatusofemployee')->where('employee_id', $employye->id)->latest()->get();

    return view('employee.leavemanagement.leavestatus.leave_status', [
        'approvals' => $approvals,
        'employeeName' => $employye->name,
    ]);
    }

// ======================================================================================
    // Track claim Approval Status
// ======================================================================================

public function trackClaimStatus()
{
    $user = auth()->user();
    $employye = Subu::where('user_id', $user->id)->first();
    $approvals = Expenseclaim::with(['claimstatusofemployee', 'latestRejectionReason'])
                    ->where('employee_id', $employye->id)
                    ->latest()
                    ->get();

    return view('employee.claim_form.claim_status.claim_status', compact('approvals', 'employye'));
}




////////////// view Pay Slip //////////////

    public function ListPaylip()
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
        return redirect()->back()->with('error', 'Employee record not found.');
    }

    return view('employee.PayrollandCompensation.employee_payslips_list', compact('years', 'months', 'employee'));
}



    public function DownPayslip($id)
{
    // Fetch the payslip details using the provided ID
    $abc = Salary::findOrFail($id);

    // Fetch the corresponding employee details using the employee_id from the payslip
    $def = Subu::find($abc->id);

    // Pass both payslip and employee data to the view
    return view('employee.PayrollandCompensation.particularemployeepayslipdownload', compact('abc', 'def'));
}





public function EmpPayslipView(Request $request)
{
    $user = auth()->user();
// dd($request->toArray());
    // Retrieve the logged-in employee
    $employee = Subu::where('user_id', $user->id)->first();
    // dd($employee->toArray());

    if (!$employee) {
        return response()->json(['error' => 'Employee not found'], 404);
    }

    // Get year and month from request, default to current year and month
    $year = $request->input('year', now()->year);
    $month = $request->input('month', now()->format('m'));

    // Find the payslip based on employee_id and created_at year-month
    $payslip = Salary::where('employee_id', $employee->id)
        ->whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->first();

    if (!$payslip) {
        return response()->json(['error' => 'Payslip not found for the selected month'], 404);
    }

    return view('employee.PayrollandCompensation.view_payslip', compact('payslip'));
}









    public function AdminLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
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

    // ================================================================================
                    // Expense Claim Form
    // ================================================================================
    public function ListClaim()
    {
        $user = auth()->user();
        $employyee = Subu::where('user_id', $user->id)->first();
        $claims = Expenseclaim::where('employee_id', $employyee->id)->latest()->get();

        // $claims = Expenseclaim::latest()->get();
        return view('employee.claim_form.apply_claim.expense_claim_form_list' , compact('claims', 'employyee'));
    }
    public function AddClaim()
    {
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();
        return view('employee.claim_form.apply_claim.add_expense_claim_form', compact('user', 'employee'));

    } //End method

    public function Storeclaim(Request $request)
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
        'manager_approval' => 'required',
        'approval_date' => 'nullable|date',
        'reimbursed' => 'required|numeric',
        // 'processed_date' => 'nullable|date',
    ], [
        'expense_date.before_or_equal' => 'The expense date cannot be after the claim date.',
        'amount.numeric' => 'The amount must be a valid number.',
    ]);

    // Insert employee data
    Expenseclaim::create($request->all());

    return redirect()->route('claim.form')->with([
        'message' => 'Claim applied successfully',
        'alert-type' => 'success'
    ]);
}

public function EditClaim($id)
{
    $claim = Expenseclaim::findOrFail($id);
    return view('employee.claim_form.apply_claim..edit_expense_claim_form', compact('claim'));
}

public function UpdateClaim(Request $request, $id)
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
        'manager_approval' => 'required',
        'approval_date' => 'nullable|date',
        'reimbursed' => 'required|numeric',
        // 'processed_date' => 'nullable|date',
    ], [
        'expense_date.before_or_equal' => 'The expense date cannot be after the claim date.',
        'amount.numeric' => 'The amount must be a valid number.',
    ]);

    Expenseclaim::findOrFail($id)->update($request->all());

    return redirect()->route('claim.form')->with([
        'message' => 'Claim updated successfully',
        'alert-type' => 'success'
    ]);
}

    public function DeleteClaim($id)
    {
        Expenseclaim::findOrFail($id)->delete();

        $notification = [
            'message'       => 'claim deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('claim.form')->with($notification);
    } //End method


    public function checkLeaveBalance(Request $request)
    {
        $employeeId = $request->employee_id;
        $daysRequested = $request->days;

        $leaveBalance = Leavebalance::where('employee_id', $employeeId)->where('year', now()->year)->first();

        if (!$leaveBalance) {
            return response()->json([
                'pl_available' => false,
                'sl_available' => false,
                'cl_available' => false,
            ]);
        }

        $plAvailable = $leaveBalance->pl_balance >= $daysRequested;
        $slAvailable = $leaveBalance->sl_balance >= $daysRequested;

        return response()->json([
            'pl_available' => $plAvailable,
            'sl_available' => $slAvailable,
            'cl_available' => true, // Assuming CL is always available
        ]);
    }



//////////////////////////// make permanent ////////////////////////////

    public function MakePermanent()
{
    $employee = Auth::user()->subu()->with('supervisor')->first();

    return view('employee.requests.make_permanent.make_permanent', compact('employee'));
}


public function submit(Request $request)
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
                'check_in_status' => 'required|in:on',
            ]);

            // Check if already approved make-permanent exists
            $alreadyApproved = Makepermanent::where('user_id', $user->id)
                ->where('request_type', 'make-permanent')
                ->where('mstatus', 'mapprove')
                ->exists();

            if ($alreadyApproved) {
                return back()->with('success', 'You have already applied and it has been approved. Please check your status.');
            }

            // Optional: prevent multiple pending requests too
            $alreadyPending = Makepermanent::where('user_id', $user->id)
                ->where('request_type', 'make-permanent')
                ->where('mstatus', '!=', 'mapprove')
                ->exists();

            if ($alreadyPending) {
                return back()->with('success', 'You have already submitted a request. Please wait for approval.');
            }

            Makepermanent::create([
                'employee_id' => $employee->id,
                'user_id' => $user->id,
                'request_type' => $type,
                'check_in_status' => $request->has('check_in_status'),
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

           AccountUpdateRequest::create([
                'employee_id' => $employee->id,
                'bank_name' => $request->input('bank_name'),
                'branch_name' => $request->input('branch_name'),
                'account_number' => $request->input('account_number'),
                'ifsc_code' => $request->input('ifsc_code'),
                'rm_status' => 'rmpending',
            ]);

            return back()->with('success', 'Account update request sent for  Reporting Manager approval');
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
                'm_status' => 'mpending',
            ]);

            return back()->with('success', 'Profile update request sent for hr manager approval.');
        case 'any-issue':
            $request->validate([
                'issue_description' => 'required|string',
            ]);
            break;
    }

    // You can store the other requests similarly...
    return back()->with('success', 'Form submitted successfully!');
}

///////account update request //////////
public function viewMyACcountUpdates()
{
    $employee = Auth::user()->subu()->first();


    if (!$employee) {
        return redirect()->back()->with('error', 'No employee record found.');
    }

    // Fetch all profile update requests for this employee
    $requests = AccountUpdateRequest::where('employee_id', $employee->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

    return view('employee.request_status.account_update', compact('requests'));
}



///////profile update request //////////

public function viewMyProfileStatusofEmp()
{
    $employee = Auth::user()->subu()->first();


    if (!$employee) {
        return redirect()->back()->with('error', 'No employee record found.');
    }

    // Fetch all profile update requests for this employee
    $requests = ProfileUpdateRequest::where('employee_id', $employee->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

    return view('employee.request_status.profile_update', compact('requests'));
}


}
