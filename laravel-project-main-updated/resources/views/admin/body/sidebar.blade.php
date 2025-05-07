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

            <li class="nav-item nav-category">Employee Management</li>

            <li class="nav-item">
                <a href="{{ route('admin.dashboards') }}" class="nav-link">
                    <i class="link-icon" data-feather="home"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('subrat.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Add Hr Head</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.hr_heads') }}" class="nav-link" id="allHrHeadLink">
                    <i class="link-icon" data-feather="user-check"></i>
                    <span class="link-title">View All Employees</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#attendanceMenu" role="button"
                   aria-expanded="false" aria-controls="attendanceMenu">
                    <i class="link-icon" data-feather="clock"></i>
                    <span class="link-title">Attendance Status</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="attendanceMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.hr_headsattendances') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">HR Head</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.hr_managersattendances') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">HR Manager</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.report_managersattendances') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">Report Manager</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.employeesattendances') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="users"></i>
                                <span class="sub-menu-title">Employees</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#leaveMenu" role="button"
                   aria-expanded="false" aria-controls="leaveMenu">
                    <i class="link-icon" data-feather="file-text"></i>
                    <span class="link-title">Leave Status</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="leaveMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.hr_headsleaves') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">HR Head</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.hrmleaves') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">HR Manager</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.rmleaves') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">Report Manager</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.employeeleaves') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="users"></i>
                                <span class="sub-menu-title">Employees</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#claimMenu" role="button"
                   aria-expanded="false" aria-controls="claimMenu">
                    <i class="link-icon" data-feather="dollar-sign"></i>
                    <span class="link-title">Claim Status</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="claimMenu">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.hr_headsclaim') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">HR Head</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.hrmclaim') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">HR Manager</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.rmclaim') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="user"></i>
                                <span class="sub-menu-title">Report Manager</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.employeeclaim') }}" class="nav-link">
                                <i class="link-sub-icon" data-feather="users"></i>
                                <span class="sub-menu-title">Employees</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item nav-category">Leave Approval</li>
            <li class="nav-item">
                <a href="{{ route('approval.hrheadleave') }}" class="nav-link">
                    <i class="link-icon" data-feather="check-circle"></i>
                    <span class="link-title">HR Head Leave Approval</span>
                </a>
            </li>

            <li class="nav-item nav-category">Claim Approval</li>
            <li class="nav-item">
                <a href="{{ route('hrheadclaimapproval.status') }}" class="nav-link">
                    <i class="link-icon" data-feather="check-square"></i>
                    <span class="link-title">HR Head Claim Approval</span>
                </a>
            </li>

        </ul>
    </div>
</nav>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const allHrHeadLink = document.getElementById('allHrHeadLink');
        const collapseToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');

        if (allHrHeadLink) {
            allHrHeadLink.addEventListener('click', function(event) {
                console.log('All HR Head link clicked - preventing collapse on others');
                event.preventDefault(); // Stop the default navigation of the All HR Head link

                // Optionally, add the navigation logic for All HR Head here:
                window.location.href = "{{ route('admin.hr_heads') }}";

                // Prevent the default Bootstrap collapse behavior on other collapse toggles
                collapseToggles.forEach(function(toggle) {
                    toggle.removeEventListener('click', preventCollapse);
                    toggle.addEventListener('click', preventCollapse, { once: true });
                });
            });
        }

        function preventCollapse(event) {
            console.log('Collapse toggle clicked, preventing default.');
            event.stopPropagation();
            event.preventDefault();
            // After preventing once, the listener is automatically removed due to { once: true }
        }
    });
</script>

