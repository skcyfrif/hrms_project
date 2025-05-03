@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="row profile-body">
        <!-- Middle Wrapper Start -->
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <h6 class="card-title text-center mb-4">Add Salary Details Of Employee</h6>

                        <!-- Form Start -->
                        {{-- <form method="POST" action="{{ route('store.salaryapproval') }}" class="forms-sample" id="employeeForm"> --}}
                            <form method="POST" action="#" class="forms-sample" id="employeeForm">
                            @csrf

                            <!-- Step 1: Employee Details -->
                            <div class="form-step" id="step-1">
                                <div class="row mb-4">
                                    <h3 style="color: red; margin-top: 1cm;">Employee Information</h3>
                                    <div class="col-md-4 mb-3">
                                        <label for="employee_id" class="form-label @error('employee_id') is-invalid @enderror">Employee ID</label>

                                        <select class="form-control" id="employee_id" name="employee_id">
                                            <option value="disabled">-- Select --</option>

                                            @foreach($salaries as $salary)
                                                <option value="{{ $salary->id }}">{{ $salary->employee_id }}</option>
                                            @endforeach
                                            @foreach($sima as $sim)
                                                <option value="{{ $sim->id }}">{{ $sim->employee_id }}</option>
                                            @endforeach
                                            {{-- @foreach($mys as $my)
                                                <option value="{{ $my->id }}">{{ $my->employee_id }}</option>
                                            @endforeach --}}

                                        </select>

                                        @error('employee_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="col-md-4 mb-3">
                                        <label for="name" class="form-label @error('name') is-invalid @enderror">Name</label>
                                        <input type="text" class="form-control" id="name" name="name">
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="days_of_current_month" class="form-label @error('days_of_current_month') is-invalid @enderror">days of current month</label>
                                        <input type="text" class="form-control" id="days_of_current_month" name="days_of_current_month">
                                        @error('days_of_current_month')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="no_of_working_days_in_current_month" class="form-label @error('no_of_working_days_in_current_month') is-invalid @enderror">no. of working days in current month</label>
                                        <input type="text" class="form-control" id="no_of_working_days_in_current_month" name="no_of_working_days_in_current_month">
                                        @error('no_of_working_days_in_current_month')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="no_of_days_present" class="form-label @error('no_of_days_present') is-invalid @enderror">no. of days present</label>
                                        <input type="text" class="form-control" id="no_of_days_present" name="no_of_days_present">
                                        @error('no_of_days_present')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="total_holidays" class="form-label @error('total_holidays') is-invalid @enderror">total holidays</label>
                                        <input type="text" class="form-control" id="total_holidays" name="total_holidays">
                                        @error('total_holidays')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="col-md-6 mb-2">
                                        <label for="total_leave" class="form-label @error('total_leave') is-invalid @enderror">total leave</label>
                                        <input type="text" class="form-control" id="total_leave" name="total_leave">
                                        @error('total_leave')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="paid_leave" class="form-label @error('paid_leave') is-invalid @enderror">paid leave</label>
                                        <input type="text" class="form-control" id="paid_leave" name="paid_leave">
                                        @error('paid_leave')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label for="unpaid_leave" class="form-label @error('unpaid_leave') is-invalid @enderror">unpaid leave</label>
                                        <input type="text" class="form-control" id="unpaid_leave" name="unpaid_leave">
                                        @error('unpaid_leave')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-success px-4 py-2">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
     $(document).ready(function () {
        // Listen for change event on the employee_id dropdown
        $('#employee_id').on('change', function () {
            var employee_id = $(this).val();  // Get the selected employee_id

            // If the selected employee_id is not "disabled", send an AJAX request
            if (employee_id !== 'disabled') {
                $.ajax({
                    url: '/employee/details/' + employee_id,  // Call the employee details endpoint
                    method: 'GET',
                    success: function (response) {
                        if (response.success) {
                            // Populate the fields with the returned employee data
                            $('#name').val(response.data.name);
                            // $('#department').val(response.data.department);
                            // $('#designation').val(response.data.designation);
                            // $('#email').val(response.data.email);
                            // $('#phone_number').val(response.data.phone_number);
                            // $('#account_number').val(response.data.account_number);
                            // $('#ifsc_code').val(response.data.ifsc_code);
                            // $('#bank_name').val(response.data.bank_name);
                            // $('#branch_name').val(response.data.branch_name);
                            // $('#basic_salary').val(response.data.basic_salary);
                        } else {
                            // Clear the fields if no employee data is found
                            $('#name').val('');
                            // $('#department').val('');
                            // $('#designation').val('');
                            // $('#email').val('');
                            // $('#phone_number').val('');
                            // $('#account_number').val('');
                            // $('#ifsc_code').val('');
                            // $('#bank_name').val('');
                            // $('#branch_name').val('');
                            // $('#basic_salary').val('');

                            alert(response.message);  // Show an alert if employee not found
                        }
                    },
                    error: function () {
                        alert('Error fetching employee data.');
                    }
                });
            } else {
                // Clear the fields if no employee is selected
                $('#name').val('');
                // $('#department').val('');
                // $('#designation').val('');
                // $('#email').val('');
                // $('#phone_number').val('');
            }
        });
    });

</script>
@endsection
