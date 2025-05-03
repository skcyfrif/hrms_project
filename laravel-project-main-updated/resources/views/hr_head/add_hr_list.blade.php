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
                        <h6 class="card-title text-center mb-4">Add or Edit HR Details</h6>

                        {{-- <form method="post" action="#" class="forms-sample" id="employeeForm"> --}}
                            <form method="post" action="{{ route('store.hr') }}" class="forms-sample" id="employeeForm">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    {{-- <label for="employee_id" class="form-label">Employee ID</label> --}}
                                    <label for="hr_id" class="form-label @error('hr_id') is-invalid @enderror">HR ID</label>
                                    <input type="text" class="form-control" id="hr_id" name="hr_id" value="{{ old('hr_id') }}">
                                    @error('hr_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

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
                                <div class="col-md-6">
                                    <label for="photo" class="form-label @error('photo') is-invalid @enderror">Photo</label>
                                    <input type="file" class="form-control" id="photo" name="photo" value="{{ old('photo') }}">
                                    @error('photo')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-4">
                                <h3 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">System Access</h3>

                                <div class="col-md-4">
                                    <label for="user_role" class="form-label @error('user_role') is-invalid @enderror">User Role</label>
                                    <select class="form-control" id="user_role" name="user_role" value="{{ old('user_role') }}">
                                        <option value="disable">- - -Select- - -</option>
                                        <option value="head">HR Head</option>
                                        <option value="manager">HR Manager</option>
                                        <option value="user">User</option>
                                    </select>
                                    @error('user_role')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="username" class="form-label @error('username') is-invalid @enderror">Username</label>
                                    <select class="form-control" id="username" name="username" value="{{ old('username') }}">
                                        <option value="disable">- - -Select- - -</option>
                                        <option value="hr_head">HR Head</option>
                                        <option value="hr_manager">HR Manager</option>
                                        <option value="user">User</option>
                                    </select>
                                    @error('username')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="password" class="form-label @error('password') is-invalid @enderror">Password</label>
                                    <input type="text" class="form-control" id="password" name="password" value="{{ old('password') }}">
                                    @error('password')
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
