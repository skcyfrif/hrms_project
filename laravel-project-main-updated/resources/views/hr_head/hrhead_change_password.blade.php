@extends('hr_head.hr_head_dashboard')
@section('hr_head')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">


    <div class="row profile-body">
        <!-- left wrapper start -->
        <div class="d-none d-md-block col-md-4 col-xl-4 left-wrapper">
            <div class="card rounded">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-2">


                        <div>
                            <img class="wd-100 rounded-circle" src="{{ (!empty($profileData->photo) ? url('upload/admin_images/'.$profileData->photo) : url('upload/no_image.jpg') ) }}" alt="profile">
                            <span class="h4 ms-3">{{$profileData->username}}</span>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Name:</label>
                        <p class="text-muted">{{$profileData->name}}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                        <p class="text-muted">{{$profileData->email}}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone:</label>
                        <p class="text-muted">{{$profileData->phone}}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Address:</label>
                        <p class="text-muted">{{$profileData->address}}</p>
                    </div>
                    <div class="mt-3 d-flex social-links">
                        <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                            <i data-feather="github"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                            <i data-feather="twitter"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                            <i data-feather="instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- left wrapper end -->
        <!-- middle wrapper start -->
        <div class="col-md-8 col-xl-8 middle-wrapper">
            <div class="row">
                <div class="card">
                    <div class="card-body">

                        <h6 class="card-title">Update Admin Password</h6>

                        <form method="post" action="{{route('manager.update.password')}}" class="forms-sample" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="old_password" class="form-label @error('old_password') is-invalid @enderror ">Old Password</label>
                                <input type="password" class="form-control" id="old_password" name="old_password" autocomplete="off">
                                @error('old_password')
                                    <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label @error('new_password') is-invalid @enderror ">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" autocomplete="off">
                                @error('new_password')
                                    <span class="text-danger"> {{$message}}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="new_password_confirmation" class="form-label">New Password Confirmation</label>
                                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" autocomplete="off">

                            </div>



                            <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- middle wrapper end -->
        <!-- right wrapper start -->

        <!-- right wrapper end -->
    </div>

</div>

@endsection
