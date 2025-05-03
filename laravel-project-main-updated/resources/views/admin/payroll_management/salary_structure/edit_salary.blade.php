@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="row profile-body">
        <!-- Middle Wrapper Start -->
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <h6 class="card-title text-center mb-4">Edit Salary Details Of  Employee</h6>

                        <!-- Form Start -->
                        <form method="POST" action="{{ route('update.salary', $sal->id) }}" class="forms-sample" id="employeeForm">
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
                                        <label for="designation" class="form-label">Designation</label>
                                        <input type="text" class="form-control" id="designation" name="designation"
                                               value="{{ $sal->designation }}">
                                        @error('designation')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                               value="{{ $sal->email }}" required>
                                        @error('email')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                               value="{{ $sal->phone_number }}" required>
                                        @error('phone_number')
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
                                        <label for="allowances" class="form-label">Allowances</label>
                                        <select class="form-control" id="allowances" name="allowances" required>
                                            <option value="housing" {{  $sal->allowances == 'housing' ? 'selected' : '' }}>Housing</option>
                                            <option value="transportation" {{ $sal->allowances == 'transportation' ? 'selected' : '' }}>Transportation</option>
                                            <option value="medical" {{ $sal->allowances == 'medical' ? 'selected' : '' }}>Medical</option>
                                            {{-- <option value="other" {{ $sal->allowances == 'other' ? 'selected' : '' }}>Other</option> --}}
                                        </select>
                                        @error('allowances')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="deductions" class="form-label">Deductions</label>
                                        <select class="form-control" id="deductions" name="deductions" required>
                                            <option value="taxes" {{  $sal->deductions == 'taxes' ? 'selected' : '' }}>Taxes</option>
                                            <option value="insurance" {{ $sal->deductions == 'insurance' ? 'selected' : '' }}>Insurance</option>
                                            <option value="retirement-contributions" {{ $sal->deductions == 'retirement contributions' ? 'selected' : '' }}>Retirement Contributions</option>
                                            {{-- <option value="others" {{ $sal->deductions == 'others' ? 'selected' : '' }}>Others</option> --}}
                                        </select>
                                        @error('deductions')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="bonuses" class="form-label">Bonuses</label>
                                        <input type="text" class="form-control" id="bonuses" name="bonuses"
                                               value="{{ $sal->bonuses }}" required>
                                        @error('bonuses')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="overtime_pay" class="form-label">Overtime Pay</label>
                                        <input type="text" class="form-control" id="overtime_pay" name="overtime_pay"
                                               value="{{ $sal->basic_salary }}" required>
                                        @error('overtime_pay')
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
                                    <div class="col-md-4">
                                        <label for="salary_for_the_month" class="form-label">Salary For The Month</label>
                                        <input type="text" class="form-control" id="salary_for_the_month" name="salary_for_the_month"
                                               value="{{ $sal->salary_for_the_month }}">
                                        @error('salary_for_the_month')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
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
                                    <div class="col-md-4">
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
                                            {{-- <option value="other" {{ $sal->payment_method == 'other' ? 'selected' : '' }}>Other</option> --}}
                                        </select>
                                        @error('payment_method')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

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
