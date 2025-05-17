@extends('hr_head.hr_head_dashboard')
@section('hr_head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="row profile-body">
            <!-- Middle Wrapper Start -->
            <div class="col-md-12 col-xl-12 middle-wrapper">
                <button onclick="window.history.back();" class="btn btn-secondary">Back</button>
                <div class="row">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-5">
                            <h6 class="card-title text-center mb-4">Edit Leave Details</h6>

                            <form method="post" action="{{ route('update.hrheadleave', $test->id) }}" class="forms-sample"
                                enctype="multipart/form-data" id="leaveForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $test->id }}">

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="employee_id" class="form-label">Employee ID</label>
                                        <input type="text" class="form-control" id="employee_id" name="employee_id"
                                            value="{{ $test->employee_id }}" readonly required>
                                        @error('employee_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $test->name }}" readonly required>
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="designation" class="form-label">Designation</label>
                                        <input type="text" class="form-control" id="designation" name="designation"
                                            value="{{ $test->designation }}" readonly required>
                                        @error('designation')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="department" class="form-label">Department</label>
                                        <input type="text" class="form-control" id="department" name="department"
                                            value="{{ $test->department }}" readonly required>
                                        @error('department')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="leave_from" class="form-label">Leave From</label>
                                        <input type="date" class="form-control" id="leave_from" name="leave_from"
                                            value="{{ $test->leave_from }}" required>
                                        @error('leave_from')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="leave_to" class="form-label">Leave To</label>
                                        <input type="date" class="form-control" id="leave_to" name="leave_to"
                                            value="{{ $test->leave_to }}" required>
                                        <div id="date-error" class="text-danger mt-1" style="display: none;">Leave To date
                                            cannot be earlier than Leave From date.</div>
                                        @error('leave_to')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="total_days" class="form-label">Total Days</label>
                                        <input type="text" class="form-control" id="total_days" name="total_days"
                                            value="{{ $test->total_days }}" readonly>
                                        @error('total_days')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="reason" class="form-label">Leave Type</label>
                                        <select class="form-control" id="reason" name="reason" required>
                                            <option value="" disabled>Select Leave Type</option>
                                            <option value="PL" {{ $test->reason == 'PL' ? 'selected' : '' }}>PL
                                            </option>
                                            <option value="SL" {{ $test->reason == 'SL' ? 'selected' : '' }}>SL
                                            </option>
                                            <option value="LOP" {{ $test->reason == 'LOP' ? 'selected' : '' }}>LOP
                                            </option>
                                        </select>
                                        @error('reason')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <input type="text" class="form-control" id="remarks" name="remarks"
                                            value="{{ $test->remarks }}">
                                        @error('remarks')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="Upload" class="form-label">Upload</label>
                                        <input type="file" class="form-control" id="Upload" name="upload">
                                        @error('Upload')
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let leaveFrom = document.getElementById('leave_from');
            let leaveTo = document.getElementById('leave_to');
            let totalDays = document.getElementById('total_days');
            let dateError = document.getElementById('date-error');
            let form = document.getElementById('leaveForm');

            let today = new Date().toISOString().split('T')[0];
            leaveFrom.setAttribute('min', today);
            leaveTo.setAttribute('min', today);

            function calculateDays() {
                let fromDate = new Date(leaveFrom.value);
                let toDate = new Date(leaveTo.value);

                if (leaveFrom.value) {
                    leaveTo.setAttribute('min', leaveFrom.value);
                }

                if (leaveFrom.value && leaveTo.value) {
                    if (toDate < fromDate) {
                        dateError.style.display = 'block';
                        totalDays.value = '';
                    } else {
                        dateError.style.display = 'none';
                        let diff = toDate.getTime() - fromDate.getTime();
                        let days = Math.ceil(diff / (1000 * 60 * 60 * 24)) + 1;
                        totalDays.value = days;
                    }
                } else {
                    totalDays.value = '';
                    dateError.style.display = 'none';
                }
            }

            leaveFrom.addEventListener('change', function() {
                leaveTo.value = '';
                totalDays.value = '';
                dateError.style.display = 'none';
                leaveTo.setAttribute('min', leaveFrom.value);
            });

            leaveTo.addEventListener('change', calculateDays);

            form.addEventListener('submit', function(e) {
                let fromDate = new Date(leaveFrom.value);
                let toDate = new Date(leaveTo.value);
                if (toDate < fromDate) {
                    e.preventDefault();
                    dateError.style.display = 'block';
                }
            });

            // Initialize calculation on page load
            if (leaveFrom.value && leaveTo.value) {
                calculateDays();
            }
        });
    </script>
@endsection
