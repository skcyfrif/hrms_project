<?php

namespace App\Http\Controllers\ReportingManager;

use App\Models\User;
use App\Models\Employeeattendance;
use App\Models\Leave;
use App\Models\Leavebalance;
use App\Models\Subu;
use App\Models\Mypayslip;
use App\Models\Expenseclaim;
use App\Models\LeaveRejection;
use App\Models\Makepermanent;
use App\Models\ProfileUpdateRequest;
use App\Models\AccountUpdateRequest;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employee;
use App\Models\Apply;
use App\Models\Interview;
use App\Models\Holiday;
use App\Models\Payrolls;
use App\Models\Salary;

use Carbon\Carbon;
class RmController extends Controller
{
    //

    public function ReportmanagerDashboard()
    {
        return view('report_manager.index');
    } //End mehtod

    public function ReportmanagerDashboards()
{
    // Get the logged-in user
    $user = Auth::user();

    $employee = $user->subu;
    $employyeData = Subu::where('user_id', $user->id)->first();
    // dd($employyeData->id);
    $leaveBalanceData = Leavebalance::where('employee_id', $employyeData->id)->first();
    $attendance = $employee->attendances()->latest()->first();

    $teamMembers = \App\Models\Subu::where('assigned_to', $employee->id)->get();


       // Get today’s attendance for the logged-in Reportmanager
            $today = Carbon::today()->toDateString();
            $attendances = Employeeattendance::where('employee_id', $employee->id)
                            ->whereDate('date', $today)
                            ->first();




    $todayAttendanceData = \App\Models\Subu::with(['attendances' => function ($query) {
        $query->whereDate('date', now()->toDateString())
              ->where('status', 'present');
    }])
    ->where('assigned_to', $employee->id)
    ->whereHas('attendances', function ($query) {
        $query->whereDate('date', now()->toDateString())
              ->where('status', 'present');
    })
    ->get();
    // dd($todayAttendanceData->toArray());
    $presentCount = $todayAttendanceData->filter(function ($member) {
        return $member->attendances->first()?->status === 'Present';
    })->count();

    $pendingLeaveCount = Leave::whereIn('employee_id', $teamMembers->pluck('id'))
                            ->where('rm_status', 'rmpending')
                            ->count();

// dd($presentCount);
    // Return the data to the view
    return view('report_manager.my_dashboard', compact('employee','attendances', 'pendingLeaveCount', 'attendance', 'teamMembers', 'todayAttendanceData', 'leaveBalanceData', 'presentCount'));
}


    public function ReportmanagerLogout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function ReportManagerProfile()
    {
        $id             = Auth::user()->id;
        $profileData    = User::find($id);

        return view('report_manager.report_manager_profile_view' , compact('profileData'));
    }

