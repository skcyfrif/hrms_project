<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\Backend\PropertyTypeController;
use App\Http\Controllers\homefoldercontroller\HomeController;
use App\Http\Controllers\hr\HrController;
use App\Http\Controllers\hrManager\HrManagerController;
use App\Http\Controllers\ReportingManager\RmController;
use App\Http\Controllers\EmployeeController;
// use App\Http\Controllers\subrat\SubContrller;
use App\Http\Controllers\employee\AeController;
use App\Http\Controllers\Salary\SalaryController;

use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/apply', [HrManagerController::class, 'StoreApply']);

Route::get('/apply-job', function () {
    return view('job-apply');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


//Admin Group middleware
Route::middleware(['auth' , 'role:admin'])->group(function(){

    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/dashboards', [AdminController::class, 'AdminDashboards'])->name('admin.dashboards');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
    Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
    Route::post('/admin/update/password', [AdminController::class, 'AdminUpdatePassword'])->name('admin.update.password');

     ////////////show all hr head////////////
   Route::get('/admin/hr-heads', [AdminController::class, 'viewAllHrHeads'])->name('admin.hr_heads');
   Route::get('/admin/hr-managers/{id}', [AdminController::class, 'viewManagersByHrHead'])->name('admin.hrhead.managers');
   Route::get('/admin/managers/{id}/employees', [AdminController::class, 'viewEmployeesByManager'])->name('admin.manager.employees');

   Route::get('/admin/employees/{id}', [AdminController::class, 'EmployeeView'])->name('admin.employee.details');
   Route::get('/admin/hrhead/{id}', [AdminController::class, 'HrHeadView'])->name('admin.hrhead.details');
   Route::get('/admin/hrmanager/{id}', [AdminController::class, 'HrManagerView'])->name('admin.hrmanager.details');
            // Route::get('subrat/view/{id}', 'SubView')->name('view.subu');

////////////show all hr head attendances////////////
Route::get('/admin/attendances/hr-heads', [AdminController::class, 'viewAllHrHeadsAttendances'])->name('admin.hr_headsattendances');
Route::get('/admin/attendances/hr-managers', [AdminController::class, 'viewAllHrmanagerAttendances'])->name('admin.hr_managersattendances');
Route::get('/admin/attendances/report-managers', [AdminController::class, 'viewAllreportmanagerAttendances'])->name('admin.report_managersattendances');
Route::get('/admin/attendances/employees', [AdminController::class, 'viewAllEmployeesAttendances'])->name('admin.employeesattendances');

///////////////////////////// download attendance reports /////////////////////////////

Route::get('admin/hrheadattendances/download', [AdminController::class, 'downloadHRHeadAttendanceReport'])->name('admin.download.hrheadattendances');
Route::get('admin/hrmanagerattendances/download', [AdminController::class, 'downloadHRMAttendanceReport'])->name('admin.download.hrmanagerattendances');
Route::get('admin/reportmanagerattendances/download', [AdminController::class, 'downloadRManagerAttendanceReport'])->name('admin.download.reportmanagerattendances');
Route::get('admin/employeesattendances/download', [AdminController::class, 'downloadEMPloyeeAttendanceReport'])->name('admin.download.employeesattendances');





Route::get('/admin/leaves/hr-heads', [AdminController::class, 'viewAllHrHeadsLeaves'])->name('admin.hr_headsleaves');
Route::get('/admin/leaves/hrm', [AdminController::class, 'viewAllHrmLeaves'])->name('admin.hrmleaves');
Route::get('/admin/leaves/rm', [AdminController::class, 'viewAllRmLeaves'])->name('admin.rmleaves');
Route::get('/admin/leaves/employees', [AdminController::class, 'viewAllEmployeeLeaves'])->name('admin.employeeleaves');


Route::get('/admin/claims/hr-heads', [AdminController::class, 'viewAllHrHeadsClaims'])->name('admin.hr_headsclaim');
Route::get('/admin/claims/hrm', [AdminController::class, 'viewAllHrmClaims'])->name('admin.hrmclaim');
Route::get('/admin/claims/rm', [AdminController::class, 'viewAllRmClaims'])->name('admin.rmclaim');
Route::get('/admin/claims/employee', [AdminController::class, 'viewAllEmployeeClaims'])->name('admin.employeeclaim');





    // Employee Management/Attendance Records

    Route::get('/employee/attendance/list', [AdminController::class, 'AttendanceList'])->name('attendance.list');
    Route::get('/add/attendance', [AdminController::class, 'AddAttendance'])->name('add.attendance');
    Route::post('/store/attendance', [AdminController::class, 'StoreAttendance'])->name('store.attendance');
    Route::get('/edit/attendance/{id}', [AdminController::class, 'EditAttendance'])->name('edit.attendance');
    Route::put('/update/attendance/{id}', [AdminController::class, 'UpdateAttendance'])->name('update.attendance');
    Route::get('/delete/attendance/{id}', [AdminController::class, 'DeleteAttendance'])->name('delete.attendance');
    Route::get('view/attendance', [AdminController::class, 'AttendanceView'])->name('view.attendance');




    // Reports and Analytics/Attendance Reports
    Route::get('attendance/reports', [AdminController::class, 'AttendanceReport'])->name('report.attendance');

    // Payroll Management/Payslip
    Route::get('/payslipss/list', [AdminController::class, 'PayslipList'])->name('mypayslip.list');
    Route::get('/add/payslipss', [AdminController::class, 'AddPayslip'])->name('add.payslip');
    Route::post('/store/payslipss', [AdminController::class, 'StorePayslip'])->name('store.payslip');
    Route::get('/edit/payslipss/{id}', [AdminController::class, 'EditPayslip'])->name('edit.payslip');
    Route::put('/update/payslipss/{id}', [AdminController::class, 'UpdatePayslip'])->name('update.payslip');
    Route::get('/delete/payslipss/{id}', [AdminController::class, 'DeletePayslip'])->name('delete.payslip');
    Route::get('/download/payslips/{id}', [AdminController::class, 'DownloadPayslip'])->name('download.payslip');



        // leave approval status of  hr head
        Route::get('/approve/leave/hrhead/', [AdminController::class, 'LeaveApprovalStatusofhrHead'])->name('approval.hrheadleave');
        Route::get('/hrhead/approve-leave/{id}', [AdminController::class, 'approveLeaveofhrHead'])->name('adminapprove.leave');
        Route::get('/hrhead/reject-leave/{id}', [AdminController::class, 'rejectLeaveofhrHead'])->name('adminreject.leave');
        Route::post('/hrheadreject-leave', [AdminController::class, 'rejectLeaveSubmitbyAdmin'])->name('adminreject.leave.submit');



        // claim approval status of  hr head
        Route::get('/approve/claim/hrhead/', [AdminController::class, 'ClaimApprovalStatustoHrhead'])->name('hrheadclaimapproval.status');
        Route::get('/hrhead/approve-claim/{id}', [AdminController::class, 'approveClaimOfHrhead'])->name('approve.claimss');
        Route::get('/hrhead/reject-claim/{id}', [AdminController::class, 'rejectClaimOfHrhead'])->name('reject.claimss');
        Route::post('/hrhead/reject-claim-submit', [AdminController::class, 'rejectClaimSubmitbyAdmin'])->name('reject.claimss.submit');

        Route::controller(AdminController::class)->group(function() {
            Route::get('/employee/subrat/list', 'SubList')->name('subrat.list');
            Route::get('/add/subrat', 'AddSub')->name('add.subu');
            Route::post('/store/subrat', 'StoreSub')->name('store.subu');
            Route::get('/edit/subrat/{id}', 'EditSub')->name('edit.subu');
            Route::post('/update-step', 'UpdateStep')->name('update.step');
            Route::get('/delete/subrat/{id}', 'DeleteSub')->name('delete.subu');
            Route::get('subrat/view/{id}', 'SubView')->name('view.subu');
            Route::get('subrat/offer/{id}', 'viewOfferLetter')->name('offer.subu');
        });


        Route::get('/admins/hr-heads', [AdminController::class, 'showHrHeads'])->name('admin.allhr_heads');
        Route::get('/admins/hr-managers', [AdminController::class, 'showHrM'])->name('admin.allhrm');
        Route::get('/admins/report-managers', [AdminController::class, 'ShowRM'])->name('admin.allrm');
        Route::get('/admins/employees', [AdminController::class, 'ShowEmply'])->name('admin.allemply');



        /////payroll/////
Route::get('/muster_roll/payroll/admin', [AdminController::class, 'PayrollListOfHr'])->name('admin.hr.payroll');

/////////////////////// salary structure of hr manager ///////////////////////
Route::controller(AdminController::class)->group(function() {
    Route::get('/hr/salaries/lists', 'HrSalaryLists')->name('hrsalaries.lists');
    Route::get('/adds/hr/salaries', 'HrAddSalaries')->name('add.hrsalaries');
    Route::post('/stores/hr/salaries', 'HrStoreSalaries')->name('store.hrsalaries');
    Route::get('/edits/hr/salaries/{id}', 'HrEditSalaries')->name('edit.hrsalaries');
    Route::put('/salaries/hr/updates-step/{id}', 'HrupdateSalaries')->name('update.hrsalaries');
    Route::get('/deletes/hr/salaries/{id}', 'HrDeleteSalaries')->name('delete.hrsalaries');
    Route::get('salaries/hr/views/{id}', 'HrSalaryView')->name('view.hrsalaries');
});


/////////////////////////////////////

        //  HR CONTROLLER

/////////////////////////////////////




}); //End Group admin middleware

Route::middleware(['auth' , 'role:head'])->group(function(){
    Route::get('/hr_head/dashboard', [HrController::class, 'HrheadDashboard'])->name('hr_head.dashboard');
    Route::get('/hr_head/dashboards', [HrController::class, 'HrheadDashboards'])->name('hrhead.dashboard');


    Route::get('/hr_head/profile', [HrController::class, 'HrheadProfile'])->name('hrhead.profile');
    Route::post('/hr_head/profile/store', [HrController::class, 'HrheadProfileStore'])->name('hrhead.profile.store');
    Route::get('/hr_head/change/password', [HrController::class, 'HrheadChangePassword'])->name('hrhead.change.password');
    Route::post('/hr_head/update/password', [HrController::class, 'HrheadUpdatePassword'])->name('hrhead.update.password');
    Route::get('/hr_head/logout', [HrController::class, 'HrheadLogout'])->name('hrhead.logout');
                            // add hrmanager
    Route::get('/hr_head/hr_manager/list', [HrController::class, 'HrmanagerList'])->name('hrmanager.list');
    Route::get('/hr_head/add_hr_manager', [HrController::class, 'AddHrManager'])->name('add.hrmanager');
    Route::post('/hr_head/store_hr_manager', [HrController::class, 'StoreHrManager'])->name('store.hrmanager');
    Route::get('/hr_head/edit_hr_manager/{id}', [HrController::class, 'EditHrManager'])->name('edit.hrmanager');
    Route::post('/hr_head/update_hr_manager/{id}', [HrController::class, 'UpdateHrManager'])->name('update.hrmanager');
    Route::get('/hr_head/delete_hr_manager/{id}', [HrController::class, 'DeleteHrManager'])->name('delete.hrmanager');
    Route::get('employees/view/{id}', [HrController::class, 'HrManagerView'])->name('view.employees');
    Route::get('employee/offer/{id}', [HrController::class, 'viewsOfferLetter'])->name('offer.employee');


    // add attendance of hr head
    Route::get('/hr_head/attendance', [HrController::class, 'HrHeadAttendanceList'])->name('hrhead.attendance');
    Route::get('/add/hr_head/attendance', [HrController::class, 'AddHrHeadAttendance'])->name('add.hrheadattendance');
    Route::post('/store/hr_head/attendance', [HrController::class, 'StoreHrHeadAttendance'])->name('store.hrheadattendance');
    Route::get('/edit/hr_head/attendance/{id}', [HrController::class, 'EditHrHeadAttendance'])->name('edit.hrheadattendance');
    Route::put('/update/hr_head/attendance/{id}', [HrController::class, 'UpdateHrHeadAttendance'])->name('update.hrheadattendance');
    Route::get('/delete/hr_head/attendance/{id}', [HrController::class, 'DeleteHrHeadAttendance'])->name('delete.hrheadattendance');


    //////////check leave balance of hrhead//////////

    Route::get('/hrhead/check-leave-balance', [HrController::class, 'CheckLeaveofHrHead'])->name('hrheadleave.balance');


// hrhead apply leave
Route::get('/hrhead/apply/leave/', [HrController::class, 'HrHeadlistLeave'])->name('hrheadleave.list');
Route::get('/hrhead/add/leave', [HrController::class, 'AddHrHeadLeave'])->name('add.hrheadleave');
Route::post('/hrhead/store/leave', [HrController::class, 'StoreHrHeadLeave'])->name('store.hrheadleave');
Route::get('/hrhead/edit/leave/{id}', [HrController::class, 'EdiHrHeadLeave'])->name('edit.hrheadleave');
Route::put('/hrhead/update/leave/{id}', [HrController::class, 'UpdateHrHeadLeave'])->name('update.hrheadleave');
Route::get('/hrhead/delete/leave/{id}', [HrController::class, 'DeleteHrHeadLeave'])->name('delete.hrheadleave');

// hrhead  leave status
Route::get('/hrhead/leave/status', [HrController::class, 'HrheadLeaveStatus'])->name('leave.status.hrhead');

////////////show all hr manager attendances////////////
Route::get('/hrmanager/attendances/status', [HrController::class, 'viewAllHrManagersAttendances'])->name('hr_head.hr_managerattendances');
Route::get('/rm/attendances/status', [HrController::class, 'viewAllRmAttendances'])->name('hr_head.rmattendances');
Route::get('/employee/attendances/status', [HrController::class, 'viewAllEmployeeAttendances'])->name('hrhead.employee.attendances');
////////////show all hr manager leaves////////////
Route::get('/hrmanager/leaves/status', [HrController::class, 'viewAllHrManagersLeaves'])->name('hr_head.hr_managersleaves');
Route::get('/reportmanagers/leaves/status', [HrController::class, 'viewAllReportManagersLeaves'])->name('hrhead.hrm.rm.leave');
Route::get('/employeess/leavess/statuss', [HrController::class, 'viewAllEmployeesLeaves'])->name('hrhead.hrm.employee.leave');

////////////show all hr manager leaves////////////
Route::get('/hrmanager/claim/status', [HrController::class, 'viewAllHrManagersClaim'])->name('hr_head.hr_managersclaim');
Route::get('/hrmanager/rm/claim/status', [HrController::class, 'viewAllReportManagerClaims'])->name('hrhead.hrm.rm.claim');
Route::get('/hrmanager/employee/claim/status', [HrController::class, 'viewAllEmployeesClaims'])->name('hr_head.hrm.employee.claim');

// view manager/all employee details button
    Route::get('/manager/{id}/employees', [HrController::class, 'viewAllEmployees'])->name('manager.employees');






/////////////////////// salary structure of hr manager ///////////////////////
Route::controller(HrController::class)->group(function() {
    Route::get('/hrm/salaries/lists', 'HrmSalaryLists')->name('hrmsalaries.lists');
    Route::get('/adds/hrm/salaries', 'HrmAddSalaries')->name('add.hrmsalaries');
    Route::post('/stores/hrm/salaries', 'HrmStoreSalaries')->name('store.hrmsalaries');
    Route::get('/edits/hrm/salaries/{id}', 'HrmEditSalaries')->name('edit.hrmsalaries');
    Route::put('/salaries/hrm/updates-step/{id}', 'HrmupdateSalaries')->name('update.hrmsalaries');
    Route::get('/deletes/hrm/salaries/{id}', 'HrmDeleteSalaries')->name('delete.hrmsalaries');
    Route::get('salaries/hrm/views/{id}', 'HrmSalaryView')->name('view.hrmsalaries');


});





        // leave status of  manager
        Route::get('/approve/leave/hrm/', [HrController::class, 'LeaveApprovalStatusofhrm'])->name('approval.hrmleave');
        Route::get('/hrm/approve-leave/{id}', [HrController::class, 'approveLeaveofHrm'])->name('hrapprove.leave');
        Route::get('/hrm/reject-leave/{id}', [HrController::class, 'rejectLeaveofHrm'])->name('hrmreject.leave');
        Route::post('/hrmmreject-leave', [HrController::class, 'rejectLeaveSubmitofHrm'])->name('hrreject.leave.submit');


            // Expense Claim Form of Hrhead
    Route::get('/Hrhead/claim/', [HrController::class, 'ListClaimFormofHrHead'])->name('claim.formhrhead');
    Route::get('/Hrhead/add/claim/', [HrController::class, 'AddClaimFormofHrHead'])->name('add.hrheadclaim');
    Route::post('/Hrhead/store/claim', [HrController::class, 'StoreclaimFormofHrHead'])->name('store.hrheadclaim');
    Route::get('/Hrhead/edit/claim/{id}', [HrController::class, 'EditClaimFormofHrHead'])->name('edit.hrheadclaim');
    Route::put('/Hrhead/update/claim/{id}', [HrController::class, 'UpdateClaimFormofHrHead'])->name('update.hrheadclaim');
    Route::get('/Hrhead/delete/claim/{id}', [HrController::class, 'DeleteClaimFormofHrHead'])->name('delete.hrheadclaim');

// claim approval status of  manager
        Route::get('/approve/claim/hrm/', [HrController::class, 'ClaimApprovalStatustoHrm'])->name('hrmclaimapproval.status');
        Route::get('/hrm/approve-claim/{id}', [HrController::class, 'approveClaimOfhrm'])->name('approve.claims');
        Route::get('/hrm/reject-claim/{id}', [HrController::class, 'rejectClaimOfhrm'])->name('reject.claims');
        Route::post('/hrm/reject-claim-submit', [HrController::class, 'rejectClaimSubmitbyHrHead'])->name('reject.claims.submit');

        Route::get('/hrhead/track/claim/approval/status', [HrController::class, 'trackClaimStatusofHrHead'])->name('track.hrheadclaimapprovalstatus');

        Route::get('/request/hrhead_update_request', [HrController::class, 'UpdateRequestHr'])->name('update.request.hr');
        Route::post('/submit-form/hrhead', [HrController::class, 'submitByHrHead'])->name('forms.submit');

////////////////////////////payroll////////////////////////////

        Route::get('/muster_roll/payroll/hr', [HrController::class, 'PayrollListOfHrm'])->name('hr.hrm.payroll');


///////////view payslip/////////////

Route::get('/hr/payslip', [HrController::class, 'PayslipPageHr'])->name('hr.payslip');
Route::get('/payslip/hr/views', [HrController::class, 'HrPayslipView'])->name('view.hrpayslip');



    Route::get('/hr/hrmattendance/report/download', [HrController::class, 'downloadHrmAttendanceReport'])->name('hr.download.hrmattendance');
    Route::get('/hr/rmattendance/report/download', [HrController::class, 'DownloadRMAttendanceReport'])->name('hr.download.rmattendance');
    Route::get('/hr/employeeattendance/report/download', [HrController::class, 'DownloadEmpLoyeeAttendanceReport'])->name('hr.download.employeeattendance');




});
Route::middleware(['auth' , 'role:manager'])->group(function(){
    Route::get('/hr_manager/dashboard', [HrManagerController::class, 'HrmanagerDashboard'])->name('hr_manager.dashboard');
    Route::get('/hr_manager/dashboards', [HrManagerController::class, 'HrmanagerDashboards'])->name('hrmng.dashboard');

                            // employee directory
    Route::get('/employee/list', [HrManagerController::class, 'EmployeeList'])->name('employee.list');
    Route::get('/add/employee/list', [HrManagerController::class, 'AddEmployee'])->name('add.employee');
    Route::post('/store/employee/list', [HrManagerController::class, 'StoreEmployee'])->name('store.employee');
    Route::get('/edit/employee/{id}', [HrManagerController::class, 'EditEmployee'])->name('edit.employee');
    Route::post('/update-employee', [HrManagerController::class, 'UpdateEmployee'])->name('update.employee');
    Route::get('/delete/employee/{id}', [HrManagerController::class, 'DeleteEmployee'])->name('delete.employee');
    Route::get('/employee/views/{id}', [HrManagerController::class, 'EmployeeView'])->name('view.employee');

    Route::get('/get-report-managers', [HrManagerController::class, 'getReportManagers'])->name('get.report.managers');

    // salary structure of employees
    Route::controller(HrManagerController::class)->group(function() {
        Route::get('/salaries/lists', 'EmpSalaryLists')->name('empsalaries.lists');
        Route::get('/adds/salaries', 'EmpAddSalaries')->name('add.empsalaries');
        Route::post('/stores/salaries', 'EmpStoreSalaries')->name('store.empsalaries');
        Route::get('/edits/salaries/{id}', 'EmpEditSalaries')->name('edit.empsalaries');
        Route::put('/salaries/updates-step/{id}', 'EmpupdateSalaries')->name('update.empsalaries');
        Route::get('/deletes/salaries/{id}', 'EmpDeleteSalaries')->name('delete.empsalaries');
        Route::get('salaries/views/{id}', 'EmpSalaryView')->name('view.empsalaries');


    });

    // Report Manager directory
    Route::get('/reportmanager/list', [HrManagerController::class, 'ReportManagerList'])->name('reportmanager.list');
    Route::get('/add/reportmanager/list', [HrManagerController::class, 'AddReportManager'])->name('add.reportmanager');
    Route::post('/store/reportmanager/list', [HrManagerController::class, 'StoreReportManager'])->name('store.reportmanager');
    Route::get('/edit/reportmanager/{id}', [HrManagerController::class, 'EditReportManager'])->name('edit.reportmanager');
    Route::post('/update-reportmanager', [HrManagerController::class, 'UpdateReportManager'])->name('update.reportmanager');
    Route::get('/delete/reportmanager/{id}', [HrManagerController::class, 'DeleteReportManager'])->name('delete.reportmanager');
    Route::get('/reportmanager/views/{id}', [HrManagerController::class, 'ReportManagerView'])->name('view.reportmanager');


    Route::get('/manager/profile', [HrManagerController::class, 'ManagerProfile'])->name('manager.profile');
    Route::post('/manager/profile/store', [HrManagerController::class, 'ManagerProfileStore'])->name('manager.profile.store');
    Route::get('/manager/change/password', [HrManagerController::class, 'ManagerChangePassword'])->name('manager.change.password');
    Route::post('/manager/update/password', [HrManagerController::class, 'ManagerUpdatePassword'])->name('manager.update.password');
    Route::get('/manager/logout', [HrManagerController::class, 'ManagerLogout'])->name('manager.logout');


    // leave status of employees
    Route::get('/approve/leave/employee/', [HrManagerController::class, 'LeaveApprovalStatus'])->name('approval.status');
    Route::get('/approve-leave/{id}', [HrManagerController::class, 'approveLeave'])->name('mapprove.leave');
    Route::get('/reject-leave/{id}', [HrManagerController::class, 'rejectLeave'])->name('mreject.leave');
    Route::post('/mreject-leave', [HrManagerController::class, 'rejectLeaveSubmit'])->name('mreject.leave.submit');



    // leave status of reporting manager
    Route::get('/approve/leave/rm/', [HrManagerController::class, 'LeaveApprovalStatusOfRm'])->name('approval.rmstatus');
    Route::get('/rm/approve-leave/{id}', [HrManagerController::class, 'approveLeaveOfRm'])->name('mapprove.leave');
    Route::get('/rm/reject-leave/{id}', [HrManagerController::class, 'rejectLeaveOfRm'])->name('mreject.leave');
    Route::post('/rm/mreject-leave', [HrManagerController::class, 'rejectLeaveSubmitbyHrm'])->name('mreject.leave.submit');



    // claim status of employees
    Route::get('/approve/claim/employee/', [HrManagerController::class, 'ClaimApprovalStatusofUser'])->name('claimapproval.status');

    Route::get('/approve/claim/rm/', [HrManagerController::class, 'ClaimApprovalStatustoRm'])->name('rmclaimapproval.status');
    Route::get('/approve-claim/{id}', [HrManagerController::class, 'approveClaim'])->name('approve.claim');
    Route::get('/reject-claim/{id}', [HrManagerController::class, 'rejectClaim'])->name('reject.claim');
    Route::post('/reject-claim-submit', [HrManagerController::class, 'rejectClaimSubmit'])->name('reject.claim.submit');






    // attendance status of employees
   Route::get('/attendance-status-all_employee', [HrManagerController::class, 'AttendanceStatusinHrm'])->name('attendance.statusihnrm');


   Route::get('/hrm/rm/attendances/status', [HrManagerController::class, 'viewRmAttendances'])->name('hrm.rm.attendance');
   Route::get('/hrm/employee/attendances/status', [HrManagerController::class, 'viewEmployeeAttendances'])->name('hrm.employee.attendance');

   //////////download attendance report of employees//////////
    Route::get('/hrm/employeeattendance/report/download', [HrManagerController::class, 'downloadEmployeeAttendanceReport'])->name('hrm.download.employeeattendance');
    Route::get('/hrm/rmattendance/report/download', [HrManagerController::class, 'downloadRmAttendanceReport'])->name('hrm.download.rmattendance');


    Route::get('/attendance/approve/{id}', [HRManagerController::class, 'approveAttendance'])->name('attendance.approve');
    Route::get('/attendance/absent/{id}', [HRManagerController::class, 'absentAttendance'])->name('attendance.absent');
// attendance of hrm
    Route::get('/hrm/attendance', [HrManagerController::class, 'HrmAttendanceList'])->name('hrm.attendance');
    Route::get('/hrm/attendance/list', [HrManagerController::class, 'HrmAttendanceList'])->name('hrm.attendance.list');

    Route::get('/add/hrm/attendance', [HrManagerController::class, 'AddHrmAttendance'])->name('add.hrmattendance');
    Route::post('/store/hrm/attendance', [HrManagerController::class, 'StoreHrmAttendance'])->name('store.hrmattendance');
    Route::get('/edit/hrm/attendance/{id}', [HrManagerController::class, 'EditHrmAttendance'])->name('edit.hrmattendance');
    Route::put('/updatee/hrm/attendance/{id}', [HrManagerController::class, 'UpdateHrmAttendance'])->name('update.hrmattendance');
    Route::get('/delete/hrm/attendance/{id}', [HrManagerController::class, 'DeleteHrmAttendance'])->name('delete.hrmattendance');

    //////////check leave balance of hrm//////////

   Route::get('/hrm/check-leave-balance', [HrManagerController::class, 'CheckLeaveofHrm'])->name('hrmleave.balance');


    // hrm apply leave
    Route::get('/hrm/apply/leave/', [HrManagerController::class, 'HrmlistLeave'])->name('hrmanagerleave.list');
    Route::get('/hrm/add/leave', [HrManagerController::class, 'AddHrmLeave'])->name('add.hrmanagerleave');
    Route::post('/hrm/store/leave', [HrManagerController::class, 'StoreHrmLeave'])->name('store.hrmanagerleave');
    Route::get('/hrm/edit/leave/{id}', [HrManagerController::class, 'EdiHrmLeave'])->name('edit.hrmanagerleave');
    Route::put('/hrm/update/leave/{id}', [HrManagerController::class, 'UpdateHrmLeave'])->name('update.hrmanagerleave');
    Route::get('/hrm/delete/leave/{id}', [HrManagerController::class, 'DeleteHrmLeave'])->name('delete.hrmanagerleave');


    // leave status of hrm
    Route::get('/hrm/leave/status', [HrManagerController::class, 'HrmLeaveStatus'])->name('leave.status.hrm');


    // Expense Claim Form of Hrm
    Route::get('/Hrm/claim/', [HrManagerController::class, 'ListClaimForm'])->name('claim.formhrm');
    Route::get('/Hrm/add/claim/', [HrManagerController::class, 'AddClaimForm'])->name('add.hrmclaim');
    Route::post('/Hrm/store/claim', [HrManagerController::class, 'StoreclaimForm'])->name('store.hrmclaim');
    Route::get('/Hrm/edit/claim/{id}', [HrManagerController::class, 'EditClaimForm'])->name('edit.hrmclaim');
    Route::put('/Hrm/update/claim/{id}', [HrManagerController::class, 'UpdateClaimForm'])->name('update.hrmclaim');
    Route::get('/Hrm/delete/claim/{id}', [HrManagerController::class, 'DeleteClaimForm'])->name('delete.hrmclaim');

// track claim approval status
   Route::get('/hrm/track/claim/approval/status', [HrManagerController::class, 'trackClaimStatusofHrm'])->name('track.hrmclaimapprovalstatus');




    // carrer portal
    // apply


    // Route::get('/carrerportal', [HrManagerController::class, 'ApplyinJobSite']);


    Route::get('/apply/candidate/list/', [HrManagerController::class, 'ApplyListing'])->name('apply.list');
    Route::get('/add/apply/candidate/list/', [HrManagerController::class, 'AddApply'])->name('add.apply');
    Route::post('/apply/store/leave', [HrManagerController::class, 'StoreApply'])->name('store.apply');
    Route::get('/apply/edit/leave/{id}', [HrManagerController::class, 'EditApply'])->name('edit.apply');
    Route::put('/apply/update/leave/{id}', [HrManagerController::class, 'UpdateApply'])->name('update.apply');
    Route::get('/apply/delete/leave/{id}', [HrManagerController::class, 'DeleteApply'])->name('delete.apply');

    //interview details
    Route::get('/candidate/details/list/', [HrManagerController::class, 'CandidateListing'])->name('candidate.list');

    Route::get('/schedule-interview/add/{id}', [HrManagerController::class, 'scheduleInterview'])->name('schedule.interview');
    // Route::get('/reschedule-interview/{id}', [HrManagerController::class, 'scheduleInterview'])->name('reschedule.interview');
    Route::get('/reschedule-interview/{id}', [HrManagerController::class, 'EditScheduled'])->name('rescheduled.candidate');
    Route::post('/interview/update-step', [HrManagerController::class, 'UpdateScheduled'])->name('update.candidate');
    // Route::get('/edit/subrat/{id}', 'EditSub')->name('edit.subu');
    // Route::post('/update-step', 'UpdateScheduled')->name('update.candidate');

    Route::post('/store/interview', [HrManagerController::class, 'storeInterview'])->name('store.interview');

    //interview Scheduled details
    Route::get('/candidate/interview/list/', [HrManagerController::class, 'InterviewScheduledListing'])->name('interview.list');
    //shortlist details
    Route::get('/shortlisted/candidate/list/', [HrManagerController::class, 'ShortListing'])->name('short.listing');
    Route::get('/shortlist/{id}', [HrManagerController::class, 'shortlistCandidate'])->name('shortlist.candidate');

    Route::get('/intern/offer/{id}', [HrManagerController::class, 'viewOfferLetterForIntern'])->name('offer.intern');
    Route::get('/full/offer/{id}', [HrManagerController::class, 'viewOfferLetterForFullTime'])->name('offer.fulltime');


    // Route::get('subrat/offer/{id}', 'viewOfferLetter')->name('offer.subu');


    Route::get('/hold/{id}', [HrManagerController::class, 'holdCandidate'])->name('hold.candidate');
    Route::get('/reject/{id}', [HrManagerController::class, 'rejectCandidate'])->name('reject.candidate');
    Route::get('/rejects/{id}', [HrManagerController::class, 'RejectCandidatesfromHoldPage'])->name('reject.candidates');

    //holding details
    Route::get('/hold/candidate/list/', [HrManagerController::class, 'HoldListing'])->name('hold.listing');
    Route::get('/reschedule-candidate/{id}', [HrManagerController::class, 'ReSchedule'])->name('reschedule.interview');
    // Route::get('/hold/reschedule-interview/{id}', [HrManagerController::class, 'EditRScheduled'])->name('rescheduled.interview');
    // Route::post('/hold/interview/update-step', [HrManagerController::class, 'UpdateReScheduled'])->name('update.candidate');


    //reject details
    Route::get('/reject/candidate/list/', [HrManagerController::class, 'RejectListing'])->name('reject.listing');

    // Route::get('/accrue-leave', [HrManagerController::class, 'accrueLeave'])->name('accrueLeave');
    Route::get('/accrue-leave', [HrManagerController::class, 'accrueLeave'])->name('accrueLeave');


    Route::get('/payroll/generate/{year_month}', [HrManagerController::class, 'generatePayroll'])->name('payroll.generate');
    Route::get('/muster_roll/payroll/', [HrManagerController::class, 'PayrollList'])->name('all.payroll');


//    permanent request status
Route::get('/hrm/permanent/request/status', [HrManagerController::class, 'ApprovePermanentstatusinHRM'])->name('permanent.Status.employee');
Route::post('/hrm/approve/permanent/{id}', [HrManagerController::class, 'updatePermanentStatusinHRM'])->name('hrm.mapprove.permanent');



Route::get('/request/update_request', [HrManagerController::class, 'UpdateRequest'])->name('update.request');
Route::post('/submit-form/hrm', [HrManagerController::class, 'submitByHrm'])->name('form.submits');



///////////view payslip/////////////

Route::get('/hrm/payslip', [HrManagerController::class, 'PayslipPage'])->name('hrm.payslip');
Route::get('/payslip/hrm/views', [HrManagerController::class, 'HrmPayslipView'])->name('view.hrmpayslip');


});

Route::middleware(['auth' , 'role:user'])->group(function(){
    Route::get('/employee/dashboard', [EmployeeController::class, 'EmployeeDashboard'])->name('employee.dashboard');
    Route::get('/employee/dashboards', [EmployeeController::class, 'EmployeeDashboards'])->name('employees.dashboard');
    // profile page
    Route::get('/employee/profile', [EmployeeController::class, 'EmployeeProfile'])->name('employee.profile');
    Route::post('/employee/profile/store', [EmployeeController::class, 'EmployeeProfileStore'])->name('employee.profile.store');
    Route::get('/employee/change/password', [EmployeeController::class, 'EmployeeChangePassword'])->name('employee.change.password');
    Route::post('/employee/update/password', [EmployeeController::class, 'EmployeeUpdatePassword'])->name('employee.update.password');
    Route::get('/employee/logout', [EmployeeController::class, 'EmployeeLogout'])->name('employee.logout');

    Route::get('/employee/payslip', [EmployeeController::class, 'ListPaylip'])->name('payslip');
    Route::get('/employee/attendance', [EmployeeController::class, 'EmployeeAttendance'])->name('employee.attendance');
    Route::get('/employee/attendance/list', [EmployeeController::class, 'EmployeeAttendance'])->name('employee.attendance.list');

    Route::get('/add/employee/attendance', [EmployeeController::class, 'AddEmployeeAttendance'])->name('add.employeeattendance');
    Route::post('/store/employee/attendance', [EmployeeController::class, 'StoreEmployeeAttendance'])->name('store.employeeattendance');
    Route::get('/edit/employee/attendance/{id}', [EmployeeController::class, 'EditEmployeeAttendance'])->name('edit.employeeattendance');
    Route::put('/updatee/mployee/attendance/{id}', [EmployeeController::class, 'UpdateEmployeeAttendance'])->name('update.employeeattendance');
    Route::get('/delete/employee/attendance/{id}', [EmployeeController::class, 'DeleteEmployeeAttendance'])->name('delete.employeeattendance');

    // apply leave
    Route::get('/employee/leave', [EmployeeController::class, 'ListLeave'])->name('leave.apply');
    Route::get('/employee/add/leave', [EmployeeController::class, 'AddLeave'])->name('add.leave');
    Route::post('/employee/store/leave', [EmployeeController::class, 'StoreLeave'])->name('store.leave');
    Route::get('/employee/edit/leave/{id}', [EmployeeController::class, 'EdiLeave'])->name('edit.leave');
    Route::put('/employee/update/leave/{id}', [EmployeeController::class, 'UpdateLeave'])->name('update.leave');
    Route::get('/employee/delete/leave/{id}', [EmployeeController::class, 'DeleteLeave'])->name('delete.leave');


    // Check leave balance
    Route::get('/employee/leave/balance', [EmployeeController::class, 'CheckLeave'])->name('check.leave');

    // Track Approval Leave Status of employees
    // Route::get('/employee/track/approval/status', [EmployeeController::class, 'TrackkApprovalStatus'])->name('track.approvalstatus');
    Route::get('/employee/track/leave/approval/status', [EmployeeController::class, 'trackLeaveStatus'])->name('track.approvalstatus');
    Route::get('/employee/track/claim/approval/status', [EmployeeController::class, 'trackClaimStatus'])->name('track.claimapprovalstatus');

    Route::get('/downloads/payslipss/{id}', [EmployeeController::class, 'DownPayslip'])->name('download.mypayslip');




    // Employee Pay Slip
    Route::get('/employee/payslip/', [EmployeeController::class, 'ListPaylip'])->name('payslip');
    Route::get('/payslip/employee/views', [EmployeeController::class, 'EmpPayslipView'])->name('view.mypayslip');



    // Expense Claim Form
    Route::get('/employee/claim/', [EmployeeController::class, 'ListClaim'])->name('claim.form');
    Route::get('/employee/add/claim/', [EmployeeController::class, 'AddClaim'])->name('add.claim');
    Route::post('/employee/store/claim', [EmployeeController::class, 'Storeclaim'])->name('store.claim');
    Route::get('/employee/edit/claim/{id}', [EmployeeController::class, 'EditClaim'])->name('edit.claim');
    Route::put('/employee/update/claim/{id}', [EmployeeController::class, 'UpdateClaim'])->name('update.claim');
    Route::get('/employee/delete/claim/{id}', [EmployeeController::class, 'DeleteClaim'])->name('delete.claim');
    Route::get('/check-leave-balance', [EmployeeController::class, 'checkLeaveBalance'])->name('check.leave.balance');



    // make permanent
    Route::get('/make_permanent/request', [EmployeeController::class, 'MakePermanent'])->name('make.permanent');
    Route::post('/submit-form', [EmployeeController::class, 'submit'])->name('form.submit');
    Route::get('/employee/request/make-permanent', [EmployeeController::class, 'showMakePermanentForm'])->name('make.permanent.form');
    // Route::get('/employee/request/make-permanent', [RequestController::class, 'showMakePermanentForm'])->name('make.permanent.form');






});
Route::get('/employee/details/{employee_id}', [HrManagerController::class, 'getallEmployeeDetails']);
Route::get('/employee/detailed/{employee_id}', [SalaryController::class, 'getallEmployeeDetailed']);
// Route::get('/employee/details/{employee_id}', [SalaryController::class, 'getHrManagerDetails']);
// Route::get('/hrmanager/details/{employee_id}', [SalaryController::class, 'getAllHrManagers']);
// Route::get('/particularemployee/details/{employee_id}', [EmployeeController::class, 'getEmployeeDetails']);



//Agent Group middleware
Route::middleware(['auth' , 'role:agent'])->group(function(){

    Route::get('/agent/dashboard', [AgentController::class, 'AgentDashboard'])->name('agent.dashboard');


}); //End Group agent middleware



Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');

//Admin Group middleware
Route::middleware(['auth' , 'role:admin'])->group(function(){

    //Property type all route
    Route::controller(PropertyTypeController::class)->group(function(){
        Route::get('/all/type', 'AllType')->name('all.type');
        Route::get('/add/type', 'AddType')->name('add.type');
        Route::post('/store/type', 'StoreType')->name('store.type');
        Route::get('/edit/type/{id}', 'EditType')->name('edit.type');
        Route::post('/update/type', 'UpdateType')->name('update.type');
        Route::get('/delete/type/{id}', 'DeleteType')->name('delete.type');


    });

    //Amenities  all route
    Route::controller(PropertyTypeController::class)->group(function(){
        Route::get('/all/amenitie', 'AllAmenitie')->name('all.amenitie');
        Route::get('/add/amenitie', 'AddAmenitie')->name('add.amenitie');
        Route::post('/store/amenitie', 'StoreAmenitie')->name('store.amenitie');
        Route::get('/edit/amenitie/{id}', 'EditAmenitie')->name('edit.amenitie');
        Route::post('/update/amenitie', 'UpdateAmenitie')->name('update.amenitie');
        Route::get('/delete/amenitie/{id}', 'DeleteAmenitie')->name('delete.amenitie');


    });

    //  Permission  all route
    Route::controller(RoleController::class)->group(function(){
        Route::get('/all/permission', 'AllPermission')->name('all.permission');
        Route::get('/add/permission', 'AddPermission')->name('add.permission');
        Route::post('/store/permission', 'StorePermission')->name('store.permission');
        Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');
        Route::post('/update/permission', 'UpdatePermission')->name('update.permission');
        Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');

        Route::get('/import/permission', 'ImportPermission')->name('import.permission');

        Route::get('/export', 'Export')->name('export');
        Route::post('/import', 'Import')->name('import');
    });


    //  Role  all route
    Route::controller(RoleController::class)->group(function(){
        Route::get('/all/role', 'AllRole')->name('all.role');
        Route::get('/add/role', 'AddRole')->name('add.role');
        Route::post('/store/role', 'StoreRole')->name('store.role');
        Route::get('/edit/role/{id}', 'EditRole')->name('edit.role');
        Route::post('/update/role', 'UpdateRole')->name('update.role');
        Route::get('/delete/role/{id}', 'DeleteRole')->name('delete.role');

        Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');
        Route::post('/store/roles/permission', 'StoreRolesPermission')->name('store.roles.permission');
        Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');

        Route::get('/admin/edit/role/{id}', 'AdminEditRoles')->name('admin.edit.role');
        Route::get('/admin/delete/role/{id}', 'AdminDeleteRoles')->name('admin.delete.role');

        Route::post('/admin/roles/update', 'AdminRolesUpdate')->name('admin.roles.update');

    });

    //Admin user all route
    Route::controller(AdminController::class)->group(function(){
        Route::get('/all/admin' , 'AllAdmin')->name('all.admin');
        Route::get('/add/admin' , 'AddAdmin')->name('add.admin');


    });


}); //End Group admin middleware





Route::controller(SalaryController::class)->group(function() {
    Route::get('/salary/list', 'SalaryList')->name('salary.list');
    Route::get('/add/salary', 'AddSalary')->name('add.salary');
    Route::post('/store/salary', 'StoreSalary')->name('store.salary');
    Route::get('/edit/salary/{id}', 'EditSalary')->name('edit.salary');
    Route::put('/update-step/{id}', 'updateSalary')->name('update.salary');
    Route::get('/delete/salary/{id}', 'DeleteSalary')->name('delete.salary');
    Route::get('salary/view', 'SalaryView')->name('view.salary');


});


Route::controller(HrController::class)->group(function() {
    Route::get('hr/list', 'HrList')->name('hr.list');
    Route::get('add/hr', 'AddHr')->name('add.hr');
    Route::post('/store/hr', 'StoreHr')->name('store.hr');
    Route::get('/edit/hr/{id}', 'EditHr')->name('edit.hr');
    Route::put('/update/hr/{id}', 'UpdateHr')->name('update.hr');
    Route::get('/delete/hr/{id}', 'DeleteHr')->name('delete.hr');



});


Route::middleware(['auth' , 'role:reportmanager'])->group(function(){
    Route::get('/report_manager/dashboard', [RmController::class, 'ReportmanagerDashboard'])->name('report_manager.dashboard');
    Route::get('/report_managers/dashboards', [RmController::class, 'ReportmanagerDashboards'])->name('rm.dashboard');
    // profile page
    Route::get('/reportmanager/profile', [RmController::class, 'ReportManagerProfile'])->name('reportmanager.profile');
    Route::post('/reportmanager/profile/store', [RmController::class, 'ReportManagerProfileStore'])->name('reportmanager.profile.store');
    Route::get('/reportmanager/change/password', [RmController::class, 'ReportManagerChangePassword'])->name('reportmanager.change.password');
    Route::post('/reportmanager/update/password', [RmController::class, 'ReportManagerUpdatePassword'])->name('reportmanager.update.password');
    Route::get('/reportmanager/logout', [RmController::class, 'ReportmanagerLogout'])->name('reportmanager.logout');


    // attendance of reporting manager
    Route::get('/reportmanager/attendance', [RmController::class, 'RmAttendance'])->name('rm.attendance');
    Route::get('/rm/attendance/list', [RmController::class, 'RmAttendance'])->name('rm.attendance.list');


    Route::get('/add/reportmanager/attendance', [RmController::class, 'AddRmAttendance'])->name('add.rmattendance');
    Route::post('/store/reportmanager/attendance', [RmController::class, 'StoreRmAttendance'])->name('store.rmattendance');
    Route::get('/edit/reportmanager/attendance/{id}', [RmController::class, 'EditRmAttendance'])->name('edit.rmattendance');
    Route::put('/updatee/reportmanager/attendance/{id}', [RmController::class, 'UpdateRmAttendance'])->name('update.rmattendance');
    Route::get('/delete/reportmanager/attendance/{id}', [RmController::class, 'DeleteRmAttendance'])->name('delete.rmattendance');


    // apply leave
    Route::get('/reportmanager/leave', [RmController::class, 'ListRmLeave'])->name('rmleave.apply');
    Route::get('/reportmanager/add/leave', [RmController::class, 'AddRmLeave'])->name('add.rmleave');
    Route::post('/reportmanager/store/leave', [RmController::class, 'StoreRmLeave'])->name('store.rmleave');
    Route::get('/reportmanager/edit/leave/{id}', [RmController::class, 'EdiRmLeave'])->name('edit.rmleave');
    Route::put('/reportmanager/update/leave/{id}', [RmController::class, 'UpdateRmLeave'])->name('update.rmleave');
    Route::get('/reportmanager/delete/leave/{id}', [RmController::class, 'DeleteRmLeave'])->name('delete.rmleave');


    // Expense Claim Form
    Route::get('/reportmanager/claim/', [RmController::class, 'ListRmClaim'])->name('rmclaim.form');
    Route::get('/reportmanager/add/claim/', [RmController::class, 'AddRmClaim'])->name('add.rmclaim');
    Route::post('/reportmanager/store/claim', [RmController::class, 'StoreRmclaim'])->name('store.rmclaim');
    Route::get('/reportmanager/edit/claim/{id}', [RmController::class, 'EditRmClaim'])->name('edit.rmclaim');
    Route::put('/employereportmanagere/update/claim/{id}', [RmController::class, 'UpdateRmClaim'])->name('update.rmclaim');
    Route::get('/reportmanager/delete/claim/{id}', [RmController::class, 'DeleteRmClaim'])->name('delete.rmclaim');

// all assigned employee
    Route::get('/assigned-employees', [RmController::class, 'assignedEmployees'])->name('assigned.employees');

// leave status of employees in reporting manager
Route::get('/approve/leave/reportmanager/employee/', [RmController::class, 'LeaveApprovalByRm'])->name('rmapproval.status');
Route::get('/reportmanager/approve-leave/{id}', [RmController::class, 'approveLeaveByRm'])->name('rmapprove.leave');
Route::get('/reportmanager/reject-leave/{id}', [RmController::class, 'rejectLeaveByRm'])->name('rmreject.leave');
Route::post('/rmreject-leave', [RmController::class, 'rejectLeaveSubmitbyRm'])->name('rmreject.leave.submit');


   // attendance status of employees in rm
//    Route::get('/attendance-status-rm', [RmController::class, 'AttendanceStatusinRm'])->name('attendance.statusinrm');


   Route::get('/rm/employee/attendances/status', [RmController::class, 'viewEmployeeAttendancesStatuses'])->name('rm.employee.attendance');




   Route::get('/reportmanager/attendance/approve/{id}', [RmController::class, 'approveAttendanceinRm'])->name('attendanceinrm.approve');
   Route::get('/reportmanager/attendance/absent/{id}', [RmController::class, 'absentAttendanceinRm'])->name('attendanceinrm.absent');
// leave approval status of rm
   Route::get('/rm/track/leave/approval/status', [RmController::class, 'trackLeaveStatusofRm'])->name('track.rmleaveapprovalstatus');
   Route::get('/rm/track/claim/approval/status', [RmController::class, 'trackClaimStatusofRm'])->name('track.rmclaimapprovalstatus');

   Route::get('/rm/check-leave-balance', [RmController::class, 'CheckLeaveofRm'])->name('rmleave.balance');

//    permanent request status
    Route::get('/rm/permanent/request/status', [RmController::class, 'ApprovePermanentstatusinRM'])->name('permanent.Status');
    Route::post('/rm/approve/permanent/{id}', [RmController::class, 'updatePermanentStatus'])->name('rm.rmapprove.permanent');


    Route::get('/rm/payslip/', [RmController::class, 'ListRmPayslip'])->name('rm.payslip');
    Route::get('/rm/payslip/views', [RmController::class, 'RmPayslipView'])->name('view.rmpayslip');


Route::get('rm/employee/attendance/download', [RmController::class, 'downloadEmployeeAttendanceReports'])->name('rm.download.employeeattendance');



});

