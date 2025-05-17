@extends('hr_head.hr_head_dashboard')
@section('hr_head')
    <div class="page-content">


        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Claim Status of All Employees</h6>
                        <div class="table-responsive">
                            <form method="GET" action="{{ route('hr_head.hrm.employee.claim') }}" class="row mb-4">
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
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>claim date</th>
                                        <th>status</th>
                                    </tr>
                                </thead>
                                {{-- <tbody>
                                    @foreach ($employees as $key => $head)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $head->employee_id }}</td>
                                            <td>{{ $head->name }}</td>
                                            <td>{{ $head->email }}</td>
                                            <td>{{ $head->user_role }}</td>
                                            <td>
                                                @if ($head->claim)
                                                    {{ $head->claim->claim_date }}
                                                @else
                                                    - - -
                                                @endif
                                            </td>

                                            <td>
                                                @if ($head->claim)
                                                    @if ($head->claim->status === 'approve')
                                                        <span class="badge bg-success fs-6 px-3 py-2">Approved</span>
                                                    @elseif($head->claim->status === 'reject')
                                                        <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>
                                                    @else
                                                        <span
                                                            class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-info fs-6 px-3 py-2">No Claim Applied</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody> --}}

                                <tbody>
                                    @php $sl = 1; @endphp
                                    @forelse ($employees as $head)
                                        @if (!empty($head->claim) && $head->claim->count())
                                            @foreach ($head->claim as $claims)
                                                <tr>
                                                    <td>{{ $sl++ }}</td>
                                                    <td>{{ $head->employee_id }}</td>
                                                    <td>{{ $head->name }}</td>
                                                    <td>{{ $head->email }}</td>
                                                    <td>{{ $head->user_role }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($claims->claim_date)->format('d/m/Y') }}
                                                    </td>
                                                    <td>
                                                        @if ($claims->status === 'approve')
                                                            <span class="badge bg-success fs-6 px-3 py-2">Approved</span>
                                                        @elseif ($claims->status === 'reject')
                                                            <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>
                                                        @else
                                                            <span
                                                                class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>{{ $sl++ }}</td>
                                                <td>{{ $head->employee_id }}</td>
                                                <td>{{ $head->name }}</td>
                                                <td>{{ $head->email }}</td>
                                                <td>{{ $head->user_role }}</td>
                                                <td>- - -</td>
                                                <td><span class="badge bg-info fs-6 px-3 py-2">No Claim Applied</span></td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No claims found for the selected month
                                                and year.</td>
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
