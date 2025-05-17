@extends('hr_head.hr_head_dashboard')
@section('hr_head')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="row profile-body">

            <div class="col-md-12 col-xl-12 middle-wrapper">
                <button onclick="window.history.back();" class="btn btn-secondary">
                    Back
                </button>
                <div class="row">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-5">
                            <h6 class="card-title text-center mb-4">Add or Edit Expense Claim</h6>

                            <form method="post" action="{{ route('store.hrheadclaim') }}" class="forms-sample"
                                id="employeeForm">

                                @csrf

                                <div class="row mb-4">

                                    <div class="col-md-6">
                                        <label for="employee_id"
                                            class="form-label @error('employee_id') is-invalid @enderror">Employee
                                            ID</label>
                                        <input type="hidden" class="form-control" id="employee_id" name="employee_id"
                                            value="{{ old('employee_id', $employee->id) }}" readonly>
                                        <input type="text" class="form-control" id="employee_id"
                                            value="{{ old('employee_id', $employee->employee_id) }}" readonly>
                                        @error('employee_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>




                                    <div class="col-md-6">
                                        <label for="name"
                                            class="form-label @error('name') is-invalid @enderror">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $user->name) }}" readonly>
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">


                                    <div class="col-md-6">
                                        <label for="department"
                                            class="form-label @error('department') is-invalid @enderror">Department</label>
                                        <input type="text" class="form-control" id="department" name="department"
                                            value="{{ old('department', $employee->department) }}" readonly>
                                        @error('department')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="claim_date"
                                            class="form-label @error('claim_date') is-invalid @enderror">Claim Date</label>
                                        <input type="date" class="form-control" id="claim_date" name="claim_date"
                                            value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}"
                                            readonly>
                                        @error('claim_date')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="expense_date"
                                            class="form-label @error('expense_date') is-invalid @enderror">Expense
                                            Date</label>
                                        <input type="date" class="form-control" id="expense_date" name="expense_date"
                                            value="{{ old('expense_date') }}">
                                        <div id="expense-error" class="text-danger mt-1" style="display: none;"></div>
                                        @error('expense_date')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">

                                        <label for="expense_category"
                                            class="form-label @error('expense_category') is-invalid @enderror">Expense
                                            Category</label>
                                        <input type="text" class="form-control" id="expense_category"
                                            name="expense_category" value="{{ old('expense_category') }}">
                                        @error('expense_category')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">

                                    <div class="col-md-6">

                                        <label for="expense_description"
                                            class="form-label @error('expense_description') is-invalid @enderror">Expense
                                            Description</label>
                                        <input type="text" class="form-control" id="expense_description"
                                            name="expense_description" value="{{ old('expense_description') }}">
                                        @error('expense_description')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="amount"
                                            class="form-label @error('amount') is-invalid @enderror">Approved Amount</label>
                                        <input type="text" class="form-control" id="amount" name="amount"
                                            value="{{ old('amount') }}">
                                        @error('amount')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">

                                    <div class="col-md-6">
                                        <label for="receipt_attached"
                                            class="form-label @error('receipt_attached') is-invalid @enderror">Receipt
                                            Attached</label>
                                        <input type="file" class="form-control" id="receipt_attached"
                                            name="receipt_attached" value="{{ old('receipt_attached') }}">
                                        @error('receipt_attached')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                    <label for="admin_approval" class="form-label @error('admin_approval') is-invalid @enderror">Approved By</label>
                                    <select class="form-control @error('admin_approval') is-invalid @enderror" id="admin_approval" name="admin_approval">
                                        <option value="">Select</option>
                                        <option value="admin" {{ old('admin_approval') == 'Manager' ? 'selected' : '' }}>Admin</option>
                                        <option value="Others" {{ old('admin_approval') == 'Others' ? 'selected' : '' }}>Others</option>
                                    </select>
                                    @error('admin_approval')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                </div>
                                <div class="row mb-4">

                                    <div class="col-md-6">
                                        <label for="approval_date"
                                            class="form-label @error('approval_date') is-invalid @enderror">Approval
                                            Date</label>
                                        <input type="date" class="form-control" id="approval_date"
                                            name="approval_date" value="{{ old('approval_date') }}">
                                        <div id="approval-error" class="text-danger mt-1" style="display: none;"></div>
                                        @error('approval_date')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="reimbursed"
                                            class="form-label @error('reimbursed') is-invalid @enderror">Claim
                                            Ammount</label>
                                        <input type="text" class="form-control" id="reimbursed" name="reimbursed"
                                            value="{{ old('reimbursed') }}">
                                        @error('reimbursed')
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

        </div>
    </div>

    <script>
        $(document).ready(function() {

            // Expense Date Validation
            $('#expense_date').on('change', function() {
                const claimDate = new Date($('#claim_date').val());
                const expenseDate = new Date($(this).val());

                if (expenseDate > claimDate) {
                    $('#expense-error').text('Expense date cannot be after claim date.').show();
                    $('#expense_date').addClass('is-invalid');
                } else {
                    $('#expense-error').text('').hide();
                    $('#expense_date').removeClass('is-invalid');
                }
            });

            // Approval Date Validation
            $('#approval_date').on('change', function() {
                const claimDate = new Date($('#claim_date').val());
                const expenseDate = new Date($('#expense_date').val());
                const approvalDate = new Date($(this).val());

                let errorMsg = '';

                if (approvalDate > claimDate) {
                    errorMsg = 'Approval date cannot be after claim date.';
                } else if (expenseDate && approvalDate > expenseDate) {
                    errorMsg = 'Approval date cannot be after expense date.';
                }

                if (errorMsg !== '') {
                    $('#approval-error').text(errorMsg).show();
                    $('#approval_date').addClass('is-invalid');
                } else {
                    $('#approval-error').text('').hide();
                    $('#approval_date').removeClass('is-invalid');
                }
            });

            // Form Submit Check
            $('#employeeForm').on('submit', function(e) {
                const claimDate = new Date($('#claim_date').val());
                const expenseDate = new Date($('#expense_date').val());
                const approvalDate = new Date($('#approval_date').val());

                let preventSubmit = false;

                if (expenseDate > claimDate) {
                    $('#expense-error').text('Expense date cannot be after claim date.').show();
                    $('#expense_date').addClass('is-invalid');
                    preventSubmit = true;
                }

                if (approvalDate > claimDate) {
                    $('#approval-error').text('Approval date cannot be after claim date.').show();
                    $('#approval_date').addClass('is-invalid');
                    preventSubmit = true;
                } else if (expenseDate && approvalDate > expenseDate) {
                    $('#approval-error').text('Approval date cannot be after expense date.').show();
                    $('#approval_date').addClass('is-invalid');
                    preventSubmit = true;
                }

                if (preventSubmit) e.preventDefault();
            });
        });
    </script>
@endsection
