@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="row profile-body">
        <!-- Middle Wrapper Start -->
        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <h6 class="card-title text-center mb-4">Edit Attendance Details</h6>

                        <form method="post" action="{{ route('update.attendance', $test->id) }}" class="forms-sample">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{$test->id}}">
                            <div class="row mb-4">

                                <div class="col-md-4">
                                    <label for="employee_id" class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" id="employee_id" name="employee_id"
                                           value="{{$test->employee_id}}" required>
                                    @error('employee_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $test->name }}" required>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date"
                                           value="{{ $test->date }}" required>
                                    @error('date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="check_in_time" class="form-label">Check In Time</label>
                                    <input type="time" class="form-control" id="check_in_time" name="check_in_time"
                                           value="{{ $test->check_in_time }}" required>
                                    @error('check_in_time')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-4">

                            </div>

                            <div class="row mb-4">

                                <div class="col-md-4">
                                    <label for="check_out_time" class="form-label">Check Out Time</label>
                                    <input type="time" class="form-control" id="check_out_time" name="check_out_time"
                                           value="{{ $test->check_out_time }}" required>
                                    @error('check_out_time')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="work_hours" class="form-label">Work Hours</label>
                                    <input type="time" class="form-control" id="work_hours" name="work_hours"
                                           value="{{ $test->work_hours }}" required>
                                    @error('work_hours')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status</label>
                                    <input type="text" class="form-control" id="status" name="status"
                                           value="{{ $test->status }}" required>
                                    @error('status')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <input type="text" class="form-control" id="remarks" name="remarks"
                                           value="{{ $test->remarks }}" required>
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
    $(document).ready(function () {
        function calculateWorkHours() {
            let checkIn = $("#check_in_time").val();
            let checkOut = $("#check_out_time").val();

            if (checkIn && checkOut) {
                let checkInTime = new Date("1970-01-01T" + checkIn + "Z");
                let checkOutTime = new Date("1970-01-01T" + checkOut + "Z");

                let diffMs = checkOutTime - checkInTime; // Difference in milliseconds
                let diffHours = Math.floor(diffMs / 3600000); // Convert to hours
                let diffMinutes = Math.floor((diffMs % 3600000) / 60000); // Convert to minutes

                let formattedTime = diffHours.toString().padStart(2, '0') + ":" + diffMinutes.toString().padStart(2, '0');

                $("#work_hours").val(formattedTime);
            } else {
                $("#work_hours").val(""); // Clear the field if inputs are empty
            }
        }

        $("#check_in_time, #check_out_time").on("change", calculateWorkHours);
    });
</script>

@endsection

























