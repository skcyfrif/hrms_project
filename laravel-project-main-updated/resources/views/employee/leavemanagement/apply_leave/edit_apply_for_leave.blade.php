@extends('employee.employee_dashboard')
@section('employee')
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
                            <h6 class="card-title text-center mb-4">Edit Leave Details</h6>

                            <form method="post" action="{{ route('update.leave', $test->id) }}" class="forms-sample">
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

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            let leaveFrom = document.getElementById('leave_from');
                                            let leaveTo = document.getElementById('leave_to');
                                            let totalDays = document.getElementById('total_days');

                                            // Get today's date in YYYY-MM-DD format
                                            let today = new Date().toISOString().split('T')[0];

                                            // Ensure "Leave From" and "Leave To" start from today
                                            leaveFrom.setAttribute('min', today);
                                            leaveTo.setAttribute('min', today);

                                            function calculateDays() {
                                                let fromDate = new Date(leaveFrom.value);
                                                let toDate = new Date(leaveTo.value);

                                                if (leaveFrom.value) {
                                                    leaveTo.setAttribute('min', leaveFrom.value); // Ensure "Leave To" is at least "Leave From"
                                                }

                                                if (fromDate && toDate && toDate >= fromDate) {
                                                    let timeDiff = toDate.getTime() - fromDate.getTime();
                                                    let dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1; // Include start day
                                                    totalDays.value = dayDiff;
                                                } else {
                                                    totalDays.value = ''; // Reset if invalid selection
                                                }
                                            }

                                            // When "Leave From" changes, update "Leave To" min value
                                            leaveFrom.addEventListener('change', function() {
                                                leaveTo.value = ''; // Reset "Leave To" when "Leave From" changes
                                                leaveTo.setAttribute('min', leaveFrom.value);
                                                calculateDays();
                                            });

                                            // When "Leave To" changes, recalculate days
                                            leaveTo.addEventListener('change', calculateDays);
                                        });
                                    </script>



                                    <div class="col-md-6">
                                        <label for="reason" class="form-label">Reason</label>
                                        <select class="form-control" id="reason" name="reason" required>
                                            <option value="" disabled>Select Reason</option>

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
                                            value="{{ old('remarks', $test->remarks) }}" required>

                                        @error('remarks')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="Upload" class="form-label">Upload</label>
                                        <input type="file" class="form-control" id="Upload" name="upload"
                                            value="{{ $test->Upload }}">
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
@endsection
