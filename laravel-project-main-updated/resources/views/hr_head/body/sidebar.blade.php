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
            </li>

            <li class="nav-item nav-category">HR Head attendance</li>
            <a href="{{ route('hrhead.attendance') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Add Attendace</span>
            </a>
            </li>
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
            </li>
            <li class="nav-item nav-category">claim</li>

            <a href="{{ route('claim.formhrhead') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Apply Claim</span>
            </a>
            <a href="{{ route('track.hrheadclaimapprovalstatus') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Claim Status</span>
            </a>
            </li>


            <li class="nav-item nav-category">Leave Approval</li>
            {{-- <a href="#" class="nav-link"> --}}
            <a href="{{ route('approval.hrmleave') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Hr Manager Leave Approval</span>
            </a>
            </li>
            <li class="nav-item nav-category">Claim Approval</li>
            {{-- <a href="#" class="nav-link"> --}}
            <a href="{{ route('hrmclaimapproval.status') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Hr Manager Claim Approval</span>
            </a>
            </li>

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
                <span class="link-title">Apply Request</span>
            </a>
            </li>


            {{-- <li class="nav-item nav-category">Payroll Management</li>

                    <a href="{{route('salaries.lists')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Salary Structure</span>
                    </a>

                    <a href="{{route('mypayslip.lists')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Payslips</span>
                    </a>
                    <a href="{{route('Quick Links')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Deductions</span>
                    </a>
                    <a href="{{route('mydashboard')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Overtime Calculations</span>
                    </a>
                    <a href="{{route('mydashboard')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Tax and Compliance</span>
                    </a>

            </li> --}}




            {{-- <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#Schedule" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Work Schedule</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="Schedule">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('all.type')}}" class="nav-link">View shift schedules</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Request changes</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Track hours worked</a>
                        </li>

                    </ul>
                </div>
            </li>


          <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#Payroll" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Payroll & Compensation</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="Payroll">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('payslip')}}" class="nav-link">View payslips</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Tax documents</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Reimbursement details</a>
                        </li>

                    </ul>
                </div>
            </li>
             <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#Training" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Training & Development</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="Training">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('all.amenitie')}}" class="nav-link">Access training programs</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Certifications</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Skill assessments</a>
                        </li>

                    </ul>
                </div>
            </li>
             <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#Leave" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Leave Management</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="Leave">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('leave.apply')}}" class="nav-link">Apply for leave</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('check.leave')}}" class="nav-link">Check leave balance</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('track.approvalstatus')}}" class="nav-link">Track approval status</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('claim.form')}}" class="nav-link">Expense Claim Form</a>
                        </li>

                    </ul>
                </div>
            </li>
           <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#Benefits" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Benefits Information</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="Benefits">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('all.amenitie')}}" class="nav-link">Details about insurance</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Retirement plans</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Other perks</a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#Settings" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Settings</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="Settings">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('all.amenitie')}}" class="nav-link">Profile Settings</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">System Configuration</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Integration Settings</a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#Support" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Help and Support</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="Support">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('all.amenitie')}}" class="nav-link">FAQs</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">User Guide</a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/email/read.html" class="nav-link">Contact Support</a>
                        </li>


                    </ul>
                </div>
            </li>
            <div class="collapse" id="Support">
                <li class="nav-item nav-category">create Hr Manager</li>
                    <a href="{{route('hrmanager.list')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Add Hr Manager</span>
                    </a>
                </li>
            </div>
        </li>





        </ul>
    </div>
</nav>
                <div class="collapse" id="Support">
                    <li class="nav-item nav-category">create Hr Manager</li>
                        <a href="{{route('hrmanager.list')}}" class="nav-link">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="link-title">Add Hr Manager</span>
                        </a>
                    </li>
                </div>
            </li> --}}





        </ul>
    </div>
</nav>
