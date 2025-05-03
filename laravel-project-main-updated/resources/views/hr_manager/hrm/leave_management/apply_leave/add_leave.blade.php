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
                            <h6 class="card-title text-center mb-4">Add Leave</h6>

                            <form method="post" action="{{ route('store.hrmanagerleave') }}" class="forms-sample"
                                id="employeeForm" enctype="multipart/form-data">
                                {{-- <form method="post" action="#" class="forms-sample" id="employeeForm"> --}}
                                @csrf

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="employee_id"
                                            class="form-label @error('employee_id') is-invalid @enderror">Employee
                                            ID</label>
                                        {{-- <input type="text" class="form-control" id="employee_id" name="employee_id" value="{{ old('employee_id') }}"> --}}
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
                                        {{-- <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"> --}}
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $user->name) }}" readonly>
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="designation"
                                            class="form-label @error('designation') is-invalid @enderror">Designation</label>
                                        {{-- <input type="text" class="form-control" id="designation" name="designation" value="{{ old('designation') }}"> --}}
                                        <input type="text" class="form-control" id="designation" name="designation"
                                            value="{{ old('designation', $employee->designation) }}" readonly>
                                        @error('designation')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="department"
                                            class="form-label @error('department') is-invalid @enderror">Department</label>
                                        {{-- <input type="text" class="form-control" id="department" name="department" value="{{ old('department') }}"> --}}
                                        <input type="text" class="form-control" id="department" name="department"
                                            value="{{ old('department', $employee->department) }}" readonly>
                                        @error('department')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="leave_from"
                                            class="form-label @error('leave_from') is-invalid @enderror">Leave From</label>
                                        <input type="date" class="form-control" id="leave_from" name="leave_from"
                                            value="{{ old('leave_from') }}" min="{{ now()->toDateString() }}">
                                        @error('leave_from')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="leave_to"
                                            class="form-label @error('leave_to') is-invalid @enderror">Leave To</label>
                                        <input type="date" class="form-control" id="leave_to" name="leave_to"
                                            value="{{ old('leave_to') }}" min="{{ now()->toDateString() }}">
                                        @error('leave_to')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        let leaveFrom = document.getElementById('leave_from');
                                        let leaveTo = document.getElementById('leave_to');

                                        // Set the minimum date for leave_from (today)
                                        let today = new Date().toISOString().split('T')[0];
                                        leaveFrom.setAttribute('min', today);
                                        leaveTo.setAttribute('min', today);

                                        // Update leave_to's min date based on leave_from's selected date
                                        leaveFrom.addEventListener('change', function() {
                                            leaveTo.setAttribute('min', this.value);
                                        });
                                    });
                                </script>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="total_days"
                                            class="form-label @error('total_days') is-invalid @enderror">Total Days</label>
                                        <input type="text" class="form-control" id="total_days" name="total_days"
                                            value="{{ old('total_days') }}" readonly>
                                        @error('total_days')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            // Select the date fields and the total_days input
                                            const leaveFrom = document.getElementById('leave_from');
                                            const leaveTo = document.getElementById('leave_to');
                                            const totalDays = document.getElementById('total_days');

                                            // Function to calculate the total number of days
                                            function calculateTotalDays() {
                                                const fromDate = new Date(leaveFrom.value);
                                                const toDate = new Date(leaveTo.value);

                                                // Ensure both dates are valid before calculating
                                                if (fromDate && toDate && leaveFrom.value && leaveTo.value) {
                                                    const timeDiff = toDate - fromDate;
                                                    const days = timeDiff / (1000 * 3600 * 24) + 1; // Add 1 to include both start and end dates

                                                    if (days >= 0) {
                                                        totalDays.value = days;
                                                    } else {
                                                        totalDays.value = 0; // If 'Leave From' is after 'Leave To', set to 0
                                                    }
                                                } else {
                                                    totalDays.value = ''; // Clear if dates are not valid
                                                }
                                            }

                                            // Event listeners to recalculate total days when dates are changed
                                            leaveFrom.addEventListener('input', calculateTotalDays);
                                            leaveTo.addEventListener('input', calculateTotalDays);
                                        });
                                    </script>

                                    <div class="col-md-6">
                                        <label for="reason"
                                            class="form-label @error('reason') is-invalid @enderror">Reason</label>
                                        <select class="form-control" id="reason" name="reason">
                                            <option value="" disabled selected>Select Reason</option>
                                            <option value="PL" {{ old('reason') == 'PL' ? 'selected' : '' }}>PL
                                                (Privilege Leave)</option>
                                            <option value="Seek Leave"
                                                {{ old('reason') == 'Seek Leave' ? 'selected' : '' }}>Seek Leave</option>
                                            <option value="Casual Leave"
                                                {{ old('reason') == 'Casual Leave' ? 'selected' : '' }}>Casual Leave
                                            </option>
                                            <option value="LOP" {{ old('reason') == 'LOP' ? 'selected' : '' }}>LOP (Loss
                                                of Pay)</option>
                                            <option value="Transit Leave"
                                                {{ old('reason') == 'Transit Leave' ? 'selected' : '' }}>Transit Leave
                                            </option>
                                            <option value="Others" {{ old('reason') == 'Others' ? 'selected' : '' }}>Others
                                            </option>
                                        </select>
                                        @error('reason')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="remarks"
                                            class="form-label @error('remarks') is-invalid @enderror">Remarks</label>
                                        <input type="text" class="form-control" id="remarks" name="remarks"
                                            value="{{ old('remarks', $user->remarks) }}">
                                        @error('remarks')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="upload"
                                            class="form-label @error('upload') is-invalid @enderror">Upload</label>
                                        <input type="file" class="form-control" id="upload" name="upload"
                                            value="{{ old('upload') }}">
                                        @error('upload')
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
