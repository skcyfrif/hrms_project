@extends('hr_head.hr_head_dashboard')

@section('hr_head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


    <div class="container-fluid admin-dashboard mt-5">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div>
                        <h4 class="text-primary mb-1">
                            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="User Icon" width="50"
                                height="50" class="rounded-circle shadow">Welcome,
                            {{ $employee->name }}
                        </h4>
                        <p class="text-muted mb-0">Your dashboard for the HRMS system</p>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <div class="date-picker-container">
                        <div class="input-group flatpickr" id="dashboardDate">
                            <span class="input-group-text">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <input type="text" class="form-control text-white" placeholder="Select date" data-input>
                        </div>
                        {{-- <button class="btn btn-edit-profile">
                        <i class="fas fa-user-edit me-2"></i>Edit Profile
                    </button> --}}
                    </div>
                </div>
            </div>
        </div>



        <div class="mb-4">

        </div>
        <!-- Profile and Quick Stats -->
        <div class="row mb-4">
            <!-- Profile Card -->
            <div class="col-lg-4 mb-4">
                <div class="card profile-card">
                    <div class="card-header">
                        <h5><i class="fas fa-user-circle me-2"></i>Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="profile-info">
                            <div class="profile-avatar">
                                <i class="fas fa-user-shield"></i>
                            </div>
                            <div class="profile-details">
                                <div class="detail-item">
                                    <span class="detail-label">Name:</span>
                                    <span class="detail-value badge bg-admin">{{ $employee->name }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Email:</span>
                                    <span class="detail-value badge bg-admin">{{ $employee->email }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Department:</span>
                                    <span class="detail-value badge bg-admin">{{ $employee->department }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Role:</span>
                                    <span class="detail-value badge bg-admin">{{ $employee->user_role }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Quick Stats -->

            <div class="col-lg-8 mb-4">

                <div class="row quick-stats-row">


                    <div class="col-md-6 col-6 mb-4">
                        <div class="quick-stat-card hr-heads">
                            <div class="stat-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="stat-info">
                                <h6>My Attendance</h6>
                                @if ($attendances && $attendances->check_in_time)
                                    <p><strong>Today’s Check-In:</strong>
                                        {{ \Carbon\Carbon::parse($attendances->check_in_time)->format('h:i A') }}</p>
                                @else
                                    <p>No check-in recorded today.</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-6 mb-4">
                        <div class="quick-stat-card hr-managers">
                            <div class="stat-icon">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <div class="stat-info">
                                <h6>Leave Balance</h6>
                                <li class="list-group-item"><strong>Available PL:</strong>
                                    {{ $leaveBalanceData->pl_balance ?? 0 }}</li>
                                <li class="list-group-item"><strong>Available SL:</strong>
                                    {{ $leaveBalanceData->sl_balance ?? 0 }}</li>
                                <li class="list-group-item"><strong>Taken LOP:</strong>
                                    {{ $leaveBalanceData->lop_days ?? 0 }}</li>
                            </div>
                        </div>
                    </div>






                </div>
            </div>
        </div>



        <div class="row action-cards-row mb-4">
            <div class="col-lg-6 mb-4">
                <div class="card shadow attendance_snapshot_card">
                    <div class="align-items-center">
                        <h6 class="m-0 font-weight-bold"><i class="fas fa-user-plus me-2"></i>Attendance Snapshot</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('hr_head.hr_managerattendances') }}"
                                    class="btn btn-purple w-100 d-flex flex-column Recruitment_card_one align-items-center p-3">
                                    <i class="fas fa-user-clock fa-2x mb-2"></i>
                                    <span>Hr Managers</span>
                                    <span class="badge bg-light text-dark mt-1"></span>
                                    {{-- <span class="badge bg-light text-dark mt-1">{{ $candidateCount }}</span> --}}
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('hr_head.rmattendances') }}"
                                    class="btn btn-purple w-100 d-flex flex-column Recruitment_card_two align-items-center p-3">
                                    <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                                    <span>Reporting Managers</span>
                                    <span class="badge bg-light text-dark mt-1"></span>
                                    {{-- <span class="badge bg-light text-dark mt-1">{{ $sheduledcandidateCount }}</span> --}}
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('hrhead.employee.attendances') }}"
                                    class="btn btn-purple w-100 d-flex flex-column Recruitment_card_three align-items-center p-3">
                                    <i class="fas fa-envelope-open-text fa-2x mb-2"></i>
                                    <span>Employees</span>
                                    {{-- <span class="badge bg-light text-dark mt-1">0</span> --}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-6 mb-4">
                <div class="quick-stat-card total-employees">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">

                        <h6>My Team Members</h6>
                        <h3>({{ $totalMembers }})</h3>
                        <a href="{{ route('hrmanager.list') }}" class="stat-link">View All <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="action-card leave-card">
                    <div class="card-icon">
                        <i class="fas fa-calendar-times"></i>
                    </div>
                    <div class="card-content">
                        <h4>Quick Access Leave Approvals</h4>
                        <p>Review and approve pending leave requests</p>
                        <a href="{{ route('approval.hrmleave') }}" class="btn-action">
                            Manage Leaves ({{ $pendingLeaveCountemplyee }})<i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="action-card claim-card">
                    <div class="card-icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                    <div class="card-content">
                        <h4>Quick AccessClaim Approvals</h4>
                        <p>Review and approve expense claims</p>
                        <a href="{{ route('hrmclaimapproval.status') }}" class="btn-action">
                            Manage Claims ({{ $pendingClaimCount }})<i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>




        <!-- Bottom Section -->
        <div class="row">
            <!-- Upcoming Holidays -->
            <div class="col-lg-6 mb-4">
                <div class="card upcoming-holidays">
                    <div class="card-header">
                        <h5><i class="fas fa-calendar-alt me-2"></i>Upcoming Holidays</h5>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="holiday-list">
                            <div class="holiday-item">
                                <div class="holiday-date">
                                    <span class="day">25</span>
                                    <span class="month">Dec</span>
                                </div>
                                <div class="holiday-info">
                                    <h6>Christmas Day</h6>
                                    <p>Annual holiday celebration</p>
                                </div>
                            </div>
                            <div class="holiday-item">
                                <div class="holiday-date">
                                    <span class="day">01</span>
                                    <span class="month">Jan</span>
                                </div>
                                <div class="holiday-info">
                                    <h6>New Year's Day</h6>
                                    <p>First day of the new year</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Notifications -->
            <div class="col-lg-6 mb-4">
                <div class="card notifications-card">
                    <div class="card-header">
                        <h5><i class="fas fa-bell me-2"></i>Recent Notifications</h5>
                        <a href="#" class="view-all">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="notification-list">
                            <div class="notification-item unread">
                                <div class="notification-icon">
                                    <i class="fas fa-user-clock"></i>
                                </div>
                                <div class="notification-content">
                                    <h6>Leave Request Submitted</h6>
                                    <p>John Doe has requested leave from 15-20 June</p>
                                    <span class="notification-time">2 hours ago</span>
                                </div>
                            </div>
                            <div class="notification-item">
                                <div class="notification-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="notification-content">
                                    <h6>Claim Approved</h6>
                                    <p>Travel expense claim #4567 has been approved</p>
                                    <span class="notification-time">Yesterday, 3:45 PM</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Base Styles */
        .admin-dashboard {
            padding: 30px;
            background-color: #f5f7fa;
            min-height: 100vh;
        }

        .dashboard-header {
            margin-bottom: 30px;
        }

        .welcome-text {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .dashboard-subtitle {
            color: #7f8c8d;
            font-size: 1rem;
        }

        /* Profile Card */
        .profile-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .profile-card .card-header {
            background-color: #3498db;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            border: none;
        }

        .profile-info {
            display: flex;
            align-items: center;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            color: white;
            font-size: 30px;
        }

        .profile-details {
            flex: 1;
        }

        .detail-item {
            margin-bottom: 10px;
        }

        .detail-label {
            display: inline-block;
            width: 35%;
            color: #7f8c8d;
            font-weight: 500;
        }

        .detail-value {
            color: #fff;
            font-weight: 500;
        }

        .badge.bg-admin {
            background-color: #e74c3c;
        }

        /* Quick Stats */
        .quick-stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            height: 100%;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .quick-stat-card:hover {
            transform: translateY(-5px);
        }

        .quick-stat-card::before {
            content: '';
            position: absolute;
            top: -11px;
            left: 0;
            width: 100%;
            height: 9%;
        }

        .total-employees::before {
            background: linear-gradient(to bottom, #3498db, #2980b9);
        }

        .hr-heads::before {
            background: linear-gradient(to bottom, #e74c3c, #c0392b);
        }

        .hr-managers::before {
            background: linear-gradient(to bottom, #2ecc71, #27ae60);
        }

        .reporting-managers::before {
            background: linear-gradient(to bottom, #f39c12, #d35400);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            color: white;
            font-size: 20px;
        }

        .total-employees .stat-icon {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }

        .hr-heads .stat-icon {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
        }

        .hr-managers .stat-icon {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
        }

        .reporting-managers .stat-icon {
            background: linear-gradient(135deg, #f39c12, #d35400);
        }

        .stat-info h6 {
            color: #7f8c8d;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .stat-info h3 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .stat-link {
            color: #3498db;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
        }

        /* Action Cards */
        .action-card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease;
        }

        .action-card:hover {
            transform: translateY(-5px);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: white;
            font-size: 25px;
        }

        .attendance-card .card-icon {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }

        .leave-card .card-icon {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
        }

        .claim-card .card-icon {
            background: linear-gradient(135deg, #f39c12, #d35400);
        }

        .card-content h4 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .card-content p {
            color: #7f8c8d;
            margin-bottom: 20px;
            flex-grow: 1;
        }

        .btn-action {
            background: transparent;
            color: #3498db;
            border: 1px solid #3498db;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            gap: 12px;
        }

        .btn-action:hover {
            background: #3498db;
            color: white;
        }

        /* Upcoming Holidays & Notifications */
        .upcoming-holidays,
        .notifications-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #2c3e50;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            border: none;
        }

        .view-all {
            color: #bdc3c7;
            font-size: 13px;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .view-all:hover {
            color: white;
        }

        .holiday-list,
        .notification-list {
            padding: 0;
        }

        .holiday-item,
        .notification-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .holiday-item:last-child,
        .notification-item:last-child {
            border-bottom: none;
        }

        .holiday-date {
            width: 60px;
            height: 60px;
            background: #f8f9fa;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .holiday-date .day {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
        }

        .holiday-date .month {
            font-size: 12px;
            color: #7f8c8d;
            text-transform: uppercase;
        }

        .holiday-info h6 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .holiday-info p {
            color: #7f8c8d;
            font-size: 13px;
            margin-bottom: 0;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: #3498db;
        }

        .notification-content {
            flex: 1;
        }

        .notification-content h6 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .notification-content p {
            color: #7f8c8d;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .notification-time {
            color: #bdc3c7;
            font-size: 12px;
        }

        .notification-item.unread h6 {
            color: #3498db;
        }

        /* Date Picker */
        .date-picker-container {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .input-group.flatpickr {
            width: 200px;
            margin-right: 15px;
        }

        .input-group-text {
            background-color: #3498db;
            color: white;
            border: none;
        }

        .form-control {
            border-color: #3498db;
        }

        .btn-edit-profile {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }

        .btn-edit-profile:hover {
            background-color: #27ae60;
            color: white;
        }

        .attendance_snapshot_card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            height: 100%;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;

        }

        .attendance_snapshot_card::before {
            content: '';
            position: absolute;
            top: -11px;
            left: 0;
            width: 100%;
            height: 9%;
               background: linear-gradient(to bottom, #f39c12, #d35400);

        }

        .Recruitment_card_one {
            background-color: #2980b9;
            color: white;
        }
        .Recruitment_card_two {
             background-color: #27ae60;
            color: white;

        }
        .Recruitment_card_three {
             background-color: #800080;
            color: white;

        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .profile-info {
                flex-direction: column;
                text-align: center;
            }

            .profile-avatar {
                margin-right: 0;
                margin-bottom: 15px;
            }

            .detail-item {
                text-align: left;
            }
        }

        @media (max-width: 768px) {

            .dashboard-header .col-md-8,
            .dashboard-header .col-md-4 {
                text-align: center !important;
            }

            .date-picker-container {
                justify-content: center;
                margin-top: 15px;
            }

            .quick-stats-row .col-md-3 {
                margin-bottom: 15px;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize date picker
        flatpickr("#dashboardDate", {
            dateFormat: "Y-m-d",
            defaultDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                // Handle date change if needed
                console.log("Selected date: " + dateStr);
            }
        });
    </script>
@endsection
