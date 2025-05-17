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
                        <h6 class="card-title text-center mb-4">Edit Salary Details Of  Manager</h6>

                        <!-- Form Start -->
                        <form method="POST" action="{{ route('update.hrmsalaries', $sal->id) }}" class="forms-sample" id="employeeForm">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{$sal->id}}">

                            <!-- Step 1: Employee ID and Name -->
                            <div class="form-step" id="step-1">
                                <h3 style="color: red">Employee Information</h3>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label for="employee_id" class="form-label">Employee ID</label>
                                        <input type="text" class="form-control" id="employee_id" name="employee_id"
                                               value="{{$sal->employee_id}}" required>
                                        @error('employee_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               value="{{ $sal->name }}" required>
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="department" class="form-label">Department</label>
                                        <input type="text" class="form-control" id="department" name="department"
                                               value="{{ $sal->department }}">
                                        @error('department')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="doj" class="form-label">DOJ</label>
                                        <input type="date" class="form-control" id="doj" name="doj"
                                               value="{{ $sal->doj }}">
                                        @error('doj')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="gender" class="form-label">Gender</label>
                                        <input type="text" class="form-control" id="gender" name="gender"
                                               value="{{ $sal->gender }}" required>
                                        @error('gender')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="grade" class="form-label">Grade</label>
                                        <input type="text" class="form-control" id="grade" name="grade"
                                               value="{{ $sal->grade }}" required>
                                        @error('grade')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- bank details --}}
                                    <h3 style="color: red">Bank Details</h3>
                                    <div class="col-md-6">
                                        <label for="account_number" class="form-label">Account Number</label>
                                        <input type="text" class="form-control" id="account_number" name="account_number"
                                               value="{{ $sal->account_number }}" required>
                                        @error('account_number')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-6">
                                        <label for="ifsc_code" class="form-label">Ifsc Code</label>
                                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code"
                                               value="{{ $sal->ifsc_code }}" required>
                                        @error('ifsc_code')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bank_name" class="form-label">Bank Name</label>
                                        <input type="text" class="form-control" id="bank_name" name="bank_name"
                                               value="{{ $sal->bank_name }}" required>
                                        @error('bank_name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="branch_name" class="form-label">Branch Name</label>
                                        <input type="text" class="form-control" id="branch_name" name="branch_name"
                                               value="{{ $sal->branch_name }}" required>
                                        @error('branch_name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    {{-- salary details --}}
                                    <h3 style="color: red">Salary Details</h3>
                                    <div class="col-md-4">
                                        <label for="basic_salary" class="form-label">Basic Salary</label>
                                        <input type="text" class="form-control" id="basic_salary" name="basic_salary"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('basic_salary')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="salary_for_the_month" class="form-label">Salary For The Month</label>
                                        <input type="text" class="form-control" id="salary_for_the_month" name="salary_for_the_month"
                                               value="{{ $sal->salary_for_the_month }}" required>
                                        @error('salary_for_the_month')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-4">
                                        <label for="house_rent_allowance" class="form-label">House Rent Allowance</label>
                                        <input type="text" class="form-control" id="house_rent_allowance" name="house_rent_allowance"
                                               value="{{ $sal->house_rent_allowance }}" required>
                                        @error('house_rent_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="conveyance_allowance" class="form-label">Conveyance Allowance</label>
                                        <input type="text" class="form-control" id="conveyance_allowance" name="conveyance_allowance"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('conveyance_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="lunch_allowance" class="form-label">Lunch Allowance</label>
                                        <input type="text" class="form-control" id="lunch_allowance" name="lunch_allowance"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('lunch_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="medical_allowance" class="form-label">Medical Allowance</label>
                                        <input type="text" class="form-control" id="medical_allowance" name="medical_allowance"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('medical_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="other_allowance" class="form-label">Other Allowance</label>
                                        <input type="text" class="form-control" id="other_allowance" name="other_allowance"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('other_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="leave_travel_allowance" class="form-label">Leave Travel Allowance</label>
                                        <input type="text" class="form-control" id="leave_travel_allowance" name="leave_travel_allowance"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('leave_travel_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="personal_pay" class="form-label">Personal  Pay</label>
                                        <input type="text" class="form-control" id="personal_pay" name="personal_pay"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('personal_pay')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <h3 style="color: red">Total Ammount</h3>
                                    <div class="col-md-4">
                                        <label for="total_ammount" class="form-label">Total Ammount</label>
                                        <input type="text" class="form-control" id="total_ammount" name="total_ammount"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('total_ammount')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div> --}}

                                    <h3 style="color: red">Deductions</h3>
                                    <div class="col-md-4">
                                        <label for="professional_tax" class="form-label">Professional Tax</label>
                                        <input type="text" class="form-control" id="professional_tax" name="professional_tax"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('professional_tax')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="esic" class="form-label">ESIC</label>
                                        <input type="text" class="form-control" id="esic" name="esic"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('esic')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Net Salary</h3>

                                    <div class="col-md-4">
                                        <label for="net_salary_payables" class="form-label">Net Salary Payable</label>
                                        <input type="text" class="form-control" id="net_salary_payables" name="net_salary_payables"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('net_salary_payables')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="lop_days" class="form-label">LOP Days</label>
                                        <input type="text" class="form-control" id="lop_days" name="lop_days"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('lop_days')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="standard_days" class="form-label">Standard Days</label>
                                        <input type="text" class="form-control" id="standard_days" name="standard_days"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('standard_days')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary px-4 py-2" id="next-1">Next</button>
                                </div>
                            </div>

                            <!-- Step 2: Department, Designation, Employment Type, Work Location -->
                            {{-- payment information --}}

                            <div class="form-step" id="step-2" style="display: none;">
                                <h3 style="color: red">Payment Information</h3>
                                <div class="row mb-4">
                                    {{-- <div class="col-md-4">
                                        <label for="salary_for_the_month" class="form-label">Salary For The Month</label>
                                        <input type="text" class="form-control" id="salary_for_the_month" name="salary_for_the_month"
                                               value="{{ $sal->salary_for_the_month }}">
                                        @error('salary_for_the_month')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div> --}}

                                    <div class="col-md-4">
                                    <label for="no_of_working_day" class="form-label">No. Of Working Day</label>
                                    <input type="text" class="form-control" id="no_of_working_day" name="no_of_working_day"
                                               value="{{ $sal->no_of_working_day }}">
                                    @error('no_of_working_day')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label for="total_leave_taken" class="form-label">Total Leave Taken</label>
                                        <input type="text" class="form-control" id="total_leave_taken" name="total_leave_taken"
                                               value="{{ $sal->total_leave_taken }}">
                                        @error('total_leave_taken')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <label for="payment_date" class="form-label">Payment Date</label>
                                        <input type="text" class="form-control" id="payment_date" name="payment_date"
                                               value="{{ $sal->payment_date }}">
                                        @error('payment_date')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="amount" class="form-label">Amount</label>
                                        <input type="text" class="form-control" id="amount" name="amount"
                                               value="{{ $sal->amount }}">
                                        @error('amount')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="payment_method" class="form-label">Payment Method</label>
                                        <select class="form-control" id="payment_method" name="payment_method" required>
                                            <option value="bank-transfer" {{  $sal->payment_method == 'bank transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                            <option value="digital-wallet" {{ $sal->payment_method == 'digital-wallet' ? 'selected' : '' }}>Digital Wallet</option>
                                        </select>
                                        @error('payment_method')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div> --}}

                                    {{-- comments/notes --}}
                                    <h3 style="color: red">Comments/Notes</h3>
                                    <div class="col-md-6">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <input type="text" class="form-control" id="remarks" name="remarks"
                                               value="{{ $sal->remarks }}">
                                        @error('remarks')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary px-4 py-2" id="back-2">Back</button>
                                    <button type="submit" class="btn btn-success px-4 py-2">Save Changes</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Show Step 2 when Next is clicked
        $('#next-1').click(function() {
            $('#step-1').hide(); // Hide Step 1
            $('#step-2').show(); // Show Step 2
        });

        // Go Back to Step 1 when Back is clicked
        $('#back-2').click(function() {
            $('#step-2').hide(); // Hide Step 2
            $('#step-1').show(); // Show Step 1
        });
    });
</script>

@endsection
