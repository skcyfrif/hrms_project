@extends('hr_head.hr_head_dashboard')
@section('hr_head')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        {{-- <h6 class="card-title">All Employee</h6> --}}
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>employee id</th>
                                        <th>name</th>
                                        <th>year</th>
                                        <th>total leave allowed</th>
                                        <th>total leave Till Yet</th>
                                        <th>total leave taken Till Yet</th>
                                        <th>current leave Till Yet</th>
                                        <th>current leave balance</th>
                                        <th>total unpaid leave</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employee->leaveBalances as $index => $data)
                                        @if ($data->year == date('Y'))
                                            <!-- Show only the current year record -->
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $employee->employee_id }}</td> <!-- Employee ID from Subu table -->
                                                <td>{{ $employee->name }}</td> <!-- Name from Subu table -->
                                                <td>{{ $data->year }}</td> <!-- Year from Leavebalance table -->
                                                <td>{{ $data->annual_leave_entitlement }}</td> <!-- Leave entitlement -->
                                                <td>{{ $totalleaveTillYet }}</td> <!-- Leave entitlement -->
                                                @php
                                                    $totalleavetakenTillYet = $totalleaveTakenPL + $totalleaveTakenSL;
                                                    $currentleaveTillYet = $totalleaveTillYet - $totalleavetakenTillYet;
                                                    $currentleavebalance =
                                                        $data->annual_leave_entitlement - $totalleavetakenTillYet;
                                                @endphp
                                                <td>{{ $totalleavetakenTillYet }}</td> <!-- Leave entitlement -->
                                                <td>{{ $currentleaveTillYet }}</td> <!-- Leave entitlement -->
                                                <td>{{ $currentleavebalance }}</td> <!-- Leave entitlement -->
                                                <td>{{ $totalleaveTakenLOP }}</td> <!-- Leave entitlement -->
                                            </tr>
                                        @endif
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
