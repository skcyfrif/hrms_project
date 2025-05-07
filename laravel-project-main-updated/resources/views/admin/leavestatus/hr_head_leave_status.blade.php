@extends('admin.admin_dashboard')

@section('admin')
<div class="page-content">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Leave Status Of All HR Heads</h6>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @php
                        $currentYear = now()->year;
                    @endphp

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('admin.hr_headsleaves') }}" class="mb-4">
                        <div class="row">
                            <!-- Month Dropdown -->
                            <div class="col-md-3">
                                <label for="month">Select Month</label>
                                <select name="month" id="month" class="form-select">
                                    @foreach (range(1, 12) as $m)
                                        <option value="{{ $m }}"
                                            {{ $month == $m ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Year Dropdown -->
                            <div class="col-md-3">
                                <label for="year">Select Year</label>
                                <select name="year" id="year" class="form-select">
                                    @for ($y = 2019; $y <= $currentYear; $y++)
                                        <option value="{{ $y }}"
                                            {{ $year == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Display Filter Info -->
                    @if($selectedMonth)
                        <div class="alert alert-info">
                            Showing leave records for: <strong>{{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</strong>
                        </div>
                    @endif

                    <!-- Leave Table -->
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Leave From</th>
                                    <th>Leave To</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hrHeads as $key => $head)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $head->employee_id }}</td>
                                        <td>{{ $head->name }}</td>
                                        <td>{{ $head->email }}</td>
                                        <td>{{ $head->user_role }}</td>
                                        <td>{{ optional($head->leave)->leave_from ? \Carbon\Carbon::parse($head->leave->leave_from)->format('d/m/Y') : '- - -' }}</td>
                                        <td>{{ optional($head->leave)->leave_to ? \Carbon\Carbon::parse($head->leave->leave_to)->format('d/m/Y') : '- - -' }}</td>
                                        <td>
                                            @if ($head->leave)
                                                @if ($head->leave->admin_status === 'adminapprove')
                                                    <span class="badge bg-success fs-6 px-3 py-2">Approved</span>
                                                @elseif($head->leave->admin_status === 'adminreject')
                                                    <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>
                                                @endif
                                            @else
                                                <span class="badge bg-info fs-6 px-3 py-2">No Leave Applied</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                @if ($hrHeads->isEmpty())
                                    <tr>
                                        <td colspan="8" class="text-center">No leave records found for this month.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
