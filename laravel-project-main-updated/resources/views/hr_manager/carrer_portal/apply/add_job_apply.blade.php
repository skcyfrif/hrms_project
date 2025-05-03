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
                        <h6 class="card-title text-center mb-4">Add or Edit Attendances</h6>

                        <form method="post" action="{{ route('store.apply') }}" enctype="multipart/form-data" class="forms-sample" id="employeeForm">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="name" class="form-label @error('name') is-invalid @enderror">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label @error('email') is-invalid @enderror">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="mobile" class="form-label @error('mobile') is-invalid @enderror">Mobile</label>
                                    <input type="phone" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}">
                                    @error('mobile')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="applied_for" class="form-label @error('applied_for') is-invalid @enderror">Applied For</label>
                                    <input type="text" class="form-control" id="applied_for" name="applied_for" value="{{ old('applied_for') }}">
                                    @error('applied_for')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="applied_date" class="form-label @error('applied_date') is-invalid @enderror">Applied Date</label>
                                    <input type="date" class="form-control" id="applied_date" name="applied_date"
                                           value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" readonly>
                                    @error('applied_date')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-6">
                                    <label for="resume" class="form-label @error('resume') is-invalid @enderror">Resume</label>
                                    <input type="file" class="form-control" id="resume" name="resume">
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
    </div>
</div>
@endsection
