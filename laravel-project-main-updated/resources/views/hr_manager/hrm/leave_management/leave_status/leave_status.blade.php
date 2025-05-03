@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
        </ol>
    </nav>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Employee ID</th>
                                    <th>Leave From</th>
                                    <th>Leave To</th>
                                    <th>Total Days</th>
                                    <th>Reason</th>
                                    <th>Status</th>
                                    @if($approvals->contains('hr_status', 'hrreject'))
                                    <th>Rejection Reason</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($approvals as $key => $leave)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $leave->leavestatusofemployee->employee_id }}</td>
                                        <td>{{ $leave->leave_from }}</td>
                                        <td>{{ $leave->leave_to }}</td>
                                        <td>{{ $leave->total_days }}</td>
                                        <td>{{ $leave->reason }}</td>
                                        <td>
                                            @if ($leave->hr_status === 'hrapprove')
                                                <span class="badge bg-success fs-6 px-3 py-2">Approved</span>

                                            @elseif($leave->hr_status === 'hrreject')
                                                <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>

                                            @else
                                                <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>

                                            @endif
                                        </td>
                                        @if($approvals->contains('hr_status', 'hrreject'))
                                        <td>
                                            @if($leave->hr_status === 'hrreject' && $leave->latestLeaveRejectionReason)
                                                {{ $leave->latestLeaveRejectionReason->reason }}
                                            @else
                                                Not Available
                                            @endif
                                        </td>
                                        @endif
                                    </tr>
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

