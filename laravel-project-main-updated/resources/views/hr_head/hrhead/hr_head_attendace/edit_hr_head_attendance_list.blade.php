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
                        <h6 class="card-title text-center mb-4">Edit Attendance Details</h6>

                        <form method="post" action="{{ route('update.hrheadattendance', $aten->id) }}" class="forms-sample">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{$aten->id}}">
                            <div class="row mb-4">

                                <div class="col-md-4">
                                    <label for="employee_id" class="form-label">Employee ID</label>
                                    <input type="text" class="form-control" id="employee_id" name="employee_id"
                                           value="{{$aten->employee_id}}" required>
                                    @error('employee_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $aten->name }}" required>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date"
                                           value="{{ old('date', $aten->date) }}"
                                           min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                           max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                           required>
                                    @error('date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="check_in_time" class="form-label">Check In Time</label>
                                    <input type="time" class="form-control" id="check_in_time" name="check_in_time"
                                           value="{{ $aten->check_in_time }}" required>
                                    @error('check_in_time')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="row mb-4">

                            </div>

                            <div class="row mb-4">

                                {{-- <div class="col-md-4">
                                    <label for="check_out_time" class="form-label">Check Out Time</label>
                                    <input type="time" class="form-control" id="check_out_time" name="check_out_time"
                                           value="{{ $aten->check_out_time }}" required>
                                    @error('check_out_time')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="work_hours" class="form-label">Work Hours</label>
                                    <input type="time" class="form-control" id="work_hours" name="work_hours"
                                           value="{{ $aten->work_hours }}" required>
                                    @error('work_hours')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div> --}}

                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="" disabled>Select Status</option>
                                        <option value="Present" {{ $aten->status == 'Present' ? 'selected' : '' }}>Present</option>
                                        {{-- <option value="Absent" {{ $aten->status == 'Absent' ? 'selected' : '' }}>Absent</option> --}}
                                    </select>
                                    @error('status')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <input type="text" class="form-control" id="remarks" name="remarks"
                                           value="{{ $aten->remarks }}" required>
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

@endsection

























