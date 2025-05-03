<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
          HR Manager<span>Portal</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            {{-- <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="{{route('admin.dashboard')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li> --}}
            {{-- <li class="nav-item nav-category"> create employee</li>

                <a href="#" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Add employee</span>
            </a>
            </li> --}}
            <li class="nav-item nav-category">Employee Management</li>
                <a href="{{route('hrmng.dashboard')}}" class="nav-link">
                    {{-- <a href="#" class="nav-link"> --}}
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
                <a href="{{route('employee.list')}}" class="nav-link">
                    {{-- <a href="#" class="nav-link"> --}}
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Employee Directory</span>
                </a>

                {{-- <a href="{{route('reportmanager.list')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Add Report Manager</span>
                </a> --}}
                {{-- <a href="{{route('approval.status')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Employees Leave Status</span>
                </a> --}}
                {{-- <a href="{{route('all.attendances')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Attendance Status</span>
                </a> --}}
                <li class="nav-item">
                    <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#musterRollMenu" aria-expanded="false">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Muster Roll</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <ul class="collapse" id="musterRollMenu">
                        <li class="nav-item">
                            <a href="{{ route('all.attendances') }}" class="nav-link">Employee Attendance</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('empsalaries.lists') }}" class="nav-link">Salary Structure</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('all.payroll') }}" class="nav-link">Payroll</a>
                        </li>
                    </ul>
                </li>
            </li>

            <li class="nav-item nav-category">HR Manager Attendace</li>
                <a href="{{route('hrm.attendance')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Add Attendace</span>
                </a>
                <li class="nav-item nav-category">Leave Management</li>

                    <a href="{{route('hrmleave.balance')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">check Leave Balance</span>
                    </a>
                    <a href="{{route('hrmanagerleave.list')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Apply Leave</span>
                    </a>
                    <a href="{{route('leave.status.hrm')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Leave Status</span>
                    </a>
                </li>

                <li class="nav-item nav-category">Claim Form</li>
                    <a href="{{route('claim.formhrm')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Claim Form</span>
                    </a>
                    <a href="{{route('track.hrmclaimapprovalstatus')}}" class="nav-link">
                    {{-- <a href="#" class="nav-link"> --}}
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Claim Status</span>
                    </a>
                </li>

            </li>
            <li class="nav-item nav-category">carrer portal</li>
                <a href="{{route('apply.list')}}" class="nav-link">
                {{-- <a href="#" class="nav-link"> --}}
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">apply</span>
                </a>
                <a href="{{route('candidate.list')}}" class="nav-link">
                {{-- <a href="#" class="nav-link"> --}}
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Interview</span>
                </a>
                <a href="{{route('interview.list')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Scheduled Interview</span>
                </a>
                <a href="{{route('short.listing')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">shortlisting candidates</span>
                </a>
                <a href="{{route('hold.listing')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Hold candidates</span>
                </a>
                <a href="{{route('reject.listing')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Rejected candidates</span>
                </a>
            </li>

            <li class="nav-item nav-category">Pending Approval</li>
                <a href="{{route('salaryapproval.list')}}" class="nav-link">
                {{-- <a href="#" class="nav-link"> --}}
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Salary Approval</span>
                </a>
                <a href="{{route('permanent.Status.employee')}}" class="nav-link">
                    {{-- <a href="#" class="nav-link"> --}}
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Permanent Approval</span>
                    </a>

            </li>
            <li class="nav-item nav-category">Leave Approval</li>

                {{-- <a href="{{route('apply.list')}}" class="nav-link"> --}}
                    <a href="{{route('approval.status')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">employee Leave Approval</span>
                    </a>
                    <a href="{{route('approval.rmstatus')}}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Report Manager Leave Approval</span>
                    </a>
                </li>

            <li class="nav-item nav-category">Claim Approval</li>
                <a href="{{route('claimapproval.status')}}" class="nav-link">
                    {{-- <a href="#" class="nav-link"> --}}
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">employee Claim Approval</span>
                    </a>
                    <a href="{{route('rmclaimapproval.status')}}" class="nav-link">
                        {{-- <a href="#" class="nav-link"> --}}
                            <i class="link-icon" data-feather="box"></i>
                            <span class="link-title">Reporting Manager Claim Approval</span>
                        </a>
                    {{-- <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Tour Plan Approval</span>
                    </a>
                    <a href="#" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Other Approval</span>
                    </a> --}}
            </li>


            <li class="nav-item nav-category">Request</li>
            <a href="{{route('update.request')}}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Apply Request</span>
                </a>
        </li>







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
