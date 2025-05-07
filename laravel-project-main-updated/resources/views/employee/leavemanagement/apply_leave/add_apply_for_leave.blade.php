@extends('employee.employee_dashboard')
@section('employee')
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
                            <h6 class="card-title text-center mb-4">Add or Edit Leave</h6>

                            <form method="post" action="{{ route('store.leave') }}" class="forms-sample"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="employee_id" class="form-label">Employee ID</label>
                                        <input type="hidden" class="form-control" id="employee_id" name="employee_id"
                                            value="{{ $employee->id }}">
                                        <input type="text" class="form-control" value="{{ $employee->employee_id }}"
                                            readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $user->name }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="designation" class="form-label">Designation</label>
                                        <input type="text" class="form-control" id="designation" name="designation"
                                            value="{{ $employee->designation }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="department" class="form-label">Department</label>
                                        <input type="text" class="form-control" id="department" name="department"
                                            value="{{ $employee->department }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="leave_from" class="form-label">Leave From</label>
                                        <input type="date" class="form-control" id="leave_from" name="leave_from"
                                            min="{{ now()->toDateString() }}"
                                            value="{{ old('leave_from') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="leave_to" class="form-label">Leave To</label>
                                        <input type="date" class="form-control" id="leave_to" name="leave_to"
                                            min="{{ now()->toDateString() }}"
                                            value="{{ old('leave_to') }}">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <label for="total_days" class="form-label">Total Days</label>
                                        <input type="text" class="form-control" id="total_days" name="total_days" value="{{ old('total_days') }}"
                                            readonly>
                                    </div>

                                    <!-- Hidden input to store employee type -->
                                    <input type="hidden" id="employment_type" value="{{ $employee->employment_type }}">

                                    <div class="col-md-6">
                                        <label for="reason" class="form-label">Reason</label>
                                        <select class="form-control" id="reason" name="reason">
                                            <option value="" disabled selected>Select Reason</option>
                                            <!-- Options will be added via JavaScript -->
                                        </select>
                                    </div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            const empType = document.getElementById('employment_type').value;
                                            const reasonSelect = document.getElementById('reason');

                                            const allOptions = [{
                                                    value: 'PL',
                                                    label: 'PL'
                                                },
                                                {
                                                    value: 'SL',
                                                    label: 'SL'
                                                },
                                                {
                                                    value: 'LOP',
                                                    label: 'LOP'
                                                },
                                            ];

                                            let optionsToShow = [];

                                            if (empType === 'permanent') {
                                                optionsToShow = allOptions;
                                            } else {
                                                optionsToShow = [allOptions.find(opt => opt.value === 'LOP')];
                                            }

                                            // Clear existing options except the first
                                            reasonSelect.length = 1;

                                            // Add allowed options
                                            optionsToShow.forEach(opt => {
                                                const option = new Option(opt.label, opt.value);
                                                reasonSelect.add(option);
                                            });
                                        });
                                    </script>
                                </div>
                                <div class="row mb-4">


                                    <div class="col-md-6">
                                        <label for="remarks" class="form-label">Remarks</label>
                                        <input type="text" class="form-control" id="remarks" name="remarks"
                                            value="{{ old('remarks', $user->remarks) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="upload" class="form-label">Upload</label>
                                        <input type="file" class="form-control" id="upload" name="upload">
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
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const leaveFrom = document.getElementById('leave_from');
            const leaveTo = document.getElementById('leave_to');
            const totalDays = document.getElementById('total_days');
            const reasonDropdown = document.getElementById('reason');
            const employeeId = document.getElementById('employee_id').value;

            function calculateTotalDays() {
                const fromDate = new Date(leaveFrom.value);
                const toDate = new Date(leaveTo.value);

                if (fromDate && toDate && leaveFrom.value && leaveTo.value) {
                    const days = Math.max(0, (toDate - fromDate) / (1000 * 3600 * 24) + 1);
                    totalDays.value = days;
                    checkLeaveBalance(employeeId, days);
                } else {
                    totalDays.value = '';
                }
            }

            // function checkLeaveBalance(employeeId, days) {
            //     $.ajax({
            //         url: "{{ route('check.leave.balance') }}",
            //         type: "GET",
            //         data: { employee_id: employeeId, days: days },
            //         success: function (response) {
            //             reasonDropdown.innerHTML = `<option value="" disabled selected>Select Reason</option>`;
            //             if (response.pl_available) {
            //                 reasonDropdown.innerHTML += `<option value="PL">PL (Privilege Leave)</option>`;
            //             }
            //             if (response.sl_available) {
            //                 reasonDropdown.innerHTML += `<option value="SL">SL (Sick Leave)</option>`;
            //             }
            //             if (response.cl_available) {
            //                 reasonDropdown.innerHTML += `<option value="CL">CL (Casual Leave)</option>`;
            //             }
            //             reasonDropdown.innerHTML += `<option value="LOP">LOP (Loss of Pay)</option>`;
            //         }
            //     });
            // }

            leaveFrom.addEventListener('input', calculateTotalDays);
            leaveTo.addEventListener('input', calculateTotalDays);
        });
    </script>
@endsection
