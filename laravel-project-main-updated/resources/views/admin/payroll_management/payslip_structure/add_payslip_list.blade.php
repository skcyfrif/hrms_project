@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="row profile-body">
        <!-- Middle Wrapper Start -->
        <div class="col-md-12 middle-wrapper">
            <div class="row">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <h6 class="card-title text-center mb-4">Add  payslip</h6>

                        <form method="post" action="{{ route('store.payslip') }}" class="forms-sample" id="employeeForm">
                            {{-- <form method="post" action="#" class="forms-sample" id="employeeForm"> --}}
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="employee_id" class="form-label @error('employee_id') is-invalid @enderror">Employee ID</label>
                                    <select class="form-control" id="employee_id" name="employee_id" value="{{ old('employee_id') }}">
                                        <option value="disabled">-- Select --</option>

                                        @foreach($abcd as $abc)
                                            <option value="{{ $abc->id }}">{{ $abc->employee_id }}</option>
                                        @endforeach
                                        @foreach($rama as $ram)
                                            <option value="{{ $ram->id }}">{{ $ram->employee_id }}</option>
                                        @endforeach
                                        @foreach($sitaa as $sita)
                                            <option value="{{ $sita->id }}">{{ $sita->employee_id }}</option>
                                        @endforeach
                                    </select>

                                    @error('employee_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="name" class="form-label @error('name') is-invalid @enderror">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="month" class="form-label @error('month') is-invalid @enderror">Month</label>
                                    <select class="form-control" id="month" name="month">
                                        <option value="">-- Select Month --</option>
                                        @php
                                            $months = [
                                                'January', 'February', 'March', 'April', 'May', 'June',
                                                'July', 'August', 'September', 'October', 'November', 'December'
                                            ];
                                        @endphp
                                        @foreach($months as $month)
                                            <option value="{{ $month }}" {{ old('month') == $month ? 'selected' : '' }}>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                    @error('month')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="year" class="form-label @error('year') is-invalid @enderror">Year</label>
                                    <select class="form-control" id="year" name="year">
                                        <option value="">-- Select Year --</option>
                                        @php
                                            // Get the current year
                                            $currentYear = date('Y');
                                        @endphp
                                        <option value="{{ $currentYear }}" {{ old('year') == $currentYear ? 'selected' : '' }}>{{ $currentYear }}</option>
                                    </select>
                                    @error('year')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="grade" class="form-label @error('grade') is-invalid @enderror">Grade</label>
                                    <input type="text" class="form-control" id="grade" name="grade" value="{{ old('grade') }}">
                                    @error('grade')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="lop_days" class="form-label @error('lop_days') is-invalid @enderror">LOP Days</label>
                                    <input type="text" class="form-control" id="lop_days" name="lop_days" value="{{ old('lop_days') }}">
                                    @error('lop_days')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="refund_days" class="form-label @error('refund_days') is-invalid @enderror">Refund Days</label>
                                    <input type="text" class="form-control" id="refund_days" name="refund_days" value="{{ old('refund_days') }}">
                                    @error('refund_days')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="standard_days" class="form-label @error('standard_days') is-invalid @enderror">Standard Days</label>
                                    <input type="text" class="form-control" id="standard_days" name="standard_days" value="{{ old('standard_days') }}">
                                    @error('standard_days')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="basic_salary" class="form-label @error('basic_salary') is-invalid @enderror">Basic Salary</label>
                                    <input type="text" class="form-control" id="basic_salary" name="basic_salary" value="{{ old('basic_salary') }}">
                                    @error('basic_salary')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="house_rent_allowance" class="form-label @error('house_rent_allowance') is-invalid @enderror">House Rent Allowance</label>
                                    <input type="text" class="form-control" id="house_rent_allowance" name="house_rent_allowance" value="{{ old('house_rent_allowance') }}">
                                    @error('house_rent_allowance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-md-4">
                                    <label for="conveyance_allowance" class="form-label @error('conveyance_allowance') is-invalid @enderror">Conveyance Allowance</label>
                                    <input type="text" class="form-control" id="conveyance_allowance" name="conveyance_allowance" value="{{ old('conveyance_allowance') }}">
                                    @error('conveyance_allowance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="lunch_allowance" class="form-label @error('lunch_allowance') is-invalid @enderror">Lunch Allowance</label>
                                    <input type="text" class="form-control" id="lunch_allowance" name="lunch_allowance" value="{{ old('lunch_allowance') }}">
                                    @error('lunch_allowance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-md-4">
                                    <label for="personal_pay" class="form-label @error('personal_pay') is-invalid @enderror">Personal Pay</label>
                                    <input type="text" class="form-control" id="personal_pay" name="personal_pay" value="{{ old('personal_pay') }}">
                                    @error('personal_pay')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="medical_allowance" class="form-label @error('medical_allowance') is-invalid @enderror">Medical Allowance</label>
                                    <input type="text" class="form-control" id="medical_allowance" name="medical_allowance" value="{{ old('medical_allowance') }}">
                                    @error('medical_allowance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="other_allowance" class="form-label @error('other_allowance') is-invalid @enderror">Other Allowance</label>
                                    <input type="text" class="form-control" id="other_allowance" name="other_allowance" value="{{ old('other_allowance') }}">
                                    @error('other_allowance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="leave_travel_allowance" class="form-label @error('leave_travel_allowance') is-invalid @enderror">Leave Travel Allowance</label>
                                    <input type="text" class="form-control" id="leave_travel_allowance" name="leave_travel_allowance" value="{{ old('leave_travel_allowance') }}">
                                    @error('leave_travel_allowance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Total Ammount</h3>
                                <div class="col-md-4">
                                    <label for="total_ammount" class="form-label @error('total_ammount') is-invalid @enderror">Total Ammount</label>
                                    <input type="text" class="form-control" id="total_ammount" name="total_ammount" readonly>
                                    @error('total_ammount')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
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
                                <div class="col-md-4">
                                    <label for="advance" class="form-label @error('advance') is-invalid @enderror">Advance</label>
                                    <input type="text" class="form-control" id="advance" name="advance" value="{{ old('advance') }}">
                                    @error('advance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Net Salary</h3>
                                <div class="col-md-6">
                                    <label for="net_salary_payable" class="form-label @error('net_salary_payable') is-invalid @enderror">Net Salary Payable</label>
                                    <input type="text" class="form-control" id="net_salary_payable" name="net_salary_payable" readonly>
                                    @error('net_salary_payable')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4 py-2">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Middle Wrapper End -->
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
                            // $('#employee_id').val(response.data.employee_id);
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
                            $('#house_rent_allowance').val(response.data.house_rent_allowance);
                            $('#conveyance_allowance').val(response.data.conveyance_allowance);
                            $('#lunch_allowance').val(response.data.lunch_allowance);
                            $('#personal_pay').val(response.data.personal_pay);
                            $('#medical_allowance').val(response.data.medical_allowance);
                            $('#other_allowance').val(response.data.other_allowance);
                            $('#leave_travel_allowance').val(response.data.leave_travel_allowance);
                            $('#total_ammount').val(response.data.total_ammount);
                            $('#professional_tax').val(response.data.professional_tax);
                            $('#esic').val(response.data.esic);
                            $('#advance').val(response.data.advance);
                            $('#net_salary_payable').val(response.data.net_salary_payable);
                        } else {
                            // Clear the fields if no employee data is found
                            // $('#employee_id').val('');
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
                            $('#house_rent_allowance').val('');
                            $('#conveyance_allowance').val('');
                            $('#lunch_allowance').val('');
                            $('#medical_allowance').val('');
                            $('#other_allowance').val('');
                            $('#leave_travel_allowance').val('');
                            $('#total_ammount').val('');
                            $('#professional_tax').val('');
                            $('#esic').val('');
                            $('#advance').val('');
                            $('#net_salary_payable').val('');

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
    $(document).ready(function () {
        // Function to update Total Amount and Net Salary
        function updatePayslipValues() {
            // Calculate Total Amount
            var totalAmount = 0;
            $('#basic_salary, #house_rent_allowance, #conveyance_allowance, #lunch_allowance, #personal_pay, #medical_allowance, #other_allowance, #leave_travel_allowance').each(function() {
                totalAmount += parseFloat($(this).val()) || 0;
            });
            $('#total_ammount').val(totalAmount.toFixed(2));

            // Calculate Net Salary
            var deductions = 0;
            $('#professional_tax, #esic, #advance').each(function() {
                deductions += parseFloat($(this).val()) || 0;
            });
            var netSalary = totalAmount - deductions;
            $('#net_salary_payable').val(netSalary.toFixed(2));
        }

        // Trigger updates whenever an input field changes
        $('#basic_salary, #house_rent_allowance, #conveyance_allowance, #lunch_allowance, #personal_pay, #medical_allowance, #other_allowance, #leave_travel_allowance, #professional_tax, #esic, #advance').on('input', updatePayslipValues);
    });
</script>

{{-- <script>
    $(document).ready(function () {
        function updateTotalAmount() {
            var basic = parseFloat($('#basic').val()) || 0;
            var houseRentAllowance = parseFloat($('#house_rent_allowance').val()) || 0;
            var conveyanceAllowance = parseFloat($('#conveyance_allowance').val()) || 0;
            var lunchAllowance = parseFloat($('#lunch_allowance').val()) || 0;
            var personalPay = parseFloat($('#personal_pay').val()) || 0;
            var medicalAllowance = parseFloat($('#medical_allowance').val()) || 0;
            var otherAllowance = parseFloat($('#other_allowance').val()) || 0;
            var leaveTravelAllowance = parseFloat($('#leave_travel_allowance').val()) || 0;

            var totalAmount = basic + houseRentAllowance + conveyanceAllowance + lunchAllowance + personalPay + medicalAllowance + otherAllowance + leaveTravelAllowance;
            $('#total_ammount').val(totalAmount.toFixed(2)); // Display the result with 2 decimal points
        }

        function updateNetSalary() {
            var totalAmount = parseFloat($('#total_ammount').val()) || 0;
            var professionalTax = parseFloat($('#professional_tax').val()) || 0;
            var esic = parseFloat($('#esic').val()) || 0;
            var advance = parseFloat($('#advance').val()) || 0;

            var netSalary = totalAmount - (professionalTax + esic + advance);
            $('#net_salary_payable').val(netSalary.toFixed(2)); // Display the result with 2 decimal points
        }

        // Trigger the update functions whenever any input field changes
        $('#basic, #house_rent_allowance, #conveyance_allowance, #lunch_allowance, #personal_pay, #medical_allowance, #other_allowance, #leave_travel_allowance').on('input', function () {
            updateTotalAmount();
            updateNetSalary();
        });

        $('#professional_tax, #esic, #advance').on('input', updateNetSalary);
    });
</script> --}}

@endsection
