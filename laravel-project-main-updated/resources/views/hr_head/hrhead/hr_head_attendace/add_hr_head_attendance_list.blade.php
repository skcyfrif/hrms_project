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
                            <h6 class="card-title text-center mb-4">Add or Edit Attendances</h6>

                            <form method="post" action="{{ route('store.hrheadattendance') }}" class="forms-sample"
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
                                        <label for="date"
                                            class="form-label @error('date') is-invalid @enderror">Date</label>
                                        <input type="date" class="form-control" id="date" name="date"
                                            value="{{ old('date', \Carbon\Carbon::now()->format('Y-m-d')) }}"
                                            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                            max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                        @error('date')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">

                                        <label for="check_in_time"
                                            class="form-label @error('check_in_time') is-invalid @enderror">Check In
                                            Time</label>
                                        <input type="time" class="form-control" id="check_in_time" name="check_in_time"
                                            value="{{ old('check_in_time') }}">
                                        @error('check_in_time')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    {{-- <div class="col-md-6">
                                    <label for="check_out_time" class="form-label @error('check_out_time') is-invalid @enderror">Check Out Time</label>
                                    <input type="time" class="form-control" id="check_out_time" name="check_out_time" value="{{ old('check_out_time') }}">
                                    @error('check_out_time')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                    {{-- <div class="col-md-6">
                                    <label for="work_hours" class="form-label @error('work_hours') is-invalid @enderror">Work Hours</label>
                                    <input type="time" class="form-control" id="work_hours" name="work_hours" value="{{ old('work_hours') }}" readonly>
                                    @error('work_hours')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div> --}}
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <label for="status"
                                                class="form-label @error('status') is-invalid @enderror">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="" disabled selected>Select Status</option>
                                                <option value="Present" {{ old('status') == 'Present' ? 'selected' : '' }}>
                                                    Present</option>
                                                {{-- <option value="Absent" {{ old('status') == 'Absent' ? 'selected' : '' }}>Absent</option> --}}
                                            </select>
                                            @error('status')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="remarks"
                                                class="form-label @error('remarks') is-invalid @enderror">Remarks</label>
                                            <input type="text" class="form-control" id="remarks" name="remarks"
                                                value="{{ old('remarks') }}">
                                            @error('remarks')
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
        $(document).ready(function() {
            function calculateWorkHours() {
                let checkIn = $("#check_in_time").val();
                let checkOut = $("#check_out_time").val();

                if (checkIn && checkOut) {
                    let checkInTime = new Date("1970-01-01T" + checkIn + "Z");
                    let checkOutTime = new Date("1970-01-01T" + checkOut + "Z");

                    let diffMs = checkOutTime - checkInTime; // Difference in milliseconds
                    let diffHours = Math.floor(diffMs / 3600000); // Convert to hours
                    let diffMinutes = Math.floor((diffMs % 3600000) / 60000); // Convert to minutes

                    let formattedTime = diffHours.toString().padStart(2, '0') + ":" + diffMinutes.toString()
                        .padStart(2, '0');

                    $("#work_hours").val(formattedTime);
                } else {
                    $("#work_hours").val(""); // Clear the field if inputs are empty
                }
            }

            $("#check_in_time, #check_out_time").on("change", calculateWorkHours);
        });
    </script>
@endsection
