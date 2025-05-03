<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Employee<span>Portal</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Employee</li>
            <a href="{{ route('employees.dashboard') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Dashboard</span>
            </a>
            <a href="{{ route('employee.attendance') }}" class="nav-link">
                <i class="link-icon" data-feather="box"></i>
                <span class="link-title">Add Attendance</span>
            </a>
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
                            <a href="{{ route('payslip') }}" class="nav-link">View payslips</a>
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
                            <a href="{{ route('check.leave') }}" class="nav-link">Check leave balance</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('leave.apply') }}" class="nav-link">Apply for leave</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('track.approvalstatus') }}" class="nav-link"> Leave Status</a>
                        </li>

                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#Leave" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Claim Form</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="Leave">
                    <ul class="nav sub-menu">

                        <li class="nav-item">
                            <a href="{{ route('claim.form') }}" class="nav-link">Expense Claim Form</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('track.claimapprovalstatus') }}" class="nav-link"> Claim status</a>
                        </li>

                    </ul>
                </div>
            </li>

            {{-- <li class="nav-item">
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
            </li> --}}

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#Support" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Request</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="Support">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{route('make.permanent')}}" class="nav-link">Apply Request</a>
                        </li>
                        <li class="nav-item">
                        </li>
                        <li class="nav-item">
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
                            {{-- <a href="{{route('all.amenitie')}}" class="nav-link">FAQs</a> --}}
                        </li>
                        <li class="nav-item">
                            {{-- <a href="pages/email/read.html" class="nav-link">User Guide</a> --}}
                        </li>
                        <li class="nav-item">
                            {{-- <a href="pages/email/read.html" class="nav-link">Contact Support</a> --}}
                        </li>


                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
<style>
    .nav-item {
        margin-top: 30px;
    }
</style>
