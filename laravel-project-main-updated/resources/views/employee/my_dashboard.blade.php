@extends('employee.employee_dashboard')

@section('employee')
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h3 class="text-primary">Welcome, {{ $employee->name }}</h3>
                <p class="text-muted">Your dashboard for the HRMS system</p>
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-warning">Edit Profile</button>
            </div>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                <span class="input-group-text input-group-addon bg-transparent border-primary"
                    data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                <input type="text" class="form-control bg-transparent border-primary text-white"
                    placeholder="Select date" data-input>
            </div>
        </div>


        <!-- Dashboard Info Row -->
        <div class="row">
            <!-- Profile Info -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm bg-light">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Profile Information</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Name:</strong> {{ $employee->name }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ $employee->email }}</li>
                            <li class="list-group-item"><strong>Department:</strong> {{ $employee->department }}</li>
                            <li class="list-group-item"><strong>Designation:</strong> {{ $employee->designation }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Leave Balance -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm bg-light">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Leave Balance</h5>
                    </div>
                    <div class="card-body">
                        {{-- Optional leave balance display --}}
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Available PL:</strong> {{ $leaveBalanceData->pl_balance ?? 0 }}</li>
                            <li class="list-group-item"><strong>Available SL:</strong> {{ $leaveBalanceData->sl_balance ?? 0 }}</li>
                            <li class="list-group-item"><strong>Taken LOP:</strong> {{ $leaveBalanceData->lop_days ?? 0 }}</li>

                            {{-- <li class="list-group-item"><strong>Designation:</strong> {{ $employee->designation }}</li> --}}
                        </ul>
                    </div>
                </div>
            </div>



            <!-- Reporting Manager -->
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm bg-light">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">My Reporting Manager</h5>
                    </div>
                    <div class="card-body">
                        @if ($reportingManager)
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><strong>Name:</strong> {{ $reportingManager->name }}</li>
                                <li class="list-group-item"><strong>Email:</strong> {{ $reportingManager->email }}</li>
                                <li class="list-group-item"><strong>Department:</strong> {{ $reportingManager->department }}
                                </li>
                                <li class="list-group-item"><strong>Designation:</strong>
                                    {{ $reportingManager->designation }}</li>
                            </ul>
                        @else
                            <p>No reporting manager assigned.</p>
                        @endif
                    </div>
                </div>
            </div>


            <!-- Monthly Attendance Graph -->
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
                                    var checkInMinutes = (checkInTime.getHours() - 6) * 60 + checkInTime.getMinutes(); // Convert to minutes after 6 AM
                                    checkInTimes.push(checkInMinutes); // Store check-in time in minutes
                                    checkInTimeFormatted.push(Highcharts.dateFormat('%H:%M', checkInTime)); // Store formatted check-in time for display
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
                                                return checkInTimeFormatted[this.point.index]; // Show formatted check-in time or "Absent"
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




        </div>
    </div>

    <!-- Other sections (Notifications, Upcoming Holidays) -->
    <!-- Upcoming Holidays -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm bg-light">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Upcoming Holidays</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        {{-- @forelse($holidays as $holiday)
                            <li class="list-group-item">{{ $holiday->name }} - {{ $holiday->date->format('Y-m-d') }}</li>
                        @empty
                            <li class="list-group-item">No upcoming holidays.</li>
                        @endforelse --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection


    @section('styles')
        <style>
            /* Additional Custom Styling */
            .card-header {
                font-weight: bold;
            }

            .btn-warning {
                background-color: #FFC107;
                /* Yellow */
                border-color: #FFC107;
            }

            .btn-warning:hover {
                background-color: #FF9800;
                /* Darker Yellow */
                border-color: #FF9800;
            }

            .list-group-item {
                background-color: #f9f9f9;
                /* Light gray for better readability */
            }

            .list-group-item strong {
                color: #007bff;
                /* Blue color for labels */
            }

            .card-body {
                padding: 20px;
            }

            .container-fluid {
                padding: 30px;
            }
        </style>

        <script>
            // Generate attendance hours data (6 to 12 hrs) for current month's first 10 days
            const today = new Date();
            const year = today.getFullYear();
            const month = today.getMonth(); // 0-indexed

            const data = [];
            for (let day = 1; day <= 10; day++) {
                const dateStr = `${year}-${(month + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
                const randomHours = Math.floor(Math.random() * 7) + 6; // Random hours between 6 and 12
                data.push([dateStr, randomHours]);
            }

            Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Employee Attendance Graph (Current Month)'
                },
                xAxis: {
                    type: 'category',
                    labels: {
                        autoRotation: [-45, -90],
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                },
                yAxis: {
                    min: 0,
                    max: 12,
                    title: {
                        text: 'Time (Hours)'
                    },
                    tickInterval: 1
                },
                legend: {
                    enabled: false
                },
                tooltip: {
                    pointFormat: 'Hours worked: <b>{point.y} hrs</b>'
                },
                series: [{
                    name: 'Time',
                    colors: [
                        '#9b20d9', '#9215ac', '#861ec9', '#7a17e6', '#7010f9',
                        '#691af3', '#6225ed', '#5b30e7', '#533be1', '#4c46db'
                    ],
                    colorByPoint: true,
                    groupPadding: 0,
                    data: data,
                    dataLabels: {
                        enabled: true,
                        rotation: -90,
                        color: '#FFFFFF',
                        inside: true,
                        verticalAlign: 'top',
                        format: '{point.y} hrs',
                        y: 10,
                        style: {
                            fontSize: '13px',
                            fontFamily: 'Verdana, sans-serif'
                        }
                    }
                }]
            });
        </script>
    @endsection