    public function ReportManagerProfileStore(Request $request)
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
            'message'       => 'report manager profile updated successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->back()->with($notification);
    } //End method

    public function ReportManagerChangePassword()
    {
        $id             = Auth::user()->id;
        $profileData    = User::find($id);

        return view('report_manager.report_manager_change_password', compact('profileData'));
    }

    public function ReportManagerUpdatePassword(Request $request)
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

    public function RmAttendance(Request $request)
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

        return view('report_manager.attendance.rm_attendance_list', compact('atens', 'employee', 'years', 'currentYear'));
    }


    public function AddRmAttendance()
    {
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();
        // return view('employee.employeeattendancerecord.add_employee_attendance_list');
    return view('report_manager.attendance.add_rm_attendance_list', compact('user', 'employee'));

    } //End method


    public function StoreRmAttendance(Request $request)
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
        // 'remarks' => $request->remarks,
    ]);

    $notification = [
        'message' => 'Attendance created successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('rm.attendance')->with($notification);
}


    public function EditRmAttendance($id)
    {
    $aten = Employeeattendance::findOrFail($id);
    return view('report_manager.attendance.edit_rm_attendance_list', compact('aten'));
    }

    public function UpdateRmAttendance(Request $request, $id)
{
    Employeeattendance::findOrFail($id)->update([
        'employee_id' => $request->employee_id,
        'name' => $request->name,
        'date' => $request->date,
        'check_in_time' => $request->check_in_time,
        // 'check_out_time' => $request->check_out_time,
        // 'work_hours' => $request->work_hours,
        'status' => $request->status,
        // 'remarks' => $request->remarks,
    ]);

    $notification = [
        'message' => 'Attendance updated successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('rm.attendance')->with($notification);
}
    public function DeleteRmAttendance($id)
    {
        Employeeattendance::findOrFail($id)->delete();

        $notification = [
            'message'       => 'attaendance deleted successfully',
            'alert-type'    => 'success'
        ];

        return redirect()->route('rm.attendance')->with($notification);
    } //End method


    // ================================================================================
                    // leave management/apply leave
// =================================================================================
public function ListRmLeave()
{
    $user = auth()->user();
    $employye = Subu::where('user_id', $user->id)->first();
    $tests = Leave::where('employee_id', $employye->id)->latest()->get();
    // Leave::latest()->get();
    return view('report_manager.leave_management.apply_leaves.apply_for_leave' , compact('tests', 'employye'));


}
public function AddRmLeave()
{
    // return view('employee.leavemanagement.add_apply_for_leave');
    $user = auth()->user();
    $employee = Subu::where('user_id', $user->id)->first();


// Return the view with the user and employee data
return view('report_manager.leave_management.apply_leaves.add_apply_for_leave', compact('user', 'employee'));

}

public function StoreRmLeave(Request $request)
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

    return redirect()->route('rmleave.apply')->with([
        'message' => 'Leave applied successfully!',
        'alert-type' => 'success'
    ]);
}


public function EdiRmLeave($id)
{
$test = Leave::findOrFail($id);
return view('report_manager.leave_management.apply_leaves.edit_apply_for_leave', compact('test'));
}

public function UpdateRmLeave(Request $request, $id)
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

return redirect()->route('rmleave.apply')->with($notification);
}
public function DeleteRmLeave($id)
{
    Leave::findOrFail($id)->delete();

    $notification = [
        'message'       => 'leave deleted successfully',
        'alert-type'    => 'success'
    ];

    return redirect()->route('rmleave.apply')->with($notification);
} //End method

// ================================================================================
                    // Expense Claim Form
// ================================================================================
    public function ListRmClaim()
    {
        $user = auth()->user();
        $employyee = Subu::where('user_id', $user->id)->first();
        $claims = Expenseclaim::where('employee_id', $employyee->id)->latest()->get();

        // $claims = Expenseclaim::latest()->get();
        return view('report_manager.claim_form.expenseclaim.expense_claim_form_list' , compact('claims', 'employyee'));


    }
    public function AddRmClaim()
    {
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();
        return view('report_manager.claim_form.expenseclaim.add_expense_claim_form', compact('user', 'employee'));

    } //End method

    public function StoreRmclaim(Request $request)
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

    return redirect()->route('rmclaim.form')->with([
        'message' => 'Claim applied successfully',
        'alert-type' => 'success'
    ]);
}

public function EditRmClaim($id)
{
    $claim = Expenseclaim::findOrFail($id);
    return view('report_manager.claim_form.expenseclaim.edit_expense_claim_form', compact('claim'));
}

public function UpdateRmClaim(Request $request, $id)
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

    return redirect()->route('rmclaim.form')->with([
        'message' => 'Claim updated successfully',
        'alert-type' => 'success'
    ]);
}

    public function DeleteRmClaim($id)
    {
        Expenseclaim::findOrFail($id)->delete();

        $notification = [
            'message'       => 'claim deleted successfully',
            'alert-type'    => 'success'
        ];
        // $notification = [
        return redirect()->route('rmclaim.form')->with($notification);
    } //End method


