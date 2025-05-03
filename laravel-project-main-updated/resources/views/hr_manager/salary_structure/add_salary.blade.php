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
                        <form method="POST" action="{{ route('store.empsalaries') }}" class="forms-sample" id="employeeForm">
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
                                        <label for="doj" class="form-label @error('doj') is-invalid @enderror">DOJ</label>
                                        <input type="date" class="form-control" id="doj" name="doj">
                                        @error('doj')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="gender" class="form-label @error('gender') is-invalid @enderror">Gender</label>
                                        <input type="text" class="form-control" id="gender" name="gender">
                                        @error('gender')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-4 mb-3">
                                        <label for="grade" class="form-label @error('grade') is-invalid @enderror">Grade</label>
                                        <input type="text" class="form-control" id="grade" name="grade" value="{{ old('grade') }}">
                                        @error('grade')
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

                                    <div class="col-md-4">
                                        <label for="salary_for_the_month" class="form-label @error('salary_for_the_month') is-invalid @enderror">Salary For The Month</label>
                                        <input type="text" class="form-control" id="salary_for_the_month" name="salary_for_the_month">
                                        @error('salary_for_the_month')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="house_rent_allowance" class="form-label @error('house_rent_allowance') is-invalid @enderror">House Rent Allowance</label>
                                        <input type="text" class="form-control" id="house_rent_allowance" name="house_rent_allowance" value="{{ old('house_rent_allowance') }}">
                                        @error('house_rent_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <div class="col-md-4 mb-3">
                                        <label for="conveyance_allowance" class="form-label @error('conveyance_allowance') is-invalid @enderror">Conveyance Allowance</label>
                                        <input type="text" class="form-control" id="conveyance_allowance" name="conveyance_allowance" value="{{ old('conveyance_allowance') }}">
                                        @error('conveyance_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="lunch_allowance" class="form-label @error('lunch_allowance') is-invalid @enderror">Lunch Allowance</label>
                                        <input type="text" class="form-control" id="lunch_allowance" name="lunch_allowance" value="{{ old('lunch_allowance') }}">
                                        @error('lunch_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>




                                    <div class="col-md-4 mb-3">
                                        <label for="medical_allowance" class="form-label @error('medical_allowance') is-invalid @enderror">Medical Allowance</label>
                                        <input type="text" class="form-control" id="medical_allowance" name="medical_allowance" value="{{ old('medical_allowance') }}">
                                        @error('medical_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="other_allowance" class="form-label @error('other_allowance') is-invalid @enderror">Other Allowance</label>
                                        <input type="text" class="form-control" id="other_allowance" name="other_allowance" value="{{ old('other_allowance') }}">
                                        @error('other_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="leave_travel_allowance" class="form-label @error('leave_travel_allowance') is-invalid @enderror">Leave Travel Allowance</label>
                                        <input type="text" class="form-control" id="leave_travel_allowance" name="leave_travel_allowance" value="{{ old('leave_travel_allowance') }}">
                                        @error('leave_travel_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="personal_pay" class="form-label @error('personal_pay') is-invalid @enderror">Personal  Pay</label>
                                        <input type="text" class="form-control" id="personal_pay" name="personal_pay" value="{{ old('personal_pay') }}">
                                        @error('personal_pay')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                <div class="row mb-4">
                                    <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Deductions</h3>
                                    <div class="col-md-4">
                                        {{-- <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Deductions</h3> --}}
                                        <label for="professional_tax" class="form-label @error('professional_tax') is-invalid @enderror">Professional Tax</label>
                                        <input type="text" class="form-control" id="professional_tax" name="professional_tax" value="{{ old('professional_tax') }}">
                                        @error('professional_tax')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="esic" class="form-label @error('esic') is-invalid @enderror">ESIC</label>
                                        <input type="text" class="form-control" id="esic" name="esic" value="{{ old('esic') }}">
                                        @error('esic')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                <div class="row mb-4">
                                    <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Net Salary</h3>
                                    <div class="col-md-6">
                                        <label for="net_salary_payables" class="form-label @error('net_salary_payables') is-invalid @enderror">Net Salary Payable</label>
                                        <input type="text" class="form-control" id="net_salary_payables" name="net_salary_payables" readonly>
                                        @error('net_salary_payables')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                    <div class="col-md-4 mb-3">
                                        <label for="lop_days" class="form-label @error('lop_days') is-invalid @enderror">LOP Days</label>
                                        <input type="text" class="form-control" id="lop_days" name="lop_days" value="{{ old('lop_days') }}">
                                        @error('lop_days')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="standard_days" class="form-label @error('standard_days') is-invalid @enderror">Standard Days</label>
                                        <input type="text" class="form-control" id="standard_days" name="standard_days" value="{{ old('standard_days') }}">
                                        @error('standard_days')
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
                                    {{-- <div class="col-md-4">
                                        <label for="salary_for_the_month" class="form-label @error('salary_for_the_month') is-invalid @enderror">Salary For The Month</label>
                                        <input type="text" class="form-control" id="salary_for_the_month" name="salary_for_the_month">
                                        @error('salary_for_the_month')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
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


                                    {{-- Comments/Notes --}}
                                    {{-- <h3 style="color: red; margin-top: 1cm;">Comments/Notes</h3> --}}
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
    function calculateNetSalary() {
        var salary = parseFloat($("#salary_for_the_month").val()) || 0;

        // Ensure salary is set before proceeding
        if (salary === 0) {
            console.warn("Salary for the month is missing. Skipping salary calculation.");
            return;
        }

        var houseRentAllowance = parseFloat($("#house_rent_allowance").val()) || 0;
        var conveyanceAllowance = parseFloat($("#conveyance_allowance").val()) || 0;
        var lunchAllowance = parseFloat($("#lunch_allowance").val()) || 0;
        var medicalAllowance = parseFloat($("#medical_allowance").val()) || 0;
        var otherAllowance = parseFloat($("#other_allowance").val()) || 0;
        var leaveTravelAllowance = parseFloat($("#leave_travel_allowance").val()) || 0;
        var personalPay = parseFloat($("#personal_pay").val()) || 0;

        var totalAllowances = houseRentAllowance + conveyanceAllowance + lunchAllowance + medicalAllowance + otherAllowance + leaveTravelAllowance + personalPay;

        var professionalTax = parseFloat($("#professional_tax").val()) || 0;
        var esic = parseFloat($("#esic").val()) || 0;

        var totalDeductions = professionalTax + esic;
        var netSalary = salary + totalAllowances - totalDeductions;

        $("#net_salary_payables").val(netSalary.toFixed(2));
    }

    // Attach event listeners to relevant input fields
    $("input").on("input", function () {
        calculateNetSalary();
    });
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
                            $('#doj').val(response.data.doj);
                            $('#gender').val(response.data.gender);
                            // $('#phone_number').val(response.data.phone_number);
                            $('#account_number').val(response.data.account_number);
                            $('#ifsc_code').val(response.data.ifsc_code);
                            $('#bank_name').val(response.data.bank_name);
                            $('#branch_name').val(response.data.branch_name);
                            $('#basic_salary').val(response.data.basic_salary);
                            $('#house_rent_allowance').val(response.data.house_rent_allowance);
                            $('#conveyance_allowance').val(response.data.conveyance_allowance);
                            $('#lunch_allowance').val(response.data.lunch_allowance);
                            $('#personal_pay').val(response.data.personal_pay);
                            $('#medical_allowance').val(response.data.medical_allowance);
                            $('#other_allowance').val(response.data.other_allowance);
                            $('#leave_travel_allowance').val(response.data.leave_travel_allowance);
                            // $('#total_ammount').val(response.data.total_ammount);
                            $('#professional_tax').val(response.data.professional_tax);
                            $('#esic').val(response.data.esic);
                            // $('#advance').val(response.data.advance);
                            $('#net_salary_payables').val(response.data.net_salary_payables);
                            $('#lop_days').val(response.data.payroll.lop_days);
                            $('#standard_days').val(response.data.payroll.total_days);
                            $('#salary_for_the_month').val(response.data.payroll.gross_salary);
                            $('#no_of_working_day').val(response.data.payroll.working_days);
                            $('#total_leave_taken').val(
  response.data.payroll.lop_days + response.data.payroll.paid_leave_days + response.data.payroll.sick_leave_days
);
setTimeout(calculateNetSalary, 100);
                        } else {
                            // Clear the fields if no employee data is found
                            $('#name').val('');
                            $('#department').val('');
                            $('#doj').val('');
                            $('#gender').val('');
                            // $('#phone_number').val('');
                            $('#account_number').val('');
                            $('#ifsc_code').val('');
                            $('#bank_name').val('');
                            $('#branch_name').val('');
                            $('#basic_salary').val('');
                            $('#house_rent_allowance').val('');
                            $('#conveyance_allowance').val('');
                            $('#lunch_allowance').val('');
                            $('#personal_pay').val('');
                            $('#medical_allowance').val('');
                            $('#other_allowance').val('');
                            $('#leave_travel_allowance').val('');
                            // $('#total_ammount').val('');
                            $('#professional_tax').val('');
                            $('#esic').val('');
                            // $('#advance').val('');
                            $('#net_salary_payables').val('');
                            $('#lop_days').val('');
                            $('#standard_days').val('');
                            $('#salary_for_the_month').val('');
                            $('#no_of_working_day').val('');
                            $('#total_leave_taken').val('');

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
                $('#doj').val('');
                $('#gender').val('');
                // $('#phone_number').val('');
            }
        });
        calculateNetSalary();
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
{{-- <script>
    $(document).ready(function () {
        function calculateNetSalary() {
            var salary = parseFloat($("#salary_for_the_month").val()) || 0;
            var houseRentAllowance = parseFloat($("#house_rent_allowance").val()) || 0;
            var conveyanceAllowance = parseFloat($("#conveyance_allowance").val()) || 0;
            var lunchAllowance = parseFloat($("#lunch_allowance").val()) || 0;
            var medicalAllowance = parseFloat($("#medical_allowance").val()) || 0;
            var otherAllowance = parseFloat($("#other_allowance").val()) || 0;
            var leaveTravelAllowance = parseFloat($("#leave_travel_allowance").val()) || 0;
            var personalPay = parseFloat($("#personal_pay").val()) || 0;

            var totalAllowances = houseRentAllowance + conveyanceAllowance + lunchAllowance + medicalAllowance + otherAllowance + leaveTravelAllowance + personalPay;

            var professionalTax = parseFloat($("#professional_tax").val()) || 0;
            var esic = parseFloat($("#esic").val()) || 0;

            var totalDeductions = professionalTax + esic;

            var netSalary = salary + totalAllowances - totalDeductions;

            $("#net_salary_payables").val(netSalary.toFixed(2));
        }

        // Attach event listeners to all relevant input fields
        $("input").on("input", function () {
            calculateNetSalary();
        });

        // Recalculate salary after AJAX updates
        $('#employee_id').on('change', function () {
            var employee_id = $(this).val();
            if (employee_id !== 'disabled') {
                $.ajax({
                    url: '/employee/details/' + employee_id,
                    method: 'GET',
                    success: function (response) {
                        if (response.success) {
                            $("#salary_for_the_month").val(response.data.payroll.gross_salary);
                            $("#house_rent_allowance").val(response.data.house_rent_allowance);
                            $("#conveyance_allowance").val(response.data.conveyance_allowance);
                            $("#lunch_allowance").val(response.data.lunch_allowance);
                            $("#medical_allowance").val(response.data.medical_allowance);
                            $("#other_allowance").val(response.data.other_allowance);
                            $("#leave_travel_allowance").val(response.data.leave_travel_allowance);
                            $("#personal_pay").val(response.data.personal_pay);
                            $("#professional_tax").val(response.data.professional_tax);
                            $("#esic").val(response.data.esic);

                            // Call the function explicitly after values are set
                            calculateNetSalary();
                        }
                    }
                });
            }
        });

        // Initial calculation when the page loads
        calculateNetSalary();
    });
</script> --}}



@endsection
