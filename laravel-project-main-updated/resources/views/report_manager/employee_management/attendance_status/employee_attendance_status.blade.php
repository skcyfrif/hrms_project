@extends('report_manager.report_manager_dashboard')

@section('report_manager')
    <div class="page-content">
        <h6 class="card-title">Attendance Status Of My Employees ({{ now()->year }})</h6>

        <form method="GET" action="{{ route('rm.employee.attendance') }}" class="mb-4">
            <div class="row g-3 align-items-center">
                <div class="col-auto">
                    <label for="month" class="form-label">Filter by Month:</label>
                </div>
                <div class="col-3">
                    <select name="month" id="month" class="form-select">
                        <option value="">-- Select Month --</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary">Filter</button>
                    <a href="{{ route('rm.employee.attendance') }}" class="btn btn-secondary">Reset</a>
                </div>
            </div>
        </form>

        {{-- Download form --}}
        <div class="mb-3 text-end">
            <form method="GET" action="{{ route('rm.download.employeeattendance') }}" style="display:inline">
                <input type="hidden" name="month" value="{{ $month }}">
                <button class="btn btn-success" {{ $month ? '' : 'disabled' }}>
                    Download Current Month Report
                </button>
            </form>
        </div>

        <div class="table-responsive">
            <table id="dataTableExample" class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Check-in</th>
                        <th>System Time</th>
                        {{-- <th>Approval Status</th>
                        <th>Status</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $emp)
                        @foreach ($emp->filteredAttendances as $a)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($a->date)->format('d/M/Y') }}</td>
                                <td>{{ $emp->employee_id }}</td>
                                <td>{{ $emp->name }}</td>
                                <td>{{ $a->status === 'On Leave' ? 'On Leave' : $a->status ?? 'Present' }}</td>
                                <td>{{ $a->check_in_time ? \Carbon\Carbon::parse($a->check_in_time)->format('h:i A') : '---' }}
                                </td>
                                <td>{{ $a->created_at ? \Carbon\Carbon::parse($a->created_at)->format('H:i') : '---' }}
                                </td>
                                {{-- <td>{{ $a->rm_approval_status }}</td>
                                <td>
                                    @if ($a->status === 'On Leave')
                                        <span class="text-muted">Leave Approved</span>
                                    @else
                                        <a href="{{ route('attendanceinrm.approve', $a->id) }}"
                                            class="btn btn-success">Present</a>
                                        <a href="{{ route('attendanceinrm.absent', $a->id) }}"
                                            class="btn btn-danger">Absent</a>
                                    @endif
                                </td> --}}

                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No employees found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
