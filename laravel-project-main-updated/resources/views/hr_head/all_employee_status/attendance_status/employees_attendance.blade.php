@extends('hr_head.hr_head_dashboard')

@section('hr_head')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Attendance Status of Report Managers</h6>
                        <div class="table-responsive">
                            <!-- Filter Form -->
                            <form method="GET" action="{{ route('hrhead.employee.attendances') }}" class="mb-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="manager_id">Select Manager</label>
                                        <select name="manager_id" class="form-control" required>
                                            <option value="">-- Select Manager --</option>
                                            @foreach ($managers as $manager)
                                                <option value="{{ $manager->id }}" {{ request('manager_id') == $manager->id ? 'selected' : '' }}>
                                                    {{ $manager->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="month">Select Month</label>
                                        <select name="month" class="form-control" required>
                                            <option value="">-- Select Month --</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-4 align-self-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Attendance Table -->
                            <table class="table table-bordered mt-4">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Check-in</th>
                                        <th>System Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($employees as $emp)
                                        @forelse ($emp->filteredAttendances as $key => $attendance)
                                            @php
                                                $checkIn = \Carbon\Carbon::parse($attendance->check_in_time);
                                                $cutoff = \Carbon\Carbon::parse($attendance->date . ' 12:01:00');
                                                $status = $checkIn->gt($cutoff) ? 'Absent' : ($attendance->status ?? 'Present');
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->parent->iteration }}.{{ $key + 1 }}</td>
                                                <td>{{ $emp->employee_id }}</td>
                                                <td>{{ $emp->name }}</td>
                                                <td>{{ $emp->email }}</td>
                                                <td>{{ $emp->user_role }}</td>
                                                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M, Y') }}</td>
                                                <td>{{ $status }}</td>
                                                <td>{{ \Carbon\Carbon::parse($attendance->check_in_time)->format('h:i A') ?? '---' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($attendance->created_at)->format('H:i:s') ?? '---' }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No attendance records for {{ $emp->name }}</td>
                                            </tr>
                                        @endforelse
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No report managers found for selected manager/month.</td>
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
