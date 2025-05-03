@extends('admin.admin_dashboard')

@section('admin')
<div class="page-content">
   

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Claim Status Of All HR managers</h6>
                    <div class="table-responsive">
                        <form method="GET" action="{{ route('admin.hrmclaim') }}" class="mb-3">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="month" class="form-label">Month</label>
                                    <select class="form-select" id="month" name="month">
                                        <option value="">-- Select Month --</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ sprintf('%02d', $i) }}" {{ $month == sprintf('%02d', $i) ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $i, 10)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="year" class="form-label">Year</label>
                                    <select class="form-select" id="year" name="year">
                                        <option value="">-- Select Year --</option>
                                        @for ($i = date('Y'); $i >= 2020; $i--)
                                            <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                                    <a href="{{ route('admin.hrmclaim') }}" class="btn btn-secondary">Reset</a>
                                </div>
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
                                    <th>claim_date</th>
                                    <th>status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($hrHeads as $key => $head)
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
                                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>
                                                @endif
                                            @else
                                                <span class="badge bg-info fs-6 px-3 py-2">No Leave Applied</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No claims found for the selected month and year.</td>
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