/////////////////////////////////// all assigned employee ///////////////////////////////////
public function assignedEmployees()
{
    // Assuming that the reporting manager is a User and has a relationship with Employee
    $managerId = Auth::user()->id;  // Get the logged-in reporting manager's ID
    $employeedata = Subu::where('user_id', $managerId)->first();
    $employeeId = $employeedata->id;

    // Fetch employees assigned to this reporting manager
    $employees = Subu::where('assigned_to', $employeeId)->get();
    // Pass employees data to the view
    return view('report_manager.employee_management.employeelisting.allemployee', compact('employees'));
}

////////////////////////////////////////////////////leave approval by reporting manager////////////////////////////////////////////////////
public function LeaveApprovalByRm()
{

    $managerId = auth()->user()->id;
    $employeedata = Subu::where('user_id', $managerId)->first();
    $employeeId = $employeedata->id;

    $approvals = Leave::whereHas('employeeleavestatusinrm', function ($query) use ($employeeId) {

        $query->where('assigned_to', $employeeId);
    })->latest()->get();


    return view('report_manager.employee_management.employees_leave.leavestatus', compact('approvals'));
}


public function approveLeaveByRm($id)
{
    $leave = Leave::findOrFail($id);

    $leave->rm_status = 'rmapprove';
    $leave->save();

    return redirect()->back()->with('success', 'Leave Approved Successfully');
}


        public function rejectLeaveByRm($id)
{
    $leave = Leave::findOrFail($id);


    $leave->rm_status = 'rmreject';
    $leave->save();

    return redirect()->back()->with('error', 'Leave Rejected');
}


public function rejectLeaveSubmitbyRm(Request $request)
{
    $request->validate([
        'leave_id' => 'required',
        'employee_id' => 'required',
        'reason' => 'required|string|max:255',
        'rejected_by' => 'required',
    ]);

    $leave = Leave::findOrFail($request->leave_id);


        $leave->rm_status = 'rmreject';
        $leave->save();

        // Save rejection reason
        LeaveRejection::create([
            'leave_id' => $request->leave_id,
            'employee_id' => $request->employee_id,
            'rejected_by' => auth()->user()->id,
            'status' => 'rmreject',
            'reason' => $request->reason,
        ]);
    // }

    return redirect()->back()->with('error', 'Leave Rejected Successfully');
}


////////////////////////////////////////////////////attendance status approval by reporting manager////////////////////////////////////////////////////




public function viewEmployeeAttendancesStatuses(Request $request)
    {
        $month       = (int)$request->input('month', now()->format('m'));
        $currentYear = now()->year;
        $userId      = auth()->id();

        // 1) Find this reporting manager's Subu record
        $reportManager = Subu::where('user_id', $userId)
                             ->where('user_role','reportmanager')
                             ->firstOrFail();

        // 2) Fetch employees assigned to that Subu ID
        $employees = Subu::where('user_role','user')
                         ->where('assigned_to', $reportManager->id)
                         ->get();

        // 3) Build filteredAttendances on each
        foreach ($employees as $emp) {
            // real attendance rows keyed by date
            $att = $emp->attendance()
                       ->whereYear('date', $currentYear)
                       ->whereMonth('date', $month)
                       ->get()
                       ->keyBy('date');

            // approved leaves in that month
            $leaves = Leave::where('employee_id',$emp->id)
                           ->where('m_status','mapprove')
                           ->where('rm_status','rmapprove')
                           ->whereYear('leave_from','<=',$currentYear)
                           ->whereYear('leave_to','>=',$currentYear)
                           ->whereMonth('leave_from','<=',$month)
                           ->whereMonth('leave_to','>=',$month)
                           ->get();

            $rows = collect();
            $days = Carbon::now()->setMonth($month)->daysInMonth;
            for ($d = 1; $d <= $days; $d++) {
                $date = Carbon::create($currentYear,$month,$d)->format('Y-m-d');
                $rec  = $att[$date] ?? null;

                // if no attendance but on approved leave
                if (!$rec && $leaves->first(fn($l) => $date >= $l->leave_from && $date <= $l->leave_to)) {
                    $rec = (object)[
                        'date'          => $date,
                        'status'        => 'On Leave',
                        'check_in_time' => null,
                        'created_at'    => null,
                        'rm_approval_status' => 'leave approved',

                    ];
                }

                if ($rec) {
                    $rows->push($rec);
                }
            }

            $emp->filteredAttendances = $rows;
        }

        return view(
            'report_manager.employee_management.attendance_status.employee_attendance_status',
            compact('employees','month')
        );
    }








