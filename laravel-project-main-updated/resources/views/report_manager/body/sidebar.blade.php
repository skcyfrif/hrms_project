
          <nav class="sidebar">
            <div class="sidebar-header">
                <a href="#" class="sidebar-brand">
                    Reporting Manager<span>Portal</span>
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
                    <a href="{{ route('rm.dashboard') }}" class="nav-link">
                        <i class="link-icon" data-feather="box"></i>
                        <span class="link-title">Dashboard</span>
                    </a>
                        <a href="{{route('rm.attendance')}}" class="nav-link">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="link-title">Add Attendance</span>
                        </a>
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
                                    <a href="{{route('rmleave.balance')}}" class="nav-link">Check leave Balance</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('rmleave.apply')}}" class="nav-link">Apply for leave</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('track.rmleaveapprovalstatus')}}" class="nav-link"> leave  Status</a>
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
                                    <a href="{{route('rmclaim.form')}}" class="nav-link">Expense Claim Form</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{route('track.rmclaimapprovalstatus')}}" class="nav-link"> Claim  status</a>
                                </li>

                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#Leave" role="button" aria-expanded="false"
                            aria-controls="emails">
                            <i class="link-icon" data-feather="mail"></i>
                            <span class="link-title">Emloyee management</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="Leave">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{route('assigned.employees')}}" class="nav-link">All Employee</a>
                                </li>
                           </ul>
                           <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{route('rmapproval.status')}}" class="nav-link">Leave Approval</a>
                                </li>
                            </ul>
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{route('all.attendanceinrm')}}" class="nav-link">Attendance Status</a>
                                    {{-- <a href="#" class="nav-link">Attendance Status</a> --}}
                                </li>
                            </ul>
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{route('permanent.Status')}}" class="nav-link">Permanent Approval</a>
                                    {{-- <a href="#" class="nav-link">Attendance Status</a> --}}
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
                    {{-- <li class="nav-item">
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
                    </li> --}}
                </ul>
            </div>
        </nav>
        <style>
            .nav-item {
                margin-top: 30px;
            }
        </style>
