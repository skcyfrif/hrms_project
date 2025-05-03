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
                        <h6 class="card-title text-center mb-4">Edit payslip Details</h6>

                        <form method="post" action="{{ route('update.payslips', $pay->id) }}" class="forms-sample">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{$pay->id}}">
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="employee_id" class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" id="employee_id" name="employee_id"
                                           value="{{$pay->employee_id}}" required>
                                    @error('employee_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{$pay->name}}" required>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="month" class="form-label">Month</label>
                                    <select class="form-control" id="month" name="month" required>
                                        @php
                                            $months = ['01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
                                        @endphp
                                        @foreach($months as $month => $monthName)
                                            <option value="{{ $month }}" {{ old('month', $pay->month) == $month ? 'selected' : '' }}>{{ $monthName }}</option>
                                        @endforeach
                                    </select>
                                    @error('month') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="year" class="form-label">Year</label>
                                    <select class="form-control" id="year" name="year" required>
                                        @php
                                            // Get the current year
                                            $currentYear = date('Y');
                                        @endphp
                                        <option value="{{ $currentYear }}" {{ old('year', $pay->year) == $currentYear ? 'selected' : '' }}>{{ $currentYear }}</option>
                                    </select>
                                    @error('year')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="grade" class="form-label">Grade</label>
                                    <input type="text" class="form-control" id="grade" name="grade"
                                           value="{{$pay->grade}}" required>
                                    @error('grade')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="lop_days" class="form-label">LOP Days</label>
                                    <input type="text" class="form-control" id="lop_days" name="lop_days"
                                           value="{{$pay->lop_days}}" required>
                                    @error('lop_days')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="refund_days" class="form-label">Refund Days</label>
                                    <input type="text" class="form-control" id="refund_days" name="refund_days"
                                           value="{{$pay->refund_days}}" required>
                                    @error('refund_days')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="standard_days" class="form-label">Standard Days</label>
                                    <input type="text" class="form-control" id="standard_days" name="standard_days"
                                           value="{{$pay->standard_days}}" required>
                                    @error('standard_days')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>



                                <div class="col-md-4">
                                    <label for="basic_salary" class="form-label">Basic Salary</label>
                                    <input type="text" class="form-control" id="basic_salary" name="basic_salary"
                                           value="{{$pay->basic_salary}}" required>
                                    @error('basic_salary')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="house_rent_allowance" class="form-label">House Rent Allowance</label>
                                    <input type="text" class="form-control" id="house_rent_allowance" name="house_rent_allowance"
                                           value="{{ $pay->house_rent_allowance }}" required>
                                    @error('house_rent_allowance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="conveyance_allowance" class="form-label">Conveyance Allowance</label>
                                    <input type="text" class="form-control" id="conveyance_allowance" name="conveyance_allowance"
                                           value="{{ $pay->conveyance_allowance }}" required>
                                    @error('conveyance_allowance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="lunch_allowance" class="form-label">Lunch Allowance</label>
                                    <input type="text" class="form-control" id="lunch_allowance" name="lunch_allowance"
                                           value="{{ $pay->lunch_allowance }}" required>
                                    @error('lunch_allowance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="personal_pay" class="form-label">Personal Pay</label>
                                    <input type="text" class="form-control" id="personal_pay" name="personal_pay"
                                           value="{{ $pay->personal_pay }}" required>
                                    @error('personal_pay')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="medical_allowance" class="form-label">Medical Allowance</label>
                                    <input type="text" class="form-control" id="medical_allowance" name="medical_allowance"
                                           value="{{ $pay->medical_allowance }}" required>
                                    @error('medical_allowance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="other_allowance" class="form-label">Other Allowance</label>
                                    <input type="text" class="form-control" id="other_allowance" name="other_allowance"
                                           value="{{ $pay->other_allowance }}" required>
                                    @error('other_allowance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="leave_travel_allowance" class="form-label">Leave Travel Allowance</label>
                                    <input type="text" class="form-control" id="leave_travel_allowance" name="leave_travel_allowance"
                                           value="{{ $pay->leave_travel_allowance }}" required>
                                    @error('leave_travel_allowance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Total Ammount</h3>
                                <div class="col-md-4">
                                    <label for="total_ammount" class="form-label">Total Ammount</label>
                                    <input type="text" class="form-control" id="total_ammount" name="total_ammount"
                                           value="{{ $pay->total_ammount }}" readonly>
                                    @error('total_ammount')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Deductions</h3>
                                <div class="col-md-4">
                                    <label for="professional_tax" class="form-label">Professional Tax</label>
                                    <input type="text" class="form-control" id="professional_tax" name="professional_tax"
                                           value="{{$pay->professional_tax}}" required>
                                    @error('professional_tax')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="esic" class="form-label">ESIC</label>
                                    <input type="text" class="form-control" id="esic" name="esic"
                                           value="{{$pay->esic}}" required>
                                    @error('esic')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="advance" class="form-label">Advance</label>
                                    <input type="text" class="form-control" id="advance" name="advance"
                                           value="{{$pay->advance}}" required>
                                    @error('advance')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Net Salary</h3>
                                <div class="col-md-6">
                                    <label for="net_salary_payable" class="form-label">Net Salary Payable</label>
                                    <input type="text" class="form-control" id="net_salary_payable" name="net_salary_payable"
                                           value="{{ $pay->net_salary_payable }}" readonly>
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

<script>
    $(document).ready(function () {
        // Function to update Total Amount and Net Salary
        function updatePayslipValues() {
            // Calculate Total Amount (sum of all earning fields)
            var totalAmount = 0;
            $('#basic_salary, #house_rent_allowance, #conveyance_allowance, #lunch_allowance, #personal_pay, #medical_allowance, #other_allowance, #leave_travel_allowance').each(function() {
                totalAmount += parseFloat($(this).val()) || 0;
            });
            $('#total_ammount').val(totalAmount.toFixed(2)); // Display the result with 2 decimal points

            // Calculate Net Salary (total amount minus all deductions)
            var totalDeductions = 0;
            $('#professional_tax, #esic, #advance').each(function() {
                totalDeductions += parseFloat($(this).val()) || 0;
            });
            var netSalary = totalAmount - totalDeductions;
            $('#net_salary_payable').val(netSalary.toFixed(2)); // Display the result with 2 decimal points
        }

        // Trigger updates whenever an input field changes (for both earnings and deductions)
        $('#basic_salary, #house_rent_allowance, #conveyance_allowance, #lunch_allowance, #personal_pay, #medical_allowance, #other_allowance, #leave_travel_allowance, #professional_tax, #esic, #advance').on('input', updatePayslipValues);
    });
</script>


{{-- <script>
    $(document).ready(function () {
        // Update Total Amount
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

        // Update Net Salary
        function updateNetSalary() {
            var totalAmount = parseFloat($('#total_ammount').val()) || 0;
            var professionalTax = parseFloat($('#professional_tax').val()) || 0;
            var esic = parseFloat($('#esic').val()) || 0;
            var advance = parseFloat($('#advance').val()) || 0;

            var netSalary = totalAmount - (professionalTax + esic + advance);
            $('#net_salary_payable').val(netSalary.toFixed(2)); // Display the result with 2 decimal points
        }

        // Trigger updates whenever an input field changes
        $('#basic, #house_rent_allowance, #conveyance_allowance, #lunch_allowance, #personal_pay, #medical_allowance, #other_allowance, #leave_travel_allowance').on('input', function () {
            updateTotalAmount();
            updateNetSalary();
        });

        $('#professional_tax, #esic, #advance').on('input', updateNetSalary);
    });
</script> --}}

@endsection

























