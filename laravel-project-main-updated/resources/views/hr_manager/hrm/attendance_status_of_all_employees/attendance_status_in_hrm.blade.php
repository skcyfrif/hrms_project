@extends('hr_manager.hr_manager_dashboard')

@section('hr_manager')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
        </ol>
    </nav>

    <div class="row mb-3">
        <!-- Date Filter Form -->
        <form method="GET" action="{{ route('attendance.statusihnrm') }}" class="d-flex">
            <div class="col-md-3">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-3 ms-2">
                <button type="submit" class="btn btn-primary">Filter by Date</button>
                <a href="{{ route('attendance.statusihnrm') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Check-in Time</th>
                                    <th>Employee Status</th>
                                    <th>Approval Status</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attend as $key => $status)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $status->employeeattendancestatusinhrm->employee_id }}</td>
                                        <td>{{ $status->name }}</td>
                                        <td>{{ $status->date }}</td>
                                        <td>{{ $status->check_in_time }}</td>
                                        <td>{{ $status->status }}</td>
                                        <td>{{ $status->manager_approval_status }}</td>
                                        <td>
                                            <a href="{{ route('attendance.approve', $status->id) }}" class="btn btn-success">Present</a>
                                            <a href="{{ route('attendance.absent', $status->id) }}" class="btn btn-danger">Absent</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
