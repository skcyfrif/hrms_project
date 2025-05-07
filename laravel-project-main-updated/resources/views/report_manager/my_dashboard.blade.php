@extends('report_manager.report_manager_dashboard')
@section('report_manager')

<div class="container-fluid">
    <!-- Page Title -->
    <div class="row mb-4">
        <div class="col-md-6">
            <h3 class="text-primary">Welcome, {{ $employee->name }}</h3>
            <p class="text-muted">Your dashboard for the HRMS system</p>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-warning">Edit Profile</button>
        </div>
    </div>

    <!-- Dashboard Info Row -->
    <div class="row">
        <!-- Profile Info -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm bg-light">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Name:</strong> {{ $employee->name }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $employee->email }}</li>
                        <li class="list-group-item"><strong>Department:</strong> {{ $employee->department }}</li>
                        <li class="list-group-item"><strong>Designation:</strong> {{ $employee->designation }}</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Leave Balance -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm bg-light">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Leave Balance</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Available PL:</strong> {{ $leaveBalanceData->pl_balance ?? 0 }}</li>
                        <li class="list-group-item"><strong>Available SL:</strong> {{ $leaveBalanceData->sl_balance ?? 0 }}</li>
                        <li class="list-group-item"><strong>Taken LOP:</strong> {{ $leaveBalanceData->lop_days ?? 0 }}</li>

                        {{-- <li class="list-group-item"><strong>Designation:</strong> {{ $employee->designation }}</li> --}}
                    </ul>
                </div>
            </div>
        </div>

        <!-- Attendance -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm bg-light">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Attendance</h5>
                </div>
                <div class="card-body">
                    @if($attendance && $attendance->check_in_time)
                        <p><strong>Last Check-In:</strong> {{ $attendance->check_in_time->format('Y-m-d H:i:s') }}</p>
                    @else
                        <p>No check-in recorded today.</p>
                    @endif
                </div>
            </div>


        </div>
    </div>

    <!-- Team Members Section -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm bg-light">
                <div class="card-header bg-warning text-white">

                    <a href="{{ route('assigned.employees') }}" class="btn btn-primary">My Team Members ({{ $teamMembers->count() }})</a>
                </div>
                <div class="card-body">

                <div class="text-center mt-3">

                </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm bg-light">
                <div class="card-header bg-danger text-white">

                    <a href="{{ route('rm.employee.attendance', ['date' => now()->toDateString()]) }}" class="btn btn-primary">
                        Attendance Snapshot: ({{ $presentCount }})
                    </a>

                </div>
                <div class="card-body">
                    <ul class="list-group">

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm bg-light">
                <div class="card-header bg-danger text-white">
                    {{-- <h5 class="mb-0">Quick Acess Leave Approval Holidays</h5> --}}
                    <a href="{{ route('rmapproval.status') }}" class="btn btn-primary">
                        Quick Acess Leave Approval Status ({{ $pendingLeaveCount }})
                    </a>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        {{-- @forelse($holidays as $holiday)
                            <li class="list-group-item">{{ $holiday->name }} - {{ $holiday->date->format('Y-m-d') }}</li>
                        @empty
                            <li class="list-group-item">No upcoming holidays.</li>
                        @endforelse --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm bg-light">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Upcoming Holidays</h5>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    {{-- @forelse($holidays as $holiday)
                        <li class="list-group-item">{{ $holiday->name }} - {{ $holiday->date->format('Y-m-d') }}</li>
                    @empty
                        <li class="list-group-item">No upcoming holidays.</li>
                    @endforelse --}}
                </ul>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm bg-light">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Recent Notifications</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        {{-- @forelse($notifications as $notification)
                            <li class="list-group-item">{{ $notification->message }} - {{ $notification->created_at->format('Y-m-d H:i:s') }}</li>
                        @empty
                            <li class="list-group-item">No recent notifications.</li>
                        @endforelse --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
</div>

@endsection

@section('styles')
<style>
    /* Additional Custom Styling */
    .card-header {
        font-weight: bold;
    }

    .btn-warning {
        background-color: #FFC107; /* Yellow */
        border-color: #FFC107;
    }

    .btn-warning:hover {
        background-color: #FF9800; /* Darker Yellow */
        border-color: #FF9800;
    }

    .list-group-item {
        background-color: #f9f9f9; /* Light gray for better readability */
    }

    .list-group-item strong {
        color: #007bff; /* Blue color for labels */
    }

    .card-body {
        padding: 20px;
    }

    .container-fluid {
        padding: 30px;
    }
</style>
@endsection
