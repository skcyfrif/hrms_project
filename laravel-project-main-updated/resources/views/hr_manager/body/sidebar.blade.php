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




            {{-- <li class="nav-item nav-category hrm-section-title">HR Manager</li> --}}
            {{-- <li class="nav-item nav-category" style="font-size: 15px; font-weight: 900;">HR Manager</li> --}}
            <li class="nav-item nav-category" style="font-size: 14px; font-weight: 700; color: #11e4a4;">HR Manager</li>


            {{-- <li class="nav-item nav-category text-start fw-bold fs-5">HR Manager</li> --}}
            <li class="nav-item">
                <a href="{{ route('hrmng.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('employee.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="user-plus"></i>
                    <span class="link-title">Add Employee</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('hrm.attendance') }}" class="nav-link">
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
                        <a href="{{ route('hrmleave.balance') }}" class="nav-link">Check Leave Balance</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hrmanagerleave.list') }}" class="nav-link">Apply Leave</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('leave.status.hrm') }}" class="nav-link">Leave Status</a>
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
                        <a href="{{ route('claim.formhrm') }}" class="nav-link">Claim Form</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('track.hrmclaimapprovalstatus') }}" class="nav-link">Claim Status</a>
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
                        <a href="{{ route('hrm.payslip') }}" class="nav-link">View Payslip</a>
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
                    <li class="nav-item ">
                        <a href="{{ route('empsalaries.lists') }}" class="nav-link">Salary Structure</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('all.payroll') }}" class="nav-link">Payroll</a>
                    </li>
                </ul>
            </li>



            <li class="nav-item nav-category" style="color: #11e4a4; font-size: 14px; font-weight: 700;">Employee
                Management</li>
            <li class="nav-item mt-2">
                <a href="{{ route('permanent.Status.employee') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Permanent Approval</span>
                </a>
            </li>


            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#attendanceStatusMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Attendance Status</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="attendanceStatusMenu">
                    <li class="nav-item">
                        <a href="{{ route('hrm.rm.attendance') }}" class="nav-link">Report Manager</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hrm.employee.attendance') }}" class="nav-link">Employee</a>
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
                        <a href="{{ route('approval.status') }}" class="nav-link">Employee Leave Approval</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('approval.rmstatus') }}" class="nav-link">Report Manager Leave Approval</a>
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
                        <a href="{{ route('claimapproval.status') }}" class="nav-link">Employee Claim Approval</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rmclaimapproval.status') }}" class="nav-link">Reporting Manager Claim
                            Approval</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#profileUpdateMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="thumbs-up"></i>
                    <span class="link-title">Profile Update Request</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="profileUpdateMenu">
                    <li class="nav-item">
                        <a href="{{ route('employee.profile.requests') }}" class="nav-link">Employee </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rm.profile.requests') }}" class="nav-link">Reporting Manager </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#accountUpdateMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="thumbs-up"></i>
                    <span class="link-title">Account Update Request</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="accountUpdateMenu">
                    <li class="nav-item">
                        <a href="{{ route('employee.account.requests') }}" class="nav-link">Employee </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rm.account.requests') }}" class="nav-link">Reporting Manager </a>
                    </li>
                </ul>
            </li>


            <li class="nav-item mt-2">
                <a href="{{ route('terminations.hrm.index') }}" class="nav-link">
                    <i class="link-icon" data-feather="user-x"></i>
                    <span class="link-title">Termination Letter</span>
                </a>
            </li>

            <li class="nav-item nav-category" style="color: #11e4a4; font-size: 14px; font-weight: 700;">Request</li>
            <li class="nav-item">
                <a href="{{ route('update.request') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Request Corner</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('hrm.myUpdateRequests') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">My profile update status</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('hrm.myaccountUpdateRequests') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">My Account update status</span>
                </a>
            </li>

            <li class="nav-item nav-category" style="color: #11e4a4; font-size: 14px; font-weight: 700;">Carrer</li>

            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#careerPortalMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="briefcase"></i>
                    <span class="link-title">Career Portal</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="careerPortalMenu">
                    <li class="nav-item">
                        <a href="{{ route('apply.list') }}" class="nav-link">Apply</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('candidate.list') }}" class="nav-link">Interview</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('interview.list') }}" class="nav-link">Scheduled Interview</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('short.listing') }}" class="nav-link">Shortlisting Candidates</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hold.listing') }}" class="nav-link">Hold Candidates</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reject.listing') }}" class="nav-link">Rejected Candidates</a>
                    </li>
                </ul>
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
    /* Optional: Add some styling for active states */
    .nav-item.active>.nav-link:not([data-bs-toggle="collapse"]) {
        background-color: rgba(255, 255, 255, 0.1);
        color: #fff;
        font-weight: 500;
    }

    .nav-item.active>.nav-link[data-bs-toggle="collapse"] {
        color: #fff;
        font-weight: 500;
    }

    .collapse.show {
        background-color: rgba(0, 0, 0, 0.1);
    }

    .nav-link.active {
        background-color: rgba(255, 255, 255, 0.15);
        color: #fff !important;
        font-weight: 500;
        border-left: 3px solid #fff;
    }

    .nav-item {}
</style>
