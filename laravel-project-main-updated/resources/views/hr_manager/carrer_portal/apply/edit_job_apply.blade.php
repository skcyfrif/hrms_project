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

                        <form method="post" action="{{ route('update.apply', $aten->id) }}" class="forms-sample">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{$aten->id}}">
                            <div class="row mb-4">

                                <div class="col-md-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $aten->name }}" required>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                           value="{{ $aten->email }}" required>
                                    @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="mobile" class="form-label">Mobile</label>
                                    <input type="mobile" class="form-control" id="mobile" name="mobile"
                                           value="{{ $aten->mobile }}" required>
                                    @error('mobile')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="applied_for" class="form-label">Applied For</label>
                                    <input type="applied_for" class="form-control" id="applied_for" name="applied_for"
                                           value="{{ $aten->applied_for }}" required>
                                    @error('applied_for')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="applied_date" class="form-label">Applied Date</label>
                                    <input type="applied_date" class="form-control" id="applied_date" name="applied_date"
                                           value="{{ $aten->applied_date }}" required>
                                    @error('applied_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="resume" class="form-label">Resume</label>
                                    <input type="resume" class="form-control" id="resume" name="resume"
                                           value="{{ $aten->resume }}" required>
                                    @error('resume')
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

























