@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Attendance Status Of All Employees ({{ now()->year }})</h6>
                        <div class="table-responsive">

                            <form method="GET" action="{{ route('admin.employeesattendances') }}" class="mb-4">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-auto">
                                        <label for="month" class="form-label">Filter by Month:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" id="month" name="month">
                                            <option value="">-- Select Month --</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ sprintf('%02d', $i) }}" {{ request('month') == sprintf('%02d', $i) ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-auto">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                    <div class="col-md-auto">
                                        <a href="{{ route('admin.employeesattendances') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>

                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Date</th>
                                        <th>Attendance Status</th>
                                        <th>Check-in Time</th>
                                        <th>System Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($hrHeads as $head)
                                        @forelse ($head->filteredAttendances as $key => $attendance)
                                            @php
                                                $checkIn = \Carbon\Carbon::parse($attendance->check_in_time);
                                                $cutoffTime = \Carbon\Carbon::parse($attendance->date . ' 12:01:00');
                                                $status = $checkIn->gt($cutoffTime) ? 'Absent' : ($attendance->status ?? 'Present');
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->parent->iteration }}.{{ $key + 1 }}</td>
                                                <td>{{ $head->employee_id }}</td>
                                                <td>{{ $head->name }}</td>
                                                <td>{{ $head->email }}</td>
                                                <td>{{ $head->user_role }}</td>
                                                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d/M/Y') }}</td>
                                                <td>{{ $status }}</td>
                                                <td>{{ \Carbon\Carbon::parse($attendance->check_in_time)->format('h:i A') ?? '---' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($attendance->created_at)->format('H:i:s') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No attendance found for {{ $head->name }}</td>
                                            </tr>
                                        @endforelse
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No HR Heads Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
