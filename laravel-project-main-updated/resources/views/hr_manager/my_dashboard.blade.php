@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container-fluid mt-6">
    <!-- Header Section -->
    <div class="row mb-4 align-items-center justify-content-between">
        <div class="col-md-8">
            <h2 class="text-primary mb-1">Welcome, {{ $employee->name }}</h2>
            <p class="text-muted mb-0">HR Manager Dashboard</p>
        </div>
        <div class="col-md-2 text-end">
            <div class="input-group flatpickr w-100" id="dashboardDate">
                <span class="input-group-text bg-transparent border-primary" data-toggle>
                    <i data-feather="calendar" class="text-primary"></i>
                </span>
                <input type="text" class="form-control text-black bg-transparent border-primary" placeholder="Select date" data-input>
            </div>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row mb-4">
        <!-- Profile Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Employee Profile</div>
                            <div class="h6 mb-0 text-gray-800">
                                <div><i class="fas fa-user me-2"></i>{{ $employee->name }}</div>
                                <div><i class="fas fa-building me-2"></i>{{ $employee->department }}</div>
                                <div><i class="fas fa-briefcase me-2"></i>{{ $employee->designation }}</div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leave Balance Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Leave Balance</div>
                            <div class="h6 mb-0 text-gray-800">
                                <div><i class="fas fa-sun me-2"></i>PL: {{ $leaveBalanceData->pl_balance ?? 0 }}</div>
                                <div><i class="fas fa-procedures me-2"></i>SL: {{ $leaveBalanceData->sl_balance ?? 0 }}</div>
                                <div><i class="fas fa-exclamation-triangle me-2"></i>LOP: {{ $leaveBalanceData->lop_days ?? 0 }}</div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Today's Attendance</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @if ($attendance && $attendance->check_in_time)
                                    <span class="text-success"><i class="fas fa-check-circle me-2"></i>Checked In</span>
                                    <div class="text-muted small mt-1">{{ $attendance->check_in_time->format('h:i A') }}</div>
                                @else
                                    <span class="text-danger"><i class="fas fa-times-circle me-2"></i>Not Recorded</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Team Members Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Team Members</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMembers }}</div>
                            <a href="{{ route('employee.list') }}" class="btn btn-sm btn-primary mt-2">
                                <i class="fas fa-users me-1"></i> View Team
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Approval Section -->
    <div class="row mb-4">
        <!-- Leave Approvals -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-calendar-check me-2"></i>Leave Approvals</h6>
                    <span class="badge bg-light text-dark">{{ $pendingLeaveCountemplyee + $pendingLeaveCountreportmanager }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="border p-3 rounded">
                                <h6 class="text-center mb-3">Employees</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Pending Requests</span>
                                    <span class="badge bg-danger">{{ $pendingLeaveCountemplyee }}</span>
                                </div>
                                <a href="{{ route('approval.status') }}" class="btn btn-sm btn-primary w-100 mt-2">
                                    <i class="fas fa-tasks me-1"></i> Manage
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="border p-3 rounded">
                                <h6 class="text-center mb-3">Reporting Managers</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Pending Requests</span>
                                    <span class="badge bg-danger">{{ $pendingLeaveCountreportmanager }}</span>
                                </div>
                                <a href="{{ route('approval.rmstatus') }}" class="btn btn-sm btn-primary w-100 mt-2">
                                    <i class="fas fa-tasks me-1"></i> Manage
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-file-invoice-dollar me-2"></i>Claim Approvals</h6>
                    <span class="badge bg-light text-dark">{{ $pendingClaimCount + $pendingClaimCountrm }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="border p-3 rounded">
                                <h6 class="text-center mb-3">Employees</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Pending Requests</span>
                                    <span class="badge bg-danger">{{ $pendingClaimCount }}</span>
                                </div>
                                <a href="{{ route('claimapproval.status') }}" class="btn btn-sm btn-success w-100 mt-2">
                                    <i class="fas fa-tasks me-1"></i> Manage
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="border p-3 rounded">
                                <h6 class="text-center mb-3">Reporting Managers</h6>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted">Pending Requests</span>
                                    <span class="badge bg-danger">{{ $pendingClaimCountrm }}</span>
                                </div>
                                <a href="{{ route('rmclaimapproval.status') }}" class="btn btn-sm btn-success w-100 mt-2">
                                    <i class="fas fa-tasks me-1"></i> Manage
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance & Recruitment Section -->
    <div class="row mb-4">
        <!-- Attendance Snapshot -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-clipboard-list me-2"></i>Attendance Snapshots</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('hrm.rm.attendance', ['date' => now()->toDateString()]) }}"
                               class="btn btn-info w-100 d-flex flex-column align-items-center p-3">
                                <i class="fas fa-user-tie fa-2x mb-2"></i>
                                <span>Reporting Managers</span>
                                <span class="badge bg-light text-dark mt-1">{{ $presentCount }}</span>
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('hrm.employee.attendance', ['date' => now()->toDateString()]) }}"
                               class="btn btn-info w-100 d-flex flex-column align-items-center p-3">
                                <i class="fas fa-users fa-2x mb-2"></i>
                                <span>Employees</span>
                                <span class="badge bg-light text-dark mt-1">{{ $presentCount }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recruitment Pipeline -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-purple text-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-user-plus me-2"></i>Recruitment Pipeline</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('candidate.list') }}"
                               class="btn btn-purple w-100 d-flex flex-column Recruitment_card_one align-items-center p-3">
                                <i class="fas fa-user-clock fa-2x mb-2"></i>
                                <span>Applicants</span>
                                <span class="badge bg-light text-dark mt-1">{{ $candidateCount }}</span>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="{{ route('interview.list') }}"
                               class="btn btn-purple w-100 d-flex flex-column Recruitment_card_two align-items-center p-3">
                                <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                                <span>Interviews</span>
                                <span class="badge bg-light text-dark mt-1">{{ $sheduledcandidateCount }}</span>
                            </a>
                        </div>
                        <div class="col-md-4 mb-3">
                            <a href="#" class="btn btn-purple w-100 d-flex flex-column Recruitment_card_three align-items-center p-3">
                                <i class="fas fa-envelope-open-text fa-2x mb-2"></i>
                                <span>Offers</span>
                                <span class="badge bg-light text-dark mt-1">0</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="row">
        <!-- Upcoming Holidays -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-umbrella-beach me-2"></i>Upcoming Holidays</h6>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-day fa-3x text-warning mb-3"></i>
                        <p class="text-muted">No upcoming holidays in the next 30 days</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Notifications -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header bg-danger text-white">
                    <h6 class="m-0 font-weight-bold"><i class="fas fa-bell me-2"></i>Recent Notifications</h6>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <i class="fas fa-bell-slash fa-3x text-danger mb-3"></i>
                        <p class="text-muted">No new notifications</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    :root {
        --purple: #6f42c1;
    }

    .bg-purple {
        background-color: var(--purple) !important;
    }

    .btn-purple {
        background-color: var(--purple);
        border-color: var(--purple);
        color: white;
    }

    .btn-purple:hover {
        background-color: #5a32a3;
        border-color: #5a32a3;
        color: white;
    }

    .card {
        border: none;
        border-radius: 0.5rem;
    }

    .card-header {
        border-radius: 0.5rem 0.5rem 0 0 !important;
        padding: 1rem 1.25rem;
    }

    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }

    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }

    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }

    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }

    .shadow-sm {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
    }

    .h-100 {
        height: 100% !important;
    }

    .text-xs {
        font-size: 0.7rem;
    }

    .badge {
        font-size: 0.75em;
        font-weight: 600;
        padding: 0.35em 0.65em;
    }

    .flatpickr-input {
        background: white !important;
    }
    .Recruitment_card_three {
        background-color: #66d1d1;

    }
    .Recruitment_card_one {
        background-color: #FF5733;
    }
    .Recruitment_card_two {
        background-color: #05a34a;
    }
</style>


@endsection
