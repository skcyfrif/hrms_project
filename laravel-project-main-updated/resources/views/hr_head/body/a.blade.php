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
            <li class="nav-item nav-category">Employee Management</li>
            <li class="nav-item">
                <a href="{{ route('hrhead.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('hrmanager.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Employee Directory</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#musterRollMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Muster Roll</span>
                    <i class="menu-arrow"></i>
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

            <li class="nav-item nav-category">HR Head attendance</li>
            <li class="nav-item">
                <a href="{{ route('hrhead.attendance') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Add Attendance</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#leaveManagementMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Leave Management</span>
                    <i class="menu-arrow"></i>
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

            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#claimFormMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Claim Form</span>
                    <i class="menu-arrow"></i>
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

            {{-- <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#careerPortalMenu" aria-expanded="false">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Career Portal</span>
                    <i class="menu-arrow"></i>
                </a>
                <ul class="collapse" id="careerPortalMenu">
                    <li class="nav-item">
                        <a href="{{route('apply.list')}}" class="nav-link">Apply</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('candidate.list')}}" class="nav-link">Interview</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('interview.list')}}" class="nav-link">Scheduled Interview</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('short.listing')}}" class="nav-link">Shortlisting Candidates</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('hold.listing')}}" class="nav-link">Hold Candidates</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('reject.listing')}}" class="nav-link">Rejected Candidates</a>
                    </li>
                </ul>
            </li> --}}

            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#leaveApprovalMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Leave Approval</span>
                    <i class="menu-arrow"></i>
                </a>
                <ul class="collapse" id="leaveApprovalMenu">
                    <li class="nav-item">
                        <a href="{{ route('approval.hrmleave') }}" class="nav-link">Hr Manager Leave Approval</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route('approval.rmstatus') }}" class="nav-link">Report Manager Leave Approval</a>
                    </li> --}}
                </ul>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#claimApprovalMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Claim Approval</span>
                    <i class="menu-arrow"></i>
                </a>
                <ul class="collapse" id="claimApprovalMenu">
                    <li class="nav-item">
                        <a href="{{ route('hrmclaimapproval.status') }}" class="nav-link">Hr Manager Claim
                            Approval</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route('rmclaimapproval.status') }}" class="nav-link">Reporting Manager Claim
                            Approval</a>
                    </li> --}}
                </ul>
            </li>


            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#attendanceStatusMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Attendance Status</span>
                    <i class="menu-arrow"></i>
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


            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#leaveStatusMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Leave Status</span>
                    <i class="menu-arrow"></i>
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


            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#claimStatusMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Claim Status</span>
                    <i class="menu-arrow"></i>
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


            {{-- <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#pendingApprovalMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Pending Approval</span>
                    <i class="menu-arrow"></i>
                </a>
                <ul class="collapse" id="pendingApprovalMenu">

                    <li class="nav-item">
                        <a href="{{ route('permanent.Status.employee') }}" class="nav-link">Permanent Approval</a>
                    </li>
                </ul>
            </li> --}}

            <li class="nav-item">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#payrollandCompensationMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Payroll and Compensation</span>
                    <i class="menu-arrow"></i>
                </a>
                <ul class="collapse" id="payrollandCompensationMenu">
                    <li class="nav-item">
                        <a href="{{ route('hr.payslip') }}" class="nav-link">View Payslip</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route('approval.rmstatus') }}" class="nav-link">Report Manager Leave Approval</a>
                    </li> --}}
                </ul>
            </li>

            <li class="nav-item nav-category">Request</li>
            <li class="nav-item">
                <a href="{{ route('update.request.hr') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Request Corner</span>
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




.sidebar .sidebar-body .nav .nav-item.nav-category {
    color: #d0d6e1;
    font-size: 13px;
    text-transform: uppercase;
    font-weight: 500;
    letter-spacing: 0.5px;
    margin-bottom: 22px;
    height: 27px;
}
