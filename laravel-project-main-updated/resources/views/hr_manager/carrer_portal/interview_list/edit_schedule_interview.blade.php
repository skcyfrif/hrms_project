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
                        <h6 class="card-title text-center mb-4">Edit Apply Details</h6>

                        <form method="post" action="{{ route('update.candidate', $aten->id) }}" class="forms-sample">
                            @csrf
                            {{-- @method('PUT') --}}
                            <input type="hidden" name="candidate_id" value="{{$aten->id}}">
                            <div class="row mb-4">

                                <div class="col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $aten->name }}" required>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input type="mobile" class="form-control" id="mobile" name="mobile"
                                           value="{{ $aten->mobile }}" required>
                                    @error('mobile')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="interview_date" class="form-label">Previous Date</label>
                                    <input type="date" class="form-control" id="interview_date" name="interview_date"
                                           value="{{ $interview->interview_date }}" required>
                                    @error('interview_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="interview_time" class="form-label">Previous Time</label>
                                    <input type="time" class="form-control" id="interview_time" name="interview_time"
                                           value="{{ $interview->interview_time }}" required>
                                    @error('interview_time')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">

                                <div class="col-md-6">
                                    <label for="location" class="form-label">Previous Location</label>
                                    <input type="location" class="form-control" id="location" name="location"
                                           value="{{ $interview->location }}" required>
                                    @error('location')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="new_date" class="form-label">New Date</label>
                                    <input type="date" class="form-control" id="new_date" name="new_date"
                                           value="{{ $interview->new_date }}" required>
                                    @error('new_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">

                                <div class="col-md-6">
                                    <label for="new_time" class="form-label">New Time</label>
                                    <input type="time" class="form-control" id="new_time" name="new_time"
                                           value="{{ $interview->new_time }}" required>
                                    @error('new_time')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="new_location" class="form-label">New Location</label>
                                    <input type="new_location" class="form-control" id="new_location" name="new_location"
                                           value="{{ $interview->new_location }}" required>
                                    @error('new_location')
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

























