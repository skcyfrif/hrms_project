@extends('hr_manager.hr_manager_dashboard')

@section('hr_manager')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Attendance Status Of All Report managers ({{ now()->year }})</h6>
                        <div class="table-responsive">

                            <form method="GET" action="{{ route('hrm.rm.attendance') }}" class="mb-4">
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
                                        <a href="{{ route('hrm.rm.attendance') }}" class="btn btn-secondary">Reset</a>
                                    </div>
                                </div>
                            </form>



                            @php
                                $selectedMonth = request('month', now()->format('m'));
                            @endphp
                            <div class="mb-3 text-end">
                                <a href="{{ route('hrm.download.rmattendance', ['month' => $selectedMonth]) }}"
                                    class="btn btn-success">
                                    Download Attendance Report
                                </a>
                            </div>

                            {{-- @php
                                $currentMonth = now()->format('m');
                            @endphp
                            <div class="mb-3 text-end">
                                <a href="{{ route('hrm.download.rmattendance', ['type' => 'monthly', 'month' => $currentMonth]) }}"
                                    class="btn btn-success">
                                    Download Current Month Report
                                </a>
                            </div> --}}


                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Attendance Status</th>
                                        <th>Check-in Time</th>
                                        <th>System Time</th>
                                        {{-- <th>Approval Status</th> --}}
                                        {{-- <th>Status</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($hrmanagers as $head)
                                        @forelse ($head->filteredAttendances as $key => $attendance)
                                            @php
                                                $checkIn = \Carbon\Carbon::parse($attendance->check_in_time);
                                                $cutoffTime = \Carbon\Carbon::parse($attendance->date . ' 12:01:00');
                                                $status = $checkIn->gt($cutoffTime)
                                                    ? 'Absent'
                                                    : $attendance->status ?? 'Present';
                                            @endphp
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d/M/Y') }}</td>
                                                <td>{{ $head->employee_id }}</td>
                                                <td>{{ $head->name }}</td>
                                                <td>
                                                    @if ($attendance->status === 'On Leave')
                                                        <span class="badge bg-info text-dark">On Leave</span>
                                                    @else
                                                        {{ $attendance->status }}
                                                    @endif
                                                </td>


                                                <td>
                                                    @if ($attendance->check_in_time)
                                                        {{ \Carbon\Carbon::parse($attendance->check_in_time)->format('h:i A') }}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($attendance->created_at)
                                                        {{ \Carbon\Carbon::parse($attendance->created_at)->format('H:i') }}
                                                    @else
                                                        ---
                                                    @endif
                                                </td>

                                                {{-- <td>{{ $attendance->manager_approval_status }}</td> --}}


                                                {{-- <td>
                                                    @if ($attendance->status === 'On Leave')
                                                        <span class="text-muted">Leave Approved</span>
                                                    @else
                                                        <a href="{{ route('attendance.approve', $attendance->id) }}"
                                                            class="btn btn-success">Present</a>
                                                        <a href="{{ route('attendance.absent', $attendance->id) }}"
                                                            class="btn btn-danger">Absent</a>
                                                    @endif
                                                </td> --}}





                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">No attendance found for
                                                    {{ $head->name }}</td>
                                            </tr>
                                        @endforelse
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No report managers Found</td>
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
