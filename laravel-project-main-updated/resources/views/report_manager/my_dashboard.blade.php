@extends('report_manager.report_manager_dashboard')

@section('report_manager')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <div class="container-fluid mt-5 py-4">
        <!-- Header with Welcome Message -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="text-white mb-1">Welcome back,</h4>
                <h2 class="text-warning">{{ $employee->name }} <span class="wave-emoji">👋</span></h2>
            </div>
            <div class="text-end">
                <p class="text-muted mb-0">{{ now()->format('l, F j, Y') }}</p>
                <p class="text-white mb-0">Report Manager Dashboard</p>
            </div>
        </div>

        <!-- Profile Info Card -->
        <div class="row">
            <div class="col-lg-6">
                <div class="card profile-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white"><i class="fas fa-user-circle me-2"></i>Profile Information</h5>
                        <span class="badge bg-primary">{{ $employee->designation }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-muted">Employee ID</span>
                                        <span class="fw-bold text-black">{{ $employee->employee_id }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-muted">Email</span>
                                        <span class="fw-bold text-black">{{ $employee->email }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-muted">Department</span>
                                        <span class="fw-bold text-black">{{ $employee->department }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 d-flex align-items-center justify-content-center">
                                <div class="profile-avatar">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="col-lg-6">
                <div class="card quick-stats-card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Quick Stats</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            {{-- <div class="col-6 mb-3">
                            <div class="stat-item">
                                <div class="stat-icon bg-primary">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-info">
                                    <h6 class="text-black">Team Members</h6>
                                    <h3>{{ $teamMembers->count() }}</h3>
                                </div>
                            </div>
                        </div> --}}
                            <div class="col-6 mb-3">
                                <div class="stat-item">
                                    <div class="stat-icon bg-success">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h6 class="text-black">Checked in Time</h6>
                                        <div class="d-flex justify-content-between badge bg-pl">
                                            {{-- <span
                                                class="badge bg-pl">{{ $attendances->check_in_time->format('Y-m-d H:i:s') }}</span> --}}
                                            @if ($attendances && $attendances->check_in_time)
                                                <p><strong>Today’s Check-In:</strong>
                                                    {{ \Carbon\Carbon::parse($attendances->check_in_time)->format('h:i A') }}
                                                </p>
                                            @else
                                                <p>No check-in recorded today.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-6">
                            <div class="stat-item">
                                <div class="stat-icon bg-warning">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-info">
                                    <h6 class="text-black">Pending Leaves</h6>
                                    <h3>{{ $pendingLeaveCount }}</h3>
                                </div>
                            </div>
                        </div> --}}
                            <div class="col-6">
                                <div class="stat-item">
                                    <div class="stat-icon bg-info">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                    <div class="stat-info">
                                        <h6>Leave Balance</h6>
                                        <div class="d-flex  gap-1 justify-content-between">
                                            {{-- <div class="d-flex flex-column gap-1 justify-content-between"> --}}

                                            <span class="badge bg-pl">PL: {{ $leaveBalanceData->pl_balance ?? 0 }}</span>
                                            <span class="badge bg-sl">SL: {{ $leaveBalanceData->sl_balance ?? 0 }}</span>
                                            <span class="badge bg-lop">LOP: {{ $leaveBalanceData->lop_days ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <a href="{{ route('assigned.employees') }}" class="card action-card team-card">
                    <div class="card-body">
                        <div class="action-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5>My Team ({{ $teamMembers->count() }})</h5>
                        <p>Manage your team members and their details</p>
                        <div class="action-link">
                            View Team <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <a href="{{ route('rm.employee.attendance', ['date' => now()->toDateString()]) }}"
                    class="card action-card attendance-card">
                    <div class="card-body">
                        <div class="action-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <h5>Attendance Snapshots</h5>
                        Today Present: <span class="badge bg-success">{{ $presentCount }}</span>
                        <p>View and manage team attendance records</p>
                        <div class="action-link">
                            View Attendance <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4 mb-4">
                <a href="{{ route('rmapproval.status') }}" class="card action-card leaves-card">
                    <div class="card-body">
                        <div class="action-icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <h5>Quick Access Leave Approvals</h5>
                        <p>Review and approve pending leave requests</p>
                        <span class="badge bg-success">{{ $pendingLeaveCount }}</span>
                        <div class="action-link">
                            Manage Leaves <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-4">
                <a href="#" class="card action-card reports-card">
                    <div class="card-body">
                        <div class="action-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <h5>UpComing Holidays</h5>
                        <p>Generate and analyze team performance reports</p>
                        <div class="action-link">
                            View Holidays <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-6 mb-4">
                <a href="#" class="card action-card reports-card">
                    <div class="card-body">
                        <div class="action-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <h5>Recent Notifications</h5>
                        <p>All Notification</p>
                        <div class="action-link">
                            View Notifications <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Base Styles */
        body {
            background-color: #1a1a2e;
            color: #fff;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            background: #16213e;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background: rgba(255, 255, 255, 0.05);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 20px;
            font-weight: 600;
        }

        /* Profile Card */
        .profile-card {
            height: 100%;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .list-group-item {
            background: transparent;
            color: #e6e6e6;
            border-color: rgba(255, 255, 255, 0.05);
        }

        /* Quick Stats */
        .quick-stats-card {
            height: 100%;
        }

        .stat-item {
            display: flex;
            align-items: center;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-size: 1.1rem;
        }

        .stat-info h6 {
            font-size: 0.85rem;
            color: #a1a1a1;
            margin-bottom: 0.2rem;
        }

        .stat-info h3 {
            font-size: 1.5rem;
            margin-bottom: 0;
        }

        .badge {
            font-weight: 500;
            padding: 5px 8px;
        }

        .bg-pl {
            background-color: #4e73df !important;
        }

        .bg-sl {
            background-color: #1cc88a !important;
        }

        .bg-lop {
            background-color: #e74a3b !important;
        }

        /* Action Cards */
        .action-card {
            height: 100%;
            position: relative;
            overflow: hidden;
            border: none;
        }

        .action-card:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
        }

        .team-card:before {
            background: linear-gradient(90deg, #3a7bd5, #00d2ff);
        }

        .attendance-card:before {
            background: linear-gradient(90deg, #11998e, #38ef7d);
        }

        .leaves-card:before {
            background: linear-gradient(90deg, #f46b45, #eea849);
        }

        .reports-card:before {
            background: linear-gradient(90deg, #8e2de2, #4a00e0);
        }

        .action-card .card-body {
            padding: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .action-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            font-size: 1.5rem;
            color: white;
        }

        .team-card .action-icon {
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
        }

        .attendance-card .action-icon {
            background: linear-gradient(135deg, #11998e, #38ef7d);
        }

        .leaves-card .action-icon {
            background: linear-gradient(135deg, #f46b45, #eea849);
        }

        .reports-card .action-icon {
            background: linear-gradient(135deg, #8e2de2, #4a00e0);
        }

        .action-card h5 {
            font-size: 1.1rem;
            margin-bottom: 10px;
        }

        .action-card p {
            color: #b3b3b3;
            font-size: 0.9rem;
            flex-grow: 1;
        }

        .action-link {
            color: #4e73df;
            font-weight: 500;
            display: flex;
            align-items: center;
            margin-top: 15px;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .profile-avatar {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .stat-item {
                flex-direction: column;
                text-align: center;
            }

            .stat-icon {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }

        /* Animations */
        .wave-emoji {
            animation: wave 2s infinite;
            display: inline-block;
            transform-origin: 70% 70%;
        }

        @keyframes wave {
            0% {
                transform: rotate(0deg);
            }

            10% {
                transform: rotate(-10deg);
            }

            20% {
                transform: rotate(12deg);
            }

            30% {
                transform: rotate(-10deg);
            }

            40% {
                transform: rotate(9deg);
            }

            50% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }
    </style>
@endsection

@section('scripts')
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <script>
        // Add any custom JavaScript here if needed
    </script>
@endsection
