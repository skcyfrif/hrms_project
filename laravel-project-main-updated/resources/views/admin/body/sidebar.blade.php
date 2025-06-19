<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Admin<span>Portal</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category" style="font-size: 14px; font-weight: 700; color: #11e4a4;">Employee
                Management</li>


            {{-- <li class="nav-item nav-category text-start fw-bold fs-5">HR Manager</li> --}}
            <li class="nav-item">
                <a href="{{ route('admin.dashboards') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('subrat.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="user-plus"></i>
                    <span class="link-title">Add Hr Head</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('admin.hr_heads') }}" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">View All Employees</span>
                </a>
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
                        <a href="{{ route('admin.hr.payroll') }}" class="nav-link">Payroll</a>
                    </li>
                    <li class="nav-item ">
                        <a href="{{ route('hrsalaries.lists') }}" class="nav-link">Salary Structure</a>
                    </li>

                </ul>
            </li>




            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#attendanceStatusMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="check-square"></i>
                    <span class="link-title">Attendance Status</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="attendanceStatusMenu">
                    <li class="nav-item">
                        <a href="{{ route('admin.hr_headsattendances') }}" class="nav-link">HR Head</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.hr_managersattendances') }}" class="nav-link">HR Manager</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.report_managersattendances') }}" class="nav-link">Report Manager</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.employeesattendances') }}" class="nav-link">Employee</a>
                    </li>
                </ul>
            </li>



            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#leaveStatusMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Leave Status</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="leaveStatusMenu">
                    <li class="nav-item">
                        <a href="{{ route('admin.hr_headsleaves') }}" class="nav-link">HR Head</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.hrmleaves') }}" class="nav-link">HR Manager</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.rmleaves') }}" class="nav-link">Report Manager</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.employeeleaves') }}" class="nav-link">Employee</a>
                    </li>
                </ul>
            </li>

            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#claimStatusMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="file-text"></i>
                    <span class="link-title">Claim Status</span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="claimStatusMenu">
                    <li class="nav-item">
                        <a href="{{ route('admin.hr_headsclaim') }}" class="nav-link">HR Head</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.hrmclaim') }}" class="nav-link">HR Manager</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.rmclaim') }}" class="nav-link">Report Manager</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.employeeclaim') }}" class="nav-link">Employee</a>
                    </li>
                </ul>
            </li>




            <li class="nav-item mt-2">
                <a href="#" class="nav-link" data-bs-toggle="collapse" data-bs-target="#requestStatusMenu"
                    aria-expanded="false">
                    <i class="link-icon" data-feather="clock"></i>
                    <span class="link-title">Request From HR </span>
                    <i class="menu-arrow" data-feather="chevron-down"></i>
                </a>
                <ul class="collapse" id="requestStatusMenu">
                    <li class="nav-item">
                        <a href="{{ route('hrheadclaimapproval.status') }}" class="nav-link">Claim Approval</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('approval.hrheadleave') }}" class="nav-link">Leave Approval</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hrhead.profile.requests') }}" class="nav-link">Update profile</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('hrhead.account.requests') }}" class="nav-link">Update Account</a>
                    </li>
                </ul>
            </li>


            <li class="nav-item mt-2">
                <a href="{{ route('terminations.hr') }}" class="nav-link">
                    <i class="link-icon" data-feather="user-x"></i>
                    <span class="link-title">Termination Letter</span>
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
