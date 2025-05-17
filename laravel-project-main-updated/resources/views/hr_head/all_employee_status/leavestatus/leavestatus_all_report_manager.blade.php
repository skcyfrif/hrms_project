@extends('hr_head.hr_head_dashboard')

@section('hr_head')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Leave Status of All Report Managers</h6>

                        <form method="GET" action="{{ route('hrhead.hrm.rm.leave') }}" class="row mb-4">
                            <div class="col-md-3">
                                <label>HR Manager</label>
                                <select name="hr_manager_id" class="form-control" required>
                                    <option value="">-- Select HR Manager --</option>
                                    @foreach ($hrManagers as $manager)
                                        <option value="{{ $manager->id }}"
                                            {{ request('hr_manager_id') == $manager->id ? 'selected' : '' }}>
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
                                        <option value="{{ $month }}"
                                            {{ request('month') == $month ? 'selected' : '' }}>
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
                                        <option value="{{ $year }}"
                                            {{ request('year') == $year ? 'selected' : '' }}>
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
                                        <th>role</th>
                                        <th>Leave From</th>
                                        <th>Leave To</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($reportManagers as $key => $rm)
                                        @foreach ($rm->leave as $leave)
                                            <!-- Loop over all leaves -->
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $rm->employee_id }}</td>
                                                <td>{{ $rm->name }}</td>
                                                <td>{{ $rm->email }}</td>
                                                <td>{{ $rm->user_role }}</td>
                                                <td>{{ optional($leave)->leave_from ? \Carbon\Carbon::parse($leave->leave_from)->format('d/m/Y') : '- - -' }}
                                                </td>
                                                <td>{{ optional($leave)->leave_to ? \Carbon\Carbon::parse($leave->leave_to)->format('d/m/Y') : '- - -' }}
                                                </td>
                                                <td>
                                                    @if ($leave->m_status === 'mapprove')
                                                        <span class="badge bg-success fs-6 px-3 py-2">Approved</span>
                                                    @elseif($leave->m_status === 'mreject')
                                                        <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
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
