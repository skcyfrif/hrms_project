@extends('hr_head.hr_head_dashboard')
@section('hr_head')
    <div class="page-content">

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Leave Status of All HR Managers</h6>
                        <div class="table-responsive">
                            <form method="GET" action="{{ route('hr_head.hr_managersleaves') }}" class="row mb-4">
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

                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>leave from</th>
                                        <th>leave to</th>
                                        <th>Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hrHeads as $key => $head)
                                        @foreach ($head->leave as $leave)
                                            <!-- Loop over all leaves -->
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $head->employee_id }}</td>
                                                <td>{{ $head->name }}</td>
                                                <td>{{ $head->email }}</td>
                                                <td>{{ $head->user_role }}</td>
                                                <td>{{ optional($leave)->leave_from ? \Carbon\Carbon::parse($leave->leave_from)->format('d/m/Y') : '- - -' }}
                                                </td>
                                                <td>{{ optional($leave)->leave_to ? \Carbon\Carbon::parse($leave->leave_to)->format('d/m/Y') : '- - -' }}
                                                </td>
                                                <td>
                                                    @if ($leave->hr_status === 'hrapprove')
                                                        <span class="badge bg-success fs-6 px-3 py-2">Approved</span>
                                                    @elseif($leave->hr_status === 'hrreject')
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
