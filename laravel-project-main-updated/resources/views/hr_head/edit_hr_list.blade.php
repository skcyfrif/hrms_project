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
                        <h6 class="card-title text-center mb-4">Edit hr Details</h6>

                        {{-- <form method="post" action="#" class="forms-sample"> --}}
                            <form method="post" action="{{ route('update.hr', $hr->id) }}" class="forms-sample">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="id" value="{{$hr->id}}">
                            <div class="row mb-4">

                                <div class="col-md-4">
                                    <label for="hr_id" class="form-label">HR ID</label>
                                    <input type="text" class="form-control" id="hr_id" name="hr_id"
                                           value="{{$hr->hr_id}}" required>
                                    @error('hr_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $hr->name }}" required>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                           value="{{ $hr->email }}" required>
                                    @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="photo" class="form-label">Photo</label>
                                    <input type="file" class="form-control" id="photo" name="photo"
                                           value="{{ $hr->photo }}" required>
                                    @error('photo')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                 {{-- System Access --}}
                                 <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label for="user_role" class="form-label">User Role</label>
                                        <input type="text" class="form-control" id="user_role" name="user_role"
                                               value="{{ $hr->user_role }}">
                                        @error('user_role')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username"
                                               value="{{ $hr->username }}">
                                        @error('username')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="text" class="form-control" id="password" name="password"
                                               value="{{ $hr->password }}">
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

























