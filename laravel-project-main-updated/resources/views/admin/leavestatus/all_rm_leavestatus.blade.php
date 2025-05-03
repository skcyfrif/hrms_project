@extends('admin.admin_dashboard')

@section('admin')
<div class="page-content">


    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">LEAVE STATUS OF ALL REPORT MANAGERS</h6>

                    <!-- Show Error if Any -->
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Month Filter Form -->
                    @php
                        $currentMonth = now()->format('Y-m');
                        $minMonth = '2019-01'; // Start from January 2019
                    @endphp

                    <form method="GET" action="{{ route('admin.rmleaves') }}" class="mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="month">Select Month</label>
                                <input type="month" name="month" class="form-control"
                                       value="{{ request('month', $currentMonth) }}"
                                       min="{{ $minMonth }}" max="{{ $currentMonth }}">
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Display Selected Month Info -->
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

                                        <!-- Leave From Date -->
                                        <td>
                                            @if ($head->leave)
                                                {{ \Carbon\Carbon::parse($head->leave->leave_from)->format('d/m/Y') }}
                                            @else
                                                - - -
                                            @endif
                                        </td>

                                        <!-- Leave To Date -->
                                        <td>
                                            @if ($head->leave)
                                                {{ \Carbon\Carbon::parse($head->leave->leave_to)->format('d/m/Y') }}
                                            @else
                                                - - -
                                            @endif
                                        </td>

                                        <!-- Leave Status -->
                                        <td>
                                            @if ($head->leave)
                                                @if ($head->leave->m_status === 'mapprove')
                                                    <span class="badge bg-success fs-6 px-3 py-2">Approved</span>
                                                @elseif($head->leave->m_status === 'mreject')
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
