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
    $leaveBalanceData = LeaveBalance::where('employee_id', $employyeData->id)->first();
    $attendance = $employee->attendances()->latest()->first();

    $teamMembers = \App\Models\Subu::where('assigned_to', $employee->id)->get();

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
    return view('report_manager.my_dashboard', compact('employee', 'pendingLeaveCount', 'attendance', 'teamMembers', 'todayAttendanceData', 'leaveBalanceData', 'presentCount'));
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

        return view('report_manager.attendance.employee_attendance_list', compact('atens', 'employee', 'years', 'currentYear'));
    }


    public function AddRmAttendance()
    {
        $user = auth()->user();
        $employee = Subu::where('user_id', $user->id)->first();
        // return view('employee.employeeattendancerecord.add_employee_attendance_list');
    return view('report_manager.attendance.add_employee_attendance_list', compact('user', 'employee'));

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
    return view('report_manager.attendance.edit_employee_attendance_list', compact('aten'));
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
    $employee = Subu::find($request->employee_id);
    $leave_type = $request->reason;
    $total_days = $request->total_days;

    $leaveBalance = LeaveBalance::firstOrCreate(
        ['employee_id' => $request->employee_id, 'year' => now()->year],
        ['annual_leave_entitlement' => ($employee->employment_type == 'permanent' ? 18 : 0), 'pl_balance' => 18, 'sl_balance' => 3, 'lop_days' => 0]
    );

    if ($leave_type == 'PL' && $leaveBalance->pl_balance >= $total_days) {
        $leaveBalance->pl_balance -= $total_days;
    } elseif ($leave_type == 'SL' && $leaveBalance->sl_balance >= $total_days) {
        $leaveBalance->sl_balance -= $total_days;
    } else {
        $leave_type = 'LOP';
        $leaveBalance->lop_days += $total_days;
    }
    $leaveBalance->save();
    $request->validate([
        'employee_id' => 'required',
        'name' => 'required',
        'designation' => 'required',
        'department' => 'required',
        'leave_from' => 'required',
        'leave_to' => 'required',
        'total_days' => 'required',
        'reason' => 'required',
        'remarks' => 'nullable',
        // 'upload' => 'required'
        'upload' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
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
        'remarks' => $request->remarks,
        'status' => 'Pending',
        // 'upload' => $request->upload,
        'upload' => $uploadPath,
    ]);

    $notification = [
        'message' => 'leave apply successfully',
        'alert-type' => 'success'
    ];

    return redirect()->route('rmleave.apply')->with($notification);
    return back()->with('success', 'Leave applied successfully');
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
        'reimbursed' => 'required',
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
        'reimbursed' => 'required',
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
// dd($leave->toArray());
    // Check if leave was previously rejected by RM
    // if ($leave->rm_status == 'rmreject') {
    //     $employeeId = $leave->employee_id;
    //     $year = \Carbon\Carbon::parse($leave->leave_from)->year;

    //     $leaveBalance = LeaveBalance::where('employee_id', $employeeId)
    //         ->where('year', $year)
    //         ->first();

    //     if ($leaveBalance) {
    //         // Deduct PL again
    //         if ($leave->PL > 0) {
    //             $leaveBalance->pl_balance -= $leave->PL;
    //             if ($leaveBalance->pl_balance < 0) {
    //                 $leaveBalance->pl_balance = 0;
    //             }
    //         }

    //         // Deduct SL again
    //         if ($leave->SL > 0) {
    //             $leaveBalance->sl_balance -= $leave->SL;
    //             if ($leaveBalance->sl_balance < 0) {
    //                 $leaveBalance->sl_balance = 0;
    //             }
    //         }

    //         // Add LOP again
    //         if ($leave->LOP > 0) {
    //             $leaveBalance->lop_days += $leave->LOP;
    //         }

    //         $leaveBalance->save();
    //     }
    // }

    // Update RM approval status
    $leave->rm_status = 'rmapprove';
    $leave->save();

    return redirect()->back()->with('success', 'Leave Approved Successfully');
}


        public function rejectLeaveByRm($id)
{
    $leave = Leave::findOrFail($id);

    // Restore leave balances only if not already rejected
    // if ($leave->rm_status !== 'rmreject') {

    //     $employeeId = $leave->employee_id;
    //     $year = \Carbon\Carbon::parse($leave->leave_from)->year;

    //     $leaveBalance = LeaveBalance::where('employee_id', $employeeId)
    //         ->where('year', $year)
    //         ->first();

    //     if ($leaveBalance) {
    //         // Restore PL
    //         if ($leave->PL > 0) {
    //             $leaveBalance->pl_balance += $leave->PL;
    //         }

    //         // Restore SL
    //         if ($leave->SL > 0) {
    //             $leaveBalance->sl_balance += $leave->SL;
    //         }

    //         // Subtract LOP days if they were added
    //         if ($leave->LOP > 0) {
    //             $leaveBalance->lop_days -= $leave->LOP;

    //             // Just in case lop_days becomes negative
    //             if ($leaveBalance->lop_days < 0) {
    //                 $leaveBalance->lop_days = 0;
    //             }
    //         }

    //         $leaveBalance->save();
    //     }
    // }

    // Update leave status to rejected
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

    // Only restore leave if not already rejected
    // if ($leave->rm_status !== 'rmreject') {

    //     $employeeId = $leave->employee_id;
    //     $year = \Carbon\Carbon::parse($leave->leave_from)->year;

    //     $leaveBalance = LeaveBalance::where('employee_id', $employeeId)
    //         ->where('year', $year)
    //         ->first();

        // if ($leaveBalance) {
        //     // Restore PL
        //     if ($leave->PL > 0) {
        //         $leaveBalance->pl_balance += $leave->PL;
        //     }

        //     // Restore SL
        //     if ($leave->SL > 0) {
        //         $leaveBalance->sl_balance += $leave->SL;
        //     }

        //     // Reverse LOP
        //     if ($leave->LOP > 0) {
        //         $leaveBalance->lop_days -= $leave->LOP;
        //         if ($leaveBalance->lop_days < 0) {
        //             $leaveBalance->lop_days = 0;
        //         }
        //     }

        //     $leaveBalance->save();
        // }

        // Update leave status
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

public function AttendanceStatusinRm(Request $request)
{
    $managerId = auth()->user()->id;

    // Get current Subu (manager's employee profile)
    $employeedata = Subu::where('user_id', $managerId)->first();
    $employeeId = $employeedata->id;

    // Start query: only fetch attendance where employees are assigned to current report manager
    $attendQuery = Employeeattendance::whereHas('employeeattendancestatusinhrm', function ($query) use ($employeeId) {
        $query->where('assigned_to', $employeeId);
    });

    // Apply date filter if present
    if ($request->has('date') && $request->date) {
        $attendQuery->whereDate('date', $request->date);
    }

    // Execute query
    $attend = $attendQuery->latest()->get();

    return view('report_manager.employee_management.attendance_status.attendance_status', compact('attend'));
}




    public function approveAttendanceinRm($id)
    {
        $attendance = Employeeattendance::findOrFail($id);
        $attendance->manager_approval_status = 'Present';
        $attendance->approve_by_manager = auth()->user()->id;
        $attendance->save();

        return redirect()->back()->with('success', 'Attendance marked as Present.');
    }

    public function absentAttendanceinRm($id)
    {
        $attendance = Employeeattendance::findOrFail($id);
        $attendance->manager_approval_status = 'Absent';
        $attendance->approve_by_manager = auth()->user()->id;
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
return view('report_manager.leave_management.leave_status.leave_status', compact('approvals'));
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

    return view('report_manager.claim_form.claim_status.claim_status', compact('approvals'));
}





// ======================================================================================
     // Check leave balance
// ======================================================================================

public function CheckLeaveofRm()
    {
    return view('report_manager.leave_management.leavebalance.check_leave_balance');
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


}



