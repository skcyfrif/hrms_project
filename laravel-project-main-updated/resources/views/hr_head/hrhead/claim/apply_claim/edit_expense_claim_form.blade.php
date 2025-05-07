@extends('hr_head.hr_head_dashboard')
@section('hr_head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="row profile-body">
            <!-- Middle Wrapper Start -->
            <div class="col-md-12 col-xl-12 middle-wrapper">
                <button onclick="window.history.back();" class="btn btn-secondary">
                    Back
                </button>
                <div class="row">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-5">
                            <h6 class="card-title text-center mb-4">Edit claim Details</h6>

                            <form method="post" action="{{ route('update.hrheadclaim', $claim->id) }}" class="forms-sample">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $claim->id }}">
                                <div class="row mb-4">

                                    <div class="col-md-4">
                                        <label for="employee_id" class="form-label">Employee ID</label>
                                        <input type="text" class="form-control" id="employee_id" name="employee_id"
                                            value="{{ $claim->employee_id }}">
                                        @error('employee_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $claim->name }}">
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="department" class="form-label">Department</label>
                                        <input type="text" class="form-control" id="department" name="department"
                                            value="{{ $claim->department }}">
                                        @error('department')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label for="claim_date" class="form-label">Claim Date</label>
                                            <input type="date" class="form-control" id="claim_date" name="claim_date"
                                                value="{{ $claim->claim_date }}">
                                            @error('claim_date')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="expense_date" class="form-label">Expense Date</label>
                                            <input type="date" class="form-control" id="expense_date" name="expense_date"
                                                value="{{ $claim->expense_date }}">
                                            @error('expense_date')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="expense_category" class="form-label">Expense Category</label>
                                            <input type="text" class="form-control" id="expense_category"
                                                name="expense_category" value="{{ $claim->expense_category }}">
                                            @error('expense_category')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                </div>
                                <div class="row mb-4">

                                        <div class="col-md-4">
                                            <label for="expense_description" class="form-label">Expense Description</label>
                                            <input type="text" class="form-control" id="expense_description"
                                                name="expense_description" value="{{ $claim->expense_description }}">
                                            @error('expense_description')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="amount" class="form-label">Approved Amount</label>
                                            <input type="text" class="form-control" id="amount" name="amount"
                                                value="{{ $claim->amount }}">
                                            @error('amount')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="receipt_attached" class="form-label">Receipt Attached</label>
                                            <input type="file" class="form-control" id="receipt_attached"
                                                name="receipt_attached" value="{{ $claim->receipt_attached }}">
                                            @error('receipt_attached')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                </div>
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <label for="admin_approval"
                                                class="form-label @error('admin_approval') is-invalid @enderror">Approved
                                                By</label>
                                            <select class="form-control @error('admin_approval') is-invalid @enderror"
                                                id="admin_approval" name="admin_approval">
                                                <option value="">Select</option>
                                                <option value="admin"
                                                    {{ ($claim->admin_approval ?? old('admin_approval')) == 'admin' ? 'selected' : '' }}>
                                                    Admin</option>
                                                <option value="Others"
                                                    {{ ($claim->admin_approval ?? old('admin_approval')) == 'Others' ? 'selected' : '' }}>
                                                    Others</option>
                                            </select>
                                            @error('admin_approval')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-md-4">
                                            <label for="approval_date" class="form-label">Approval Date</label>
                                            <input type="text" class="form-control" id="approval_date"
                                                name="approval_date" value="{{ $claim->approval_date }}">
                                            @error('approval_date')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="reimbursed" class="form-label">Claim Ammount</label>
                                            <input type="text" class="form-control" id="reimbursed" name="reimbursed"
                                                value="{{ $claim->reimbursed }}">
                                            @error('reimbursed')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>


                                    </div>



                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary px-4 py-2">Submit</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Middle Wrapper End -->
        </div>
    </div>
@endsection
