@extends('admin.admin_dashboard')
@section('admin')

    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <!-- Button with dropdown for selecting Month and Year -->
                <div class="dropdown">
                    {{-- <a href="#" class="btn btn-inverse-info dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Pay Slip
                    </a> --}}

                    <!-- Updated button to link to accrueLeave -->
                    {{-- <a href="{{ route('accrueLeave') }}" class="btn btn-inverse-info">
                        Monthly add leave balance
                    </a> --}}

                    <div class="dropdown-menu">
                        <form id="payrollForm" action="#" method="GET">
                            <!-- Month Dropdown -->
                            <div class="form-group">
                                <label for="month">Month</label>
                                <select class="form-control" id="month" name="month" onchange="updateFormAction()">
                                    <option value="01" {{ request('month') == '01' ? 'selected' : '' }}>January</option>
                                    <option value="02" {{ request('month') == '02' ? 'selected' : '' }}>February
                                    </option>
                                    <option value="03" {{ request('month') == '03' ? 'selected' : '' }}>March</option>
                                    <option value="04" {{ request('month') == '04' ? 'selected' : '' }}>April</option>
                                    <option value="05" {{ request('month') == '05' ? 'selected' : '' }}>May</option>
                                    <option value="06" {{ request('month') == '06' ? 'selected' : '' }}>June</option>
                                    <option value="07" {{ request('month') == '07' ? 'selected' : '' }}>July</option>
                                    <option value="08" {{ request('month') == '08' ? 'selected' : '' }}>August</option>
                                    <option value="09" {{ request('month') == '09' ? 'selected' : '' }}>September
                                    </option>
                                    <option value="10" {{ request('month') == '10' ? 'selected' : '' }}>October
                                    </option>
                                    <option value="11" {{ request('month') == '11' ? 'selected' : '' }}>November
                                    </option>
                                    <option value="12" {{ request('month') == '12' ? 'selected' : '' }}>December
                                    </option>
                                </select>
                            </div>

                            <!-- Year Dropdown -->
                            <div class="form-group">
                                <label for="year">Year</label>
                                <select class="form-control" id="year" name="year" onchange="updateFormAction()">
                                    <option value="2023" {{ request('year') == '2023' ? 'selected' : '' }}>2023</option>
                                    <option value="2024" {{ request('year') == '2024' ? 'selected' : '' }}>2024</option>
                                    <option value="2025" {{ request('year') == '2025' ? 'selected' : '' }}>2025</option>
                                    <!-- Add more years as needed -->
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>

            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">pay roll of All Hr Manager</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>name</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Days in month</th>
                                        <th>Working Days</th>
                                        <th>Public Holiday</th>
                                        <th>Sunday</th>
                                        <th>Total Holiday</th>
                                        <th>No Of days Present</th>
                                        <th>LOP</th>
                                        <th>PL</th>
                                        <th>SL</th>
                                        <th>Salary For The Month</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payrolls as $key => $payroll)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $payroll->payrool->name }}</td>
                                            <td>{{ \Carbon\Carbon::create()->month((int) $payroll->month)->format('F') }}
                                            </td>
                                            <td>{{ $payroll->year }}</td>
                                            <td>{{ $payroll->total_days }}</td>
                                            <td>{{ $payroll->working_days }}</td>
                                            <td>{{ $payroll->holidays }}</td>
                                            <td>{{ $payroll->sundays }}</td>
                                            <td>{{ $payroll->holidays + $payroll->sundays }}</td>
                                            <td>{{ $payroll->days_present }}</td>
                                            <td>{{ $payroll->lop_days }}</td>
                                            <td>{{ $payroll->paid_leave_days }}</td>
                                            <td>{{ $payroll->sick_leave_days }}</td>
                                            <td>{{ $payroll->gross_salary }}</td>
                                            {{-- <td>
                                            <a href="#" class="btn btn-inverse-warning">Generate Payslip</a>
                                        </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to update the form action URL based on selected year and month
        function updateFormAction() {
            var month = document.getElementById('month').value;
            var year = document.getElementById('year').value;

            // Check if both month and year are selected
            if (!month || !year) {
                alert('Please select both year and month');
                return false; // Prevent form submission if year or month is not selected
            }

            // Generate the year-month string in 'YYYY-MM' format
            var yearMonth = year + '-' + month;

            // Construct the URL for the form action
            var actionUrl = '/payroll/generate/' + yearMonth;

            // Update the form action URL
            document.getElementById('payrollForm').action = actionUrl;

            return true; // Allow form submission
        }

        // Call the function initially to set the action URL based on selected year and month
        updateFormAction();
    </script>
@endsection
