@extends('admin.admin_dashboard')

@section('admin')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Attendance Status Of All Report Managers ({{ now()->year }})</h6>
                        <div class="table-responsive">

                            <form method="GET" action="{{ route('admin.report_managersattendances') }}" class="mb-4">
                                <div class="row g-3 align-items-center">
                                    <div class="col-md-auto">
                                        <label for="month" class="form-label">Filter by Month:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" id="month" name="month">
                                            <option value="">-- Select Month --</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ sprintf('%02d', $i) }}"
                                                    {{ request('month') == sprintf('%02d', $i) ? 'selected' : '' }}>
                                                    {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-auto">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                    <div class="col-md-auto">
                                        <a href="{{ route('admin.report_managersattendances') }}"
                                            class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>


                            @php
                                $selectedMonth = request('month', now()->format('m'));
                            @endphp
                            <div class="mb-3 text-end">
                                <a href="{{ route('admin.download.reportmanagerattendances', ['month' => $selectedMonth]) }}"
                                    class="btn btn-success">
                                    Download Attendance Report
                                </a>
                            </div>


                            {{-- @php
                                $currentMonth = now()->format('m');
                            @endphp

                            <div class="mb-3 text-end">
                                <a href="{{ route('admin.download.reportmanagerattendances', ['type' => 'monthly', 'month' => $currentMonth]) }}"
                                    class="btn btn-success">
                                    Download Current Month Report
                                </a>
                            </div> --}}


                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
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
                                    @forelse ($hrHeads as $head)
                                        @foreach ($head->filteredAttendances as $attendance)
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
                                                <td>{{ $head->employee_id }}</td>
                                                <td>{{ $head->name }}</td>
                                                <td>{{ $head->email }}</td>
                                                <td>{{ $head->user_role }}</td>
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
