@extends('hr_head.hr_head_dashboard')

@section('hr_head')
<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Leave Status of All Employees</h6>

                    <form method="GET" action="{{ route('hrhead.hrm.employee.leave') }}" class="row mb-4">
                        <div class="col-md-3">
                            <label>HR Manager</label>
                            <select name="hr_manager_id" class="form-control" required>
                                <option value="">-- Select HR Manager --</option>
                                @foreach ($hrManagers as $manager)
                                    <option value="{{ $manager->id }}" {{ request('hr_manager_id') == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Month</label>
                            <select name="month" class="form-control" required>
                                <option value="">-- Select Month --</option>
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label>Year</label>
                            <select name="year" class="form-control" required>
                                <option value="">-- Select Year --</option>
                                @for ($year = 2019; $year <= now()->year; $year++)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-3 align-self-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Leave From</th>
                                    <th>Leave To</th>
                                    <th>Rm Status</th>
                                    <th>Manager Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employees as $key => $emp)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $emp->employee_id }}</td>
                                        <td>{{ $emp->name }}</td>
                                        <td>{{ $emp->email }}</td>
                                        <td>{{ $emp->leave?->leave_from ?? '- - -' }}</td>
                                        <td>{{ $emp->leave?->leave_to ?? '- - -' }}</td>
                                        <td>
                                            @if ($emp->leave)
                                                @if ($emp->leave->rm_status === 'rmapprove')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif ($emp->leave->rm_status === 'rmreject')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            @else
                                                <span class="badge bg-info">No Leave Applied</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($emp->leave)
                                                @if ($emp->leave->m_status === 'mapprove')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif ($emp->leave->m_status === 'mreject')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            @else
                                                <span class="badge bg-info">No Leave Applied</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No employee leave data found.</td>
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
