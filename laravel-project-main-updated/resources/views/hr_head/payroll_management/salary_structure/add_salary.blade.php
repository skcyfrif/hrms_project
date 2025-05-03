@extends('hr_head.hr_head_dashboard')
@section('hr_head')

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
                        <form method="POST" action="{{ route('store.salaries') }}" class="forms-sample" id="employeeForm">
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
                                            @foreach($mys as $my)
                                                <option value="{{ $my->id }}">{{ $my->employee_id }}</option>
                                            @endforeach

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
                                        <label for="department" class="form-label @error('department') is-invalid @enderror">Department</label>
                                        <input type="text" class="form-control" id="department" name="department">
                                        @error('department')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="designation" class="form-label @error('designation') is-invalid @enderror">Designation</label>
                                        <input type="text" class="form-control" id="designation" name="designation">
                                        @error('designation')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="email" class="form-label @error('email') is-invalid @enderror">Email</label>
                                        <input type="text" class="form-control" id="email" name="email">
                                        @error('email')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="phone_number" class="form-label @error('phone_number') is-invalid @enderror">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number">
                                        @error('phone_number')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- bank details --}}

                                    <h3 style="color: red; margin-top: 1cm;">Bank Details</h3>
                                    <div class="col-md-6 mb-2">
                                        <label for="account_number" class="form-label @error('account_number') is-invalid @enderror">Account Number</label>
                                        <input type="text" class="form-control" id="account_number" name="account_number">
                                        @error('account_number')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="ifsc_code" class="form-label @error('ifsc_code') is-invalid @enderror">Ifsc Code</label>
                                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code">
                                        @error('ifsc_code')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-2">
                                        <label for="bank_name" class="form-label @error('bank_name') is-invalid @enderror">Bank Name</label>
                                        <input type="text" class="form-control" id="bank_name" name="bank_name">
                                        @error('bank_name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="branch_name" class="form-label @error('branch_name') is-invalid @enderror">Branch Name</label>
                                        <input type="text" class="form-control" id="branch_name" name="branch_name">
                                        @error('branch_name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- salary details --}}
                                    <h3 style="color: red; margin-top: 1cm;">Salary Details</h3>


                                    <div class="col-md-4 mb-3">
                                        <label for="basic_salary" class="form-label @error('basic_salary') is-invalid @enderror">Basic Salary</label>
                                        <input type="text" class="form-control" id="basic_salary" name="basic_salary">
                                        @error('basic_salary')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="allowances" class="form-label @error('allowances') is-invalid @enderror">Allowances</label>
                                        <select class="form-control" id="allowances" name="allowances">
                                            <option value="disabled">-- Select --</option>
                                            <option value="housing">Housing</option>
                                            <option value="transportation">Transportation</option>
                                            <option value="medical">Medical</option>
                                            {{-- <option value="other">Other</option> --}}
                                        </select>
                                        @error('allowances')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="deductions" class="form-label @error('deductions') is-invalid @enderror">Deductions</label>
                                        <select class="form-control" id="deductions" name="deductions">
                                            <option value="disabled">-- Select --</option>
                                            <option value="taxes">Taxes</option>
                                            <option value="insurance">Insurance</option>
                                            <option value="retirement-contributions">Retirement Contributions</option>
                                            {{-- <option value="others">Others</option> --}}
                                        </select>
                                        @error('deductions')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="bonuses" class="form-label @error('bonuses') is-invalid @enderror">Bonuses</label>
                                        <input type="text" class="form-control" id="bonuses" name="bonuses">
                                        @error('bonuses')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="overtime_pay" class="form-label @error('overtime_pay') is-invalid @enderror">Overtime Pay</label>
                                        <input type="text" class="form-control" id="overtime_pay" name="overtime_pay">
                                        @error('overtime_pay')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary px-4 py-2" id="next-1">Next</button>
                                </div>
                            </div>

                            <!-- Step 2: Additional Details -->
                            {{-- Payment Information --}}
                            <div class="form-step" id="step-2" style="display: none;">
                                <div class="row mb-4">
                                    <h3 style="color: red; margin-top: 1cm;">Payment Information</h3>
                                    <div class="col-md-4">
                                        <label for="salary_for_the_month" class="form-label @error('salary_for_the_month') is-invalid @enderror">Salary For The Month</label>
                                        <input type="text" class="form-control" id="salary_for_the_month" name="salary_for_the_month">
                                        @error('salary_for_the_month')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="no_of_working_day" class="form-label @error('no_of_working_day') is-invalid @enderror">No. Of Working Day</label>
                                        <input class="form-control" id="no_of_working_day" name="no_of_working_day">
                                        @error('no_of_working_day')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total_leave_taken" class="form-label @error('total_leave_taken') is-invalid @enderror">Total Leave Taken</label>
                                        <input class="form-control" id="total_leave_taken" name="total_leave_taken">
                                        @error('total_leave_taken')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="payment_date" class="form-label @error('payment_date') is-invalid @enderror">Payment Date</label>
                                        <input class="form-control" id="payment_date" name="payment_date">
                                        @error('payment_date')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="amount" class="form-label @error('amount') is-invalid @enderror">Amount</label>
                                        <input type="text" class="form-control" id="amount" name="amount">
                                        @error('amount')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="payment_method" class="form-label @error('payment_method') is-invalid @enderror">Payment Method</label>
                                        <select class="form-control" id="payment_method" name="payment_method">
                                            <option value="disabled">-- Select --</option>
                                            <option value="bank-transfer">Bank Transfer</option>
                                            <option value="digital-wallet">Digital Wallet</option>
                                            {{-- <option value="other">Other</option> --}}
                                        </select>
                                        @error('payment_method')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    {{-- Comments/Notes --}}
                                    <h3 style="color: red; margin-top: 1cm;">Comments/Notes</h3>
                                    <div class="col-md-4">
                                        <label for="remarks" class="form-label @error('remarks') is-invalid @enderror">Remarks</label>
                                        <input type="text" class="form-control" id="remarks" name="remarks">
                                        @error('remarks')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <!-- Back Button -->
                                    <button type="button" class="btn btn-secondary px-4 py-2" id="back-2">Back</button>
                                    <!-- Submit Button -->
                                    <button type="submit" class="btn btn-success px-4 py-2">Submit</button>
                                </div>
                            </div>

                            <!-- Step 3: Final Step (If needed) -->
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
                            $('#department').val(response.data.department);
                            $('#designation').val(response.data.designation);
                            $('#email').val(response.data.email);
                            $('#phone_number').val(response.data.phone_number);
                            $('#account_number').val(response.data.account_number);
                            $('#ifsc_code').val(response.data.ifsc_code);
                            $('#bank_name').val(response.data.bank_name);
                            $('#branch_name').val(response.data.branch_name);
                            $('#basic_salary').val(response.data.basic_salary);
                        } else {
                            // Clear the fields if no employee data is found
                            $('#name').val('');
                            $('#department').val('');
                            $('#designation').val('');
                            $('#email').val('');
                            $('#phone_number').val('');
                            $('#account_number').val('');
                            $('#ifsc_code').val('');
                            $('#bank_name').val('');
                            $('#branch_name').val('');
                            $('#basic_salary').val('');

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
                $('#department').val('');
                $('#designation').val('');
                $('#email').val('');
                $('#phone_number').val('');
            }
        });
    });

</script>
<script>

    $(document).ready(function() {
        // Go to Step 2
        $('#next-1').click(function() {
            $('#step-1').hide();
            $('#step-2').show();
        });

        // Go Back to Step 1
        $('#back-2').click(function() {
            $('#step-2').hide();
            $('#step-1').show();
        });
    });
</script>

@endsection
