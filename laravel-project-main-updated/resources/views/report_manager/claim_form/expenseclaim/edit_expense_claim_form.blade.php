@extends('report_manager.report_manager_dashboard')
@section('report_manager')

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
                            <h6 class="card-title text-center mb-4">Edit Expense Claim</h6>

                            <form method="post" action="{{ route('update.rmclaim', $claim->id) }}" class="forms-sample"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="id" value="{{ $claim->id }}">

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="employee_id" class="form-label">Employee ID</label>
                                        <input type="text" class="form-control" id="employee_id" name="employee_id"
                                            value="{{ $claim->employee_id }}" readonly>
                                        @error('employee_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $claim->name }}" readonly>
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="department" class="form-label">Department</label>
                                        <input type="text" class="form-control" id="department" name="department"
                                            value="{{ $claim->department }}" readonly>
                                        @error('department')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="claim_date" class="form-label">Claim Date</label>
                                        <input type="date" class="form-control" id="claim_date" name="claim_date"
                                            value="{{ $claim->claim_date }}" readonly>
                                        @error('claim_date')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="expense_date" class="form-label">Expense Date</label>
                                        <input type="date" class="form-control" id="expense_date" name="expense_date"
                                            value="{{ $claim->expense_date }}">
                                        @error('expense_date')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="expense_category" class="form-label">Expense Category</label>
                                        <input type="text" class="form-control" id="expense_category"
                                            name="expense_category" value="{{ $claim->expense_category }}">
                                        @error('expense_category')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="expense_description" class="form-label">Expense Description</label>
                                        <input type="text" class="form-control" id="expense_description"
                                            name="expense_description" value="{{ $claim->expense_description }}">
                                        @error('expense_description')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="amount" class="form-label">Approved Amount</label>
                                        <input type="text" class="form-control" id="amount" name="amount"
                                            value="{{ $claim->amount }}">
                                        @error('amount')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="receipt_attached" class="form-label">Receipt Attached</label>
                                        <input type="file" class="form-control" id="receipt_attached"
                                            name="receipt_attached">
                                        @if ($claim->receipt_attached)
                                            <p class="mt-2">Current: <a
                                                    href="{{ asset('upload/claims/' . $claim->receipt_attached) }}"
                                                    target="_blank">View File</a></p>
                                        @endif
                                        @error('receipt_attached')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                    <label for="manager_approval" class="form-label">Approved By</label>
                                    <select class="form-control @error('manager_approval') is-invalid @enderror" id="manager_approval" name="manager_approval">
                                        <option value="">Select</option>
                                        <option value="Manager" {{ ($claim->manager_approval ?? old('manager_approval')) == 'Manager' ? 'selected' : '' }}>Manager</option>
                                        <option value="Others" {{ ($claim->manager_approval ?? old('manager_approval')) == 'Others' ? 'selected' : '' }}>Others</option>
                                    </select>
                                    @error('manager_approval')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="approval_date" class="form-label">Approval Date</label>
                                        <input type="date" class="form-control" id="approval_date"
                                            name="approval_date" value="{{ $claim->approval_date }}">
                                        @error('approval_date')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="reimbursed" class="form-label">Claim Amount</label>
                                        <input type="text" class="form-control" id="reimbursed" name="reimbursed"
                                            value="{{ $claim->reimbursed }}">
                                        @error('reimbursed')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary px-4 py-2">Update Claim</button>
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
            $('#expense_date').on('change', function() {
                const claimDate = new Date($('#claim_date').val());
                const expenseDate = new Date($(this).val());

                if (expenseDate > claimDate) {
                    alert('Expense date cannot be after claim date.');
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });

            $('#approval_date').on('change', function() {
                const claimDate = new Date($('#claim_date').val());
                const expenseDate = new Date($('#expense_date').val());
                const approvalDate = new Date($(this).val());

                if (approvalDate > claimDate || (expenseDate && approvalDate > expenseDate)) {
                    alert('Approval date must not be after claim or expense date.');
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
