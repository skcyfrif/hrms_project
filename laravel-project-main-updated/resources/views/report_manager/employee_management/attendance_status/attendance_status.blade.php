@extends('report_manager.report_manager_dashboard')
@section('report_manager')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Attendance Status</li>
        </ol>
    </nav>

    <div class="row mb-3">
        <form method="GET" action="{{ route('attendance.statusinrm') }}" class="d-flex">
            <div class="col-md-3">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-3 ms-2">
                <button type="submit" class="btn btn-primary">Filter by Date</button>
                <a href="{{ route('attendance.statusinrm') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Attendance Records</h5>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Check-in Time</th>
                                    <th>Employee Status</th>
                                    <th>System Time</th>
                                    <th>Approval Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attend as $key => $status)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $status->employeeattendancestatusinhrm->employee_id ?? 'N/A' }}</td>
                                        <td>{{ $status->name }}</td>
                                        <td>{{ $status->date }}</td>
                                        <td>{{ $status->check_in_time }}</td>
                                        <td>{{ $status->status }}</td>
                                        <td>{{ \Carbon\Carbon::parse($status->created_at)->format('H:i:s') }}</td>
                                        <td>{{ $status->manager_approval_status }}</td>
                                        <td>
                                            <a href="{{ route('attendanceinrm.approve', $status->id) }}" class="btn btn-success btn-sm">Present</a>
                                            <a href="{{ route('attendanceinrm.absent', $status->id) }}" class="btn btn-danger btn-sm">Absent</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($attend->isEmpty())
                                    <tr>
                                        <td colspan="9" class="text-center">No records found for this date.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
