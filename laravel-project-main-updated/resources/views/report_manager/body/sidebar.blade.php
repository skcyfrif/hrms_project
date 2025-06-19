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
            <li class="nav-item nav-category" style="font-size: 14px; font-weight: 700; color: #11e4a4;">Reporting Manager
            </li>
            <li class="nav-item mt-2">
                <a href="{{ route('rm.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item mt-2">
                <a href="{{ route('rm.attendance') }}" class="nav-link">
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
                        <a href="{{ route('rmleave.balance') }}" class="nav-link">Check Leave Balance</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('rmleave.apply') }}" class="nav-link">Apply Leave</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('track.rmleaveapprovalstatus') }}" class="nav-link">Leave Status</a>
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
                        <a href="{{ route('rmclaim.form') }}" class="nav-link">Claim Form</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('track.rmclaimapprovalstatus') }}" class="nav-link">Claim Status</a>
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
                        <a href="{{ route('rm.payslip') }}" class="nav-link">View Payslip</a>
                    </li>

                </ul>
            </li>


            <li class="nav-item nav-category" style="font-size: 14px; font-weight: 700; color: #11e4a4;">Employee management</li>
            <li class="nav-item mt-2">
                <a href="{{ route('assigned.employees') }}" class="nav-link">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">All Employee</span>
                </a>
            </li>

            <li class="nav-item mt-2">
                <a href="{{ route('rm.employee.attendance') }}" class="nav-link">
                    <i class="link-icon" data-feather="calendar"></i>
                    <span class="link-title">Attendance Status</span>
                </a>
            </li>

            <li class="nav-item mt-2">
                <a href="{{ route('rmapproval.status') }}" class="nav-link">
                    <i class="link-icon" data-feather="check-square"></i>
                    <span class="link-title">Leave Approval</span>
                </a>
            </li>

            <li class="nav-item mt-2">
                <a href="{{ route('permanent.Status') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Permanent Approval</span>
                </a>
            </li>

            {{-- <li class="nav-item mt-2">
                <a href="{{ route('employee.account.requests') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Account Update Approval</span>
                </a>
            </li> --}}





            <li class="nav-item nav-category" style="color: #11e4a4; font-size: 14px; font-weight: 700;">Request</li>
            <li class="nav-item">
                <a href="{{ route('update.request.rm') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Request Corner</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rm.myUpdateRequests') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">My Profile Update Status</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('rm.myaccountUpdateRequests') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
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
