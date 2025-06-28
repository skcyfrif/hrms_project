@extends('hr_head.hr_head_dashboard')


@section('hr_head')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Attendance Status of All Employees ({{ now()->year }})</h6>
                        <div class="table-responsive">

                            <form method="GET" action="{{ route('hrhead.employee.attendances') }}" class="mb-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="manager_id">Select Manager</label>
                                        <select name="manager_id" class="form-control" required>
                                            <option value="">-- Select Manager --</option>
                                            @foreach ($managers as $manager)
                                                <option value="{{ $manager->id }}"
                                                    {{ request('manager_id') == $manager->id ? 'selected' : '' }}>
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
                                                <option value="{{ $i }}"
                                                    {{ request('month') == $i ? 'selected' : '' }}>
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



                            {{-- @php
                                $managerId = request('manager_id');
                                $selectedMon = request('month');
                            @endphp

                            <div class="mb-3 text-end">
                                <form method="GET" action="{{ route('hr.download.employeeattendance') }}"
                                    style="display:inline">
                                    <input type="hidden" name="manager_id" value="{{ $managerId }}">
                                    <input type="hidden" name="month" value="{{ $selectedMon }}">
                                    <button type="submit" class="btn btn-success"
                                        {{ $managerId && $selectedMon ? '' : 'disabled' }}>
                                        Download Report
                                    </button>
                                </form>
                            </div> --}}


                            @php
                                $managerId = request('manager_id');
                                $selectedMon = request('month');
                            @endphp

                            <div class="mb-3 text-end">
                                <form method="GET" action="{{ route('hr.download.employeeattendance') }}"
                                    style="display:inline;">
                                    <input type="hidden" name="manager_id" value="{{ $managerId }}">
                                    <input type="hidden" name="month" value="{{ $selectedMon }}">

                                    <button type="submit" class="btn btn-success"
                                        @if (empty($managerId) || empty($selectedMon)) disabled @endif>
                                        Download Report
                                    </button>
                                </form>
                            </div>


                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Attendance Status</th>
                                        <th>Check-in Time</th>
                                        <th>System Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($employees as $emp)
                                        @foreach ($emp->filteredAttendances as $attendance)
                                            @php
                                                $status = 'Present';

                                                if ($attendance->status === 'On Leave') {
                                                    $status = 'On Leave';
                                                    $checkInDisplay = '---';
                                                    $systemTimeDisplay = '---';
                                                } elseif ($attendance->check_in_time) {
                                                    $checkIn = \Carbon\Carbon::parse($attendance->check_in_time);
                                                    $cutoffTime = \Carbon\Carbon::parse(
                                                        $attendance->date . ' 12:01:00',
                                                    );
                                                    $status = $checkIn->gt($cutoffTime)
                                                        ? 'Absent'
                                                        : $attendance->status ?? 'Present';
                                                    $checkInDisplay = $checkIn->format('h:i A');
                                                    $systemTimeDisplay = $attendance->created_at
                                                        ? \Carbon\Carbon::parse($attendance->created_at)->format(
                                                            'H:i:s',
                                                        )
                                                        : '---';
                                                } else {
                                                    $status = $attendance->status ?? '---';
                                                    $checkInDisplay = '---';
                                                    $systemTimeDisplay = '---';
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d/M/Y') }}</td>
                                                <td>{{ $emp->employee_id }}</td>
                                                <td>{{ $emp->name }}</td>
                                                <td>{{ $emp->email }}</td>
                                                <td>{{ $emp->user_role }}</td>
                                                <td>
                                                    @if ($status === 'On Leave')
                                                        <span class="badge bg-info text-dark">On Leave</span>
                                                    @else
                                                        {{ $attendance->status }}
                                                    @endif
                                                </td>
                                                <td>{{ $checkInDisplay }}</td>
                                                <td>{{ $systemTimeDisplay }}</td>
                                            </tr>
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No HR Head attendance records found for
                                                the selected month.</td>
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