public function downloadEmployeeAttendanceReports(Request $request)
{
    $month    = (int) $request->query('month', now()->month);
    $year     = now()->year;
    $user     = auth()->user()->name ?? 'Unknown';
    $rmSubu   = Subu::where('user_id', auth()->id())
                    ->where('user_role', 'reportmanager')
                    ->firstOrFail();

    $employees = Subu::where('user_role', 'user')
                     ->where('assigned_to', $rmSubu->id)
                     ->get();

    $monthStart = Carbon::create($year, $month, 1)->startOfMonth();
    $monthEnd   = $monthStart->copy()->endOfMonth();
    $daysInMonth = $monthEnd->day;

    foreach ($employees as $emp) {
        $attendance = $emp->attendance()
                          ->whereYear('date', $year)
                          ->whereMonth('date', $month)
                          ->get()
                          ->keyBy('date');

        $leaves = Leave::where('employee_id', $emp->id)
                       ->where('m_status', 'mapprove')
                       ->where('rm_status', 'rmapprove')
                       ->where(function ($q) use ($monthStart, $monthEnd) {
                            $q->whereBetween('leave_from', [$monthStart, $monthEnd])
                              ->orWhereBetween('leave_to', [$monthStart, $monthEnd])
                              ->orWhere(function ($q2) use ($monthStart, $monthEnd) {
                                  $q2->where('leave_from', '<=', $monthStart)
                                     ->where('leave_to', '>=', $monthEnd);
                              });
                       })
                       ->get();

        $emp->filteredAttendances = collect();

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $date = Carbon::create($year, $month, $d)->format('Y-m-d');
            $rec  = $attendance[$date] ?? null;

            if (!$rec && $leaves->first(fn($l) => $date >= $l->leave_from && $date <= $l->leave_to)) {
                $rec = (object)[
                    'date' => $date, 'status' => 'On Leave',
                    'check_in_time' => null, 'created_at' => null
                ];
            }

            if ($rec) $emp->filteredAttendances->push($rec);
        }
    }

    while (ob_get_level()) ob_end_clean();

    $fileName = "{$monthStart->format('F')}_Attendance_Report_By_RM-{$year}.csv";

    return response()->stream(function () use ($employees, $monthStart, $year, $user) {
        $out = fopen('php://output', 'w');

        fputcsv($out, ["Reporting Manager: {$user}", '', '','', '', "Month: {$monthStart->format('F')} {$year}"]);
        fputcsv($out, []);
        fputcsv($out, ['Date', 'Employee ID', 'Name', 'Status', 'Check-in', 'System Time']);

        foreach ($employees as $emp) {
            foreach ($emp->filteredAttendances as $a) {
                fputcsv($out, [
                    Carbon::parse($a->date)->format('d/M/Y'),
                    $emp->employee_id,
                    $emp->name,
                    $a->status ?? 'Present',
                    $a->check_in_time ? Carbon::parse($a->check_in_time)->format('h:i A') : '---',
                    $a->created_at    ? Carbon::parse($a->created_at)->format('H:i') : '---',
                ]);
            }
        }

        fclose($out);
        flush();
    }, 200, [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => "attachment; filename={$fileName}",
    ]);
}









    public function approveAttendanceinRm($id)
    {
        $attendance = Employeeattendance::findOrFail($id);
        $attendance->rm_approval_status = 'Present';
        $attendance->approve_by_rm = auth()->user()->id;
        $attendance->save();

        return redirect()->back()->with('success', 'Attendance marked as Present.');
    }

    public function absentAttendanceinRm($id)
    {
        $attendance = Employeeattendance::findOrFail($id);
        $attendance->rm_approval_status = 'Absent';
        $attendance->approve_by_rm = auth()->user()->id;
        $attendance->save();

        return redirect()->back()->with('success', 'Attendance marked as Absent.');
    }


