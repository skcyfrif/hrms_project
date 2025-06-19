{{-- <nav class="sidebar">
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
</nav> --}}


<!-- Bootstrap Bundle (includes Popper) -->




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
            <li class="nav-item nav-category" style="color: #11e4a4; font-size: 14px; font-weight: 700;">HR Head </li>
            <li class="nav-item">
                <a href="{{ route('hrhead.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('hrmanager.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="user-plus"></i>
                    <span class="link-title">Add HrManager</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('hrhead.attendance') }}" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Add Attendance</span>
                </a>
            </li>

            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#leaveManagementMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="clock"></i>
                    <span class="link-title">Leave Management</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="leaveManagementMenu">
                    <li class="nav-item">
                        <a href="{{ route('hrheadleave.balance') }}" class="nav-link">Check Leave Balance</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hrheadleave.list') }}" class="nav-link">Apply Leave</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('leave.status.hrhead') }}" class="nav-link">Leave Status</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#claimFormMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="file-text"></i>
                    <span class="link-title">Claim Form</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="claimFormMenu">
                    <li class="nav-item">
                        <a href="{{ route('claim.formhrhead') }}" class="nav-link">Claim Form</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('track.hrheadclaimapprovalstatus') }}" class="nav-link">Claim Status</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse"
                    data-bs-target="#payrollandCompensationMenu" aria-expanded="false">
                    <i class="link-icon" data-feather="dollar-sign"></i>
                    <span class="link-title">Payslip</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="payrollandCompensationMenu">
                    <li class="nav-item">
                        <a href="{{ route('hr.payslip') }}" class="nav-link">View Payslip</a>
                    </li>

                </ul>
            </li>



            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#leaveApprovalMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="check-square"></i>
                    <span class="link-title">Leave Approval</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="leaveApprovalMenu">
                    <li class="nav-item">
                        <a href="{{ route('approval.hrmleave') }}" class="nav-link">Hr Manager Leave Approval</a>
                    </li>

                </ul>
            </li>

            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#claimApprovalMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="thumbs-up"></i>
                    <span class="link-title">Claim Approval</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="claimApprovalMenu">
                    <li class="nav-item">
                        <a href="{{ route('hrmclaimapproval.status') }}" class="nav-link">Hr Manager Claim
                            Approval</a>
                    </li>

                </ul>
            </li>


            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#musterRollMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="layers"></i>
                    <span class="link-title">Muster Roll</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="musterRollMenu">
                    <li class="nav-item">
                        <a href="{{ route('hrmsalaries.lists') }}" class="nav-link">Salary Structure</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hr.hrm.payroll') }}" class="nav-link">Payroll</a>
                    </li>
                </ul>
            </li>


            <li class="nav-item nav-category" style="color: #11e4a4; font-size: 14px; font-weight: 700;">Employee
                Management</li>

            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#attendanceStatusMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Attendance Status</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="attendanceStatusMenu">
                    <li class="nav-item">
                        <a href="{{ route('hr_head.hr_managerattendances') }}" class="nav-link">HR Manager</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hr_head.rmattendances') }}" class="nav-link">Report Manager</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hrhead.employee.attendances') }}" class="nav-link">Employee</a>
                    </li>
                </ul>
            </li>


            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#leaveStatusMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="activity"></i>
                    <span class="link-title">Leave Status</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="leaveStatusMenu">
                    <li class="nav-item">
                        <a href="{{ route('hr_head.hr_managersleaves') }}" class="nav-link">HR Manager</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hrhead.hrm.rm.leave') }}" class="nav-link">Report Manager</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hrhead.hrm.employee.leave') }}" class="nav-link">Employee</a>
                    </li>
                </ul>
            </li>


            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#claimStatusMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="file"></i>
                    <span class="link-title">Claim Status</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="claimStatusMenu">
                    <li class="nav-item">
                        <a href="{{ route('hr_head.hr_managersclaim') }}" class="nav-link">HR Manager</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hrhead.hrm.rm.claim') }}" class="nav-link">Report Manager</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hr_head.hrm.employee.claim') }}" class="nav-link">Employee</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#requestStatusMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="file"></i>
                    <span class="link-title">Hr Manager Request</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="requestStatusMenu">
                    <li class="nav-item">
                        <a href="{{ route('hrm.profile.requests') }}" class="nav-link">update Profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hrm.account.requests') }}" class="nav-link">update Account</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item mt-2">
                <a href="{{ route('terminations.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="user-x"></i>
                    <span class="link-title">Termination Letter</span>
                </a>
            </li>




            <li class="nav-item nav-category" style="color: #11e4a4; font-size: 14px; font-weight: 700;">Request</li>
            <li class="nav-item">
                <a href="{{ route('update.request.hr') }}" class="nav-link">
                    <i class="link-icon" data-feather="refresh-ccw"></i>
                    <span class="link-title">Request Corner</span>
                </a>
                <a href="{{ route('hr.myUpdateRequests') }}" class="nav-link">
                    <i class="link-icon" data-feather="refresh-ccw"></i>
                    <span class="link-title">My Profile Update Status</span>
                </a>
                <a href="{{ route('hr.myaccountUpdateRequests') }}" class="nav-link">
                    <i class="link-icon" data-feather="refresh-ccw"></i>
                    <span class="link-title">My Account Update Status</span>
                </a>

            </li>
        </ul>
    </div>
</nav>

<script>
    // Enhanced active class management
    document.addEventListener('DOMContentLoaded', function() {
        const currentUrl = window.location.href.split('?')[0]; // Remove query parameters
        const navLinks = document.querySelectorAll('.nav-link');

        navLinks.forEach(link => {
            const linkUrl = link.href.split('?')[0]; // Also remove query parameters from link

            // Check if current URL matches link URL
            if (currentUrl === linkUrl) {
                link.classList.add('active');

                // Handle parent elements
                let parentItem = link.closest('.nav-item');
                if (parentItem) {
                    parentItem.classList.add('active');

                    // Handle dropdown parents
                    let parentCollapse = link.closest('.collapse');
                    if (parentCollapse) {
                        parentCollapse.classList.add('show');
                        const toggleLink = document.querySelector(
                            `[data-bs-target="#${parentCollapse.id}"]`);
                        if (toggleLink) {
                            toggleLink.classList.add('active');
                            toggleLink.setAttribute('aria-expanded', 'true');

                            // Also activate the parent nav-item of the toggle link
                            let toggleParent = toggleLink.closest('.nav-item');
                            if (toggleParent) {
                                toggleParent.classList.add('active');
                            }
                        }
                    }
                }
            }
        });

        // Manually handle dropdown toggles to maintain active state
        const dropdownToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const targetId = this.getAttribute('data-bs-target');
                const targetCollapse = document.querySelector(targetId);

                if (targetCollapse.classList.contains('show')) {
                    this.classList.add('active');
                    this.setAttribute('aria-expanded', 'true');
                } else {
                    this.classList.remove('active');
                    this.setAttribute('aria-expanded', 'false');
                }
            });
        });
    });
</script>

<style>
    .sidebar {
        background-color: #2e3b4e;
        color: white;



    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 4px;
        transition: background 0.3s, color 0.3s;
    }

    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.05);
        color: #ffd369;
    }

    .link-icon {
        color: #ffd369;
        width: 18px;
        height: 18px;
    }

    .nav-link.active .link-icon {
        color: #ffffff;
    }

    /* .nav-item.nav-category {
        font-size: 13px;
        padding: 12px 20px;
        color: #b0bec5;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-top: 0px;
        display: block;
        line-height: 1.5;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    } */
</style>
