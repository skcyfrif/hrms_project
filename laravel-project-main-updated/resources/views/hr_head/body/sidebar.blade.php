<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            HR HEAD<span>Portal</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">

            <li class="nav-item nav-category">employee management</li>
            <a href="{{ route('hrhead.dashboard') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Dashboard</span>
            </a>
            <a href="{{ route('hrmanager.list') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Employee Directory</span>
            </a>


            <li class="nav-item nav-category">HR Head attendance</li>
            <a href="{{ route('hrhead.attendance') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Add Attendace</span>
            </a>

            <li class="nav-item nav-category">Leave</li>
            <a href="{{ route('hrheadleave.balance') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">check Leave Balance</span>
            </a>
            <a href="{{ route('hrheadleave.list') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Apply Leave</span>
            </a>
            <a href="{{ route('leave.status.hrhead') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Leave Status</span>
            </a>

            <li class="nav-item nav-category">claim</li>

            <a href="{{ route('claim.formhrhead') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Apply Claim</span>
            </a>
            <a href="{{ route('track.hrheadclaimapprovalstatus') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Claim Status</span>
            </a>



            <li class="nav-item nav-category">Leave Approval</li>
            {{-- <a href="#" class="nav-link"> --}}
            <a href="{{ route('approval.hrmleave') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Hr Manager Leave Approval</span>
            </a>

            <li class="nav-item nav-category">Claim Approval</li>
            <a href="{{ route('hrmclaimapproval.status') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Hr Manager Claim Approval</span>
            </a>


            <li class="nav-item nav-category">All Employee Status</li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#attendanceStatusMenu" role="button"
                    aria-expanded="false" aria-controls="attendanceStatusMenu">
                    <i class="link-icon" data-feather="clock"></i>
                    <span class="link-title">Attendance Status</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="attendanceStatusMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('hr_head.hr_managerattendances') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">HR Manager</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hr_head.rmattendances') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">Report Manager</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hrhead.employee.attendances') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="users"></i>
                                <span class="sub-menu-title">Employees</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#leaveStatusMenu" role="button"
                    aria-expanded="false" aria-controls="leaveStatusMenu">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Leave Status</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="leaveStatusMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('hr_head.hr_managersleaves') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">HR Manager</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hrhead.hrm.rm.leave') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">Report Manager</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hrhead.hrm.employee.leave') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="users"></i>
                                <span class="sub-menu-title">Employees</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#claimStatusMenu" role="button"
                    aria-expanded="false" aria-controls="claimStatusMenu">
                    <i class="link-icon" data-feather="file-text"></i>
                    <span class="link-title">Claim Status</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="claimStatusMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('hr_head.hr_managersclaim') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">HR Manager</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hrhead.hrm.rm.claim') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">Report Manager</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('hr_head.hrm.employee.claim') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="users"></i>
                                <span class="sub-menu-title">Employees</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item nav-category"> Request </li>
                    <a href="{{ route('update.request.hr') }}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Request Corner</span>
                    </a>


            <li class="nav-item nav-category"> Muster Roll </li>
                    <a href="{{ route('hr.hrm.payroll') }}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">payroll</span>
                    </a>
                    <a href="{{ route('hrmsalaries.lists') }}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Salary Structure</span>
                    </a>

            <li class="nav-item nav-category"> Payroll and Compensation </li>
                <a href="{{ route('hr.payslip') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">View Payslip</span>
                </a>


        </ul>
    </div>
</nav>


