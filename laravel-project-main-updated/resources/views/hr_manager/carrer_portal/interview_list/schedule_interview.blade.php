@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Schedule Interview</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Schedule Interview for</h6>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('store.interview') }}">
                        {{-- <form method="POST" action="#"> --}}
                        @csrf
                        <input type="hidden" name="candidate_id" value="{{ $candidate->id }}">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ $candidate->name }}">
                        </div>

                        <div class="mb-3">
                            <label for="mobile" class="form-label">Mobile</label>
                            <input type="text" name="mobile" class="form-control" id="mobile" value="{{ $candidate->mobile }}">
                        </div>

                        <div class="mb-3">
                            <label for="interview_date" class="form-label">Interview Date</label>
                            <input type="date" name="interview_date" class="form-control" id="interview_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="interview_time" class="form-label">Interview Time</label>
                            <input type="time" name="interview_time" class="form-control" id="interview_time" required>
                        </div>

                        <div class="mb-3">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" class="form-control" id="location" placeholder="Enter interview location" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