// ======================================================================================
    // Track Leave Approval Status
// ======================================================================================

public function trackLeaveStatusofRm()
{
$user = auth()->user();
$employye = Subu::where('user_id', $user->id)->first();
$approvals = Leave::with('leavestatusofrm')->where('employee_id', $employye->id)->latest()->get();
return view('report_manager.leave_management.leave_status.leave_status', [
    'approvals' => $approvals,
    'RmName' => $employye->name,
]);
;
}

// ======================================================================================
    // Track Claim Approval Status
// ======================================================================================

public function trackClaimStatusofRm()
{
    $user = auth()->user();
    $employye = Subu::where('user_id', $user->id)->first();
    $approvals = Expenseclaim::with(['claimstatusofemployee', 'latestRejectionReason'])
                    ->where('employee_id', $employye->id)
                    ->latest()
                    ->get();

    return view('report_manager.claim_form.claim_status.claim_status', compact('approvals', 'employye'));
}





// ======================================================================================
     // Check leave balance
// ======================================================================================




    public function CheckLeaveofRm()
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

        return view('report_manager.leave_management.leavebalance.check_leave_balance', compact(
            'employee',
            'leaveBalance',
            'totalLopDays',
            'totalleaveTillYet',
            'totalleaveTakenPL',
            'totalleaveTakenSL',
            'totalleaveTakenLOP'
        ));
    }



// ======================================================================================
     // Approve permanent of employees
// ======================================================================================

public function ApprovePermanentstatusinRM()
{
    // Fetch all make-permanent requests with employee details
    $requests = Makepermanent::with('employee')->get();
    return view('report_manager.employee_management.approval_request.permanent', compact('requests'));
}
// RmController.php
public function updatePermanentStatus(Request $request, $id)
{
    $action = $request->input('action'); // rmapprove or rmreject
    $reason = $request->input('rejection_reason'); // Only for rmreject

    $requestEntry = Makepermanent::findOrFail($id);
    $requestEntry->rmstatus = $action;

    if ($action === 'rmreject') {
        $requestEntry->rm_rejection_reason = $reason;
    } else {
        $requestEntry->rm_rejection_reason = null;
    }

    $requestEntry->save();

    return back()->with('success', 'Request has been ' . ucfirst($action) . '.');
}



////////////////////////////////////payslip////////////////////////////////////

public function ListRmPayslip()
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

    return view('report_manager.payroll.rm_payslips_list', compact('years', 'months', 'employee'));

}


public function RmPayslipView(Request $request)
{
    $user = auth()->user();
// dd($request->toArray());
    // Retrieve the logged-in employee
    $employee = Subu::where('user_id', $user->id)->first();
    // dd($employee->toArray());

    if (!$employee) {
        return response()->json(['error' => 'Report Manager not found'], 404);
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

    return view('report_manager.payroll.view_rm_payslip', compact('payslip'));
}





/////////////////////////////////////update request/////////////////////////////////////

public function UpdateRequestOfRm()
 {
     $employee = Auth::user()->subu()->first();

     return view('report_manager.request.update_request', compact('employee'));
 }


 public function submitByRm(Request $request)
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
                'm_status' => 'mpending',
            ]);

            return back()->with('success', 'Account update request sent for hr manager approval');

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



 public function viewMyProfileStatus()
{
    $employee = Auth::user()->subu()->first();


    if (!$employee) {
        return redirect()->back()->with('error', 'No employee record found.');
    }

    // Fetch all profile update requests for this employee
    $requests = ProfileUpdateRequest::where('employee_id', $employee->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

    return view('report_manager.request_status.profile_update', compact('requests'));
}



public function viewMyaccountUpdates()
{
    $employee = Auth::user()->subu()->first();


    if (!$employee) {
        return redirect()->back()->with('error', 'No employee record found.');
    }

    // Fetch all profile update requests for this employee
    $requests = AccountUpdateRequest::where('employee_id', $employee->id)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

    return view('report_manager.request_status.account_update', compact('requests'));
}






}



