@extends('employee.employee_dashboard')
@section('employee')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <div class="container-fluid employee-dashboard">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="welcome-text">Welcome, {{ $employee->name }}</h1>
                    <p class="dashboard-subtitle">Employee Dashboard - {{ now()->format('l, F j, Y') }}</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="date-picker-container">
                        <div class="input-group flatpickr" id="dashboardDate">
                            <span class="input-group-text">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <input type="text" class="form-control text-white" placeholder="Select date" data-input>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Profile and Quick Stats -->
        <div class="row mb-4">
            <!-- Profile Card -->
            <div class="col-lg-4 mb-4">
                <div class="card profile-card">
                    <div class="card-header">
                        <h5><i class="fas fa-id-card me-2"></i>Employee Profile</h5>
                    </div>
                    <div class="card-body">
                        <div class="profile-info">
                            <div class="profile-avatar">
                                {{ strtoupper(substr($employee->name, 0, 1)) }}
                            </div>
                            <div class="profile-details">
                                <div class="detail-item">
                                    {{-- <span class="detail-label">Employee ID:</span> --}}
                                    <span class="detail-value"> <strong>ID: </strong>{{ $employee->employee_id }}</span>
                                </div>
                                <div class="detail-item">
                                    {{-- <span class="detail-label">Name: {{ $employee->name }}</span> --}}
                                    <span class="detail-value"><strong>Name: </strong>{{ $employee->name }}</span>
                                </div>
                                <div class="detail-item">
                                    {{-- <span class="detail-label">Email:</span> --}}
                                    <span class="detail-value"><strong>Email: </strong>{{ $employee->email }}</span>
                                </div>
                                <div class="detail-item">
                                    {{-- <span class="detail-label">Department:</span> --}}
                                    <span class="detail-value"><strong>Department:
                                        </strong>{{ $employee->department }}</span>
                                </div>
                                <div class="detail-item">
                                    {{-- <span class="detail-label">Designation:</span> --}}
                                    <span class="detail-value"><strong>Designation:
                                        </strong>{{ $employee->designation }}</span>
                                </div>
                                <div class="detail-item">
                                    {{-- <span class="detail-label">Employment Type:</span> --}}
                                    <span class="detail-value"><strong>Employment Type:
                                        </strong>{{ $employee->employment_type }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leave Balance -->
            <div class="col-lg-4 mb-4">
                <div class="card leave-balance-card">
                    <div class="card-header">
                        <h5><i class="fas fa-calendar-check me-2"></i>Leave Balance</h5>
                    </div>
                    <div class="card-body">
                        <div class="leave-balance">
                            <div class="leave-type pl">
                                <div class="leave-icon">
                                    <i class="fas fa-umbrella-beach"></i>
                                </div>
                                <div class="leave-info">
                                    <h6>Privilege Leave</h6>
                                    <h3>{{ $leaveBalanceData->pl_balance ?? 0 }}</h3>
                                    <span class="leave-label">Days Available</span>
                                </div>
                            </div>
                            <div class="leave-type sl">
                                <div class="leave-icon">
                                    <i class="fas fa-procedures"></i>
                                </div>
                                <div class="leave-info">
                                    <h6>Sick Leave</h6>
                                    <h3>{{ $leaveBalanceData->sl_balance ?? 0 }}</h3>
                                    <span class="leave-label">Days Available</span>
                                </div>
                            </div>
                            <div class="leave-type lop">
                                <div class="leave-icon">
                                    <i class="fas fa-calendar-times"></i>
                                </div>
                                <div class="leave-info">
                                    <h6>Loss of Pay</h6>
                                    <h3>{{ $leaveBalanceData->lop_days ?? 0 }}</h3>
                                    <span class="leave-label">Days Taken</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('check.leave') }}" class="btn btn-view-leaves">
                            <i class="fas fa-eye me-2"></i>Check Leave Balance
                        </a>
                    </div>
                </div>
            </div>

            <!-- Reporting Manager -->
            <div class="col-lg-4 mb-4">
                <div class="card manager-card">
                    <div class="card-header">
                        <h5><i class="fas fa-user-tie me-2"></i>My Reporting Manager</h5>
                    </div>
                    <div class="card-body">

                        <div class="manager-info">
                            <div class="manager-avatar">

                            </div>
                            <div class="manager-details">
                                <h4>Name: {{ $reportingManager->name }}</h4>
                                <p class="manager-designation">ID: {{ $reportingManager->employee_id }}</p>
                                <div class="manager-contact">
                                    <span class="contact-item">
                                        <i class="fas fa-envelope me-2"></i>{{ $reportingManager->email }}
                                    </span>
                                    <span class="contact-item">
                                        <i class="fas fa-building me-2"></i>{{ $reportingManager->department }}
                                    </span>
                                </div>
                                {{-- <button class="btn btn-contact-manager">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button> --}}
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Graph -->
        <div class="col-md-12 mb-4">
            <div class="card shadow-sm bg-light">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Monthly Attendance Graph</h5>
                </div>
                <div class="card-body">
                    <div id="attendanceGraph"></div>
                    <script src="https://code.highcharts.com/highcharts.js"></script>
                    <script>
                        var attendanceData = @json($attendanceData);

                        // Prepare data for Highcharts
                        var dates = [];
                        var checkInTimes = [];
                        var checkInTimeFormatted = [];
                        var colors = []; // New array to store the colors

                        // Loop through the data and prepare the dates, check-in times, and colors for plotting
                        attendanceData.forEach(function(item) {
                            dates.push(item.date); // Date in YYYY-MM-DD format

                            if (item.check_in_time) {
                                var checkInTime = new Date(item.check_in_time);
                                var checkInMinutes = (checkInTime.getHours() - 6) * 60 + checkInTime
                            .getMinutes(); // Convert to minutes after 6 AM
                                checkInTimes.push(checkInMinutes); // Store check-in time in minutes
                                checkInTimeFormatted.push(Highcharts.dateFormat('%H:%M',
                                checkInTime)); // Store formatted check-in time for display
                            } else {
                                checkInTimes.push(0); // No check-in time -> use 0 for absent
                                checkInTimeFormatted.push("Absent"); // Label as absent
                            }

                            // Push the corresponding color for the bar
                            colors.push(item.color);
                        });

                        // Generate the 2D column chart
                        Highcharts.chart('attendanceGraph', {
                            chart: {
                                type: 'column', // Use 2D column chart
                            },
                            title: {
                                text: 'Monthly Attendance with Check-in Times'
                            },
                            xAxis: {
                                categories: dates, // Display all dates of the month
                                title: {
                                    text: 'Date'
                                },
                                labels: {
                                    rotation: -45 // Rotate the labels for better readability
                                }
                            },
                            yAxis: {
                                title: {
                                    text: 'Check-in Time (Minutes after 6 AM)'
                                },
                                min: 0,
                                max: 720, // Maximum value is 12 hours * 60 minutes = 720 minutes
                                tickInterval: 60, // Interval for Y-axis ticks is 1 hour (60 minutes)
                                labels: {
                                    formatter: function() {
                                        var hours = Math.floor(this.value / 60); // Convert minutes to hours
                                        var minutes = this.value % 60;
                                        return hours + ':' + (minutes < 10 ? '0' : '') + minutes; // Format as HH:mm
                                    }
                                }
                            },
                            plotOptions: {
                                column: {
                                    dataLabels: {
                                        enabled: true,
                                        color: '#000000', // Set label color to black
                                        style: {
                                            fontSize: '13px'
                                        },
                                        formatter: function() {
                                            return checkInTimeFormatted[this.point
                                            .index]; // Show formatted check-in time or "Absent"
                                        }
                                    }
                                }
                            },
                            series: [{
                                name: '',
                                data: checkInTimes, // Data for the heights of the columns
                                colorByPoint: true,
                                colors: colors, // Use the color array for the bars
                                shadow: true
                            }]
                        });
                    </script>

                </div>
            </div>
        </div>


        <!-- Upcoming Holidays -->
        <div class="row">
            <div class="col-md-6">
                <div class="card holidays-card">
                    <div class="card-header">
                        <h5><i class="fas fa-glass-cheers me-2"></i>Upcoming Holidays</h5>
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
            <div class="col-md-6">
                <div class="card notifications-card">
                    <div class="card-header">
                        <h5><i class="fas fa-bell me-2"></i>Recent Notifications</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled">
                            <li class="notification-item">
                                <i class="fas fa-info-circle me-2"></i>
                                <span class="notification-text">Your leave request for 5 days has been approved.</span>
                                <span class="notification-time">2 hours ago</span>
                            </li>
                            <li class="notification-item">
                                <i class="fas fa-check-circle me-2"></i>
                                <span class="notification-text">You have successfully checked in today.</span>
                                <span class="notification-time">1 hour ago</span>
                            </li>
                            <li class="notification-item">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <span class="notification-text">Your attendance for yesterday is missing. Please
                                    check.</span>
                                <span class="notification-time">30 minutes ago</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>


        </div>




    </div>

    <style>
        /* Base Styles */
        .employee-dashboard {
            padding: 30px;
            background-color: #f8f9fa;
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

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #3498db;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
            border: none;
            font-weight: 600;
        }

        .card-header h5 {
            margin-bottom: 0;
        }

        /* Profile Card */
        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 30px;
            font-weight: bold;
        }

        .profile-details {
            flex: 1;
        }

        .detail-item {
            margin-bottom: 12px;
        }

        .detail-label {
            display: block;
            color: #7f8c8d;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .detail-value {
            color: #2c3e50;
            font-weight: 500;
        }

        .badge.bg-employment {
            background-color: #2ecc71;
            color: white;
        }

        /* Leave Balance Card */
        .leave-balance-card .card-header {
            background-color: #2ecc71;
        }

        .leave-balance {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .leave-type {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 8px;
            background-color: rgba(255, 255, 255, 0.2);
        }

        .leave-type.pl {
            background-color: rgba(52, 152, 219, 0.1);
        }

        .leave-type.sl {
            background-color: rgba(46, 204, 113, 0.1);
        }

        .leave-type.lop {
            background-color: rgba(231, 76, 60, 0.1);
        }

        .leave-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: white;
            font-size: 16px;
        }

        .leave-icon.pl {
            background-color: #3498db;
        }

        .leave-icon.sl {
            background-color: #2ecc71;
        }

        .leave-icon.lop {
            background-color: #e74c3c;
        }

        .leave-info h6 {
            color: #7f8c8d;
            font-size: 0.85rem;
            margin-bottom: 2px;
        }

        .leave-info h3 {
            color: #2c3e50;
            font-weight: 700;
            margin-bottom: 0;
        }

        .leave-label {
            color: #95a5a6;
            font-size: 0.75rem;
        }

        .btn-view-leaves {
            margin-top: 20px;
            width: 100%;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 8px;
            font-weight: 500;
        }

        /* Manager Card */
        .manager-card .card-header {
            background-color: #9b59b6;
        }

        .manager-info {
            display: flex;
            align-items: center;
        }



        .manager-details {
            flex: 1;
        }

        .manager-details h4 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .manager-designation {
            color: #7f8c8d;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .manager-contact {
            margin-bottom: 15px;
        }

        .contact-item {
            display: block;
            color: #7f8c8d;
            font-size: 0.85rem;
            margin-bottom: 5px;
        }

        .btn-contact-manager {
            background-color: #9b59b6;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 6px 12px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .no-manager {
            text-align: center;
            padding: 20px;
            color: #95a5a6;
        }

        /* Attendance Card */
        .attendance-card .card-header {
            background-color: #e74c3c;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .attendance-filter .form-select {
            width: 180px;
            background-color: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
        }

        #attendanceGraph {
            height: 300px;
        }

        /* Holidays Card */
        .holidays-card .card-header {
            background-color: #f39c12;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .view-all {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.85rem;
            text-decoration: none;
        }

        .holiday-list {
            padding: 0;
        }

        .holiday-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .holiday-item:last-child {
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
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .profile-info {
                flex-direction: row;
                text-align: left;
            }

            .profile-avatar {
                margin: 0 20px 0 0;
            }

            .manager-info {
                flex-direction: column;
                text-align: center;
            }

            .manager-avatar {
                margin: 0 auto 15px;
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

            .profile-info {
                flex-direction: column;
            }

            .profile-avatar {
                margin: 0 auto 20px;
            }
        }
    </style>

    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        // Initialize date picker
        flatpickr("#dashboardDate", {
            dateFormat: "Y-m-d",
            defaultDate: "today"
        });

        // Attendance Graph
        var attendanceData = @json($attendanceData);

        // Prepare data for Highcharts
        var dates = [];
        var checkInTimes = [];
        var checkInTimeFormatted = [];
        var colors = [];

        attendanceData.forEach(function(item) {
            dates.push(item.date);
            if (item.check_in_time) {
                var checkInTime = new Date(item.check_in_time);
                var checkInMinutes = (checkInTime.getHours() - 6) * 60 + checkInTime.getMinutes();
                checkInTimes.push(checkInMinutes);
                checkInTimeFormatted.push(Highcharts.dateFormat('%H:%M', checkInTime));
            } else {
                checkInTimes.push(0);
                checkInTimeFormatted.push("Absent");
            }
            colors.push(item.color);
        });

        // Generate the column chart
        Highcharts.chart('attendanceGraph', {
            chart: {
                type: 'column',
                backgroundColor: 'transparent'
            },
            title: {
                text: 'Monthly Attendance',
                style: {
                    color: '#2c3e50',
                    fontWeight: '600'
                }
            },
            xAxis: {
                categories: dates,
                labels: {
                    rotation: -45,
                    style: {
                        color: '#7f8c8d'
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Check-in Time',
                    style: {
                        color: '#7f8c8d'
                    }
                },
                min: 0,
                max: 720,
                tickInterval: 60,
                labels: {
                    formatter: function() {
                        var hours = Math.floor(this.value / 60);
                        var minutes = this.value % 60;
                        return hours + ':' + (minutes < 10 ? '0' : '') + minutes;
                    },
                    style: {
                        color: '#7f8c8d'
                    }
                }
            },
            plotOptions: {
                column: {
                    dataLabels: {
                        enabled: true,
                        color: '#2c3e50',
                        style: {
                            textOutline: 'none',
                            fontWeight: '500'
                        },
                        formatter: function() {
                            return checkInTimeFormatted[this.point.index];
                        }
                    },
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Check-in Time',
                data: checkInTimes,
                colorByPoint: true,
                colors: colors
            }],
            credits: {
                enabled: false
            }
        });
    </script>
@endsection
