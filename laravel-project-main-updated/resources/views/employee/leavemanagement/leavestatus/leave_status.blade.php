@extends('employee.employee_dashboard')
@section('employee')
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
                                        <th>RM Status</th>
                                        @if($approvals->contains('rm_status', 'rmreject'))
                                        <th>RM Reject Reason Status</th>
                                        @endif
                                        <th>Manager Status</th>
                                        @if($approvals->contains('m_status', 'mreject'))
                                        <th>manager Reject Reason Status</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($approvals as $key => $leave)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $leave->leavestatusofemployee->employee_id }}</td>
                                            <td>{{ $leave->leave_from }}</td>
                                            <td>{{ $leave->leave_to }}</td>
                                            <td>{{ $leave->total_days }}</td>
                                            <td>{{ $leave->reason }}</td>
                                            <td>
                                                @if ($leave->rm_status === 'rmapprove')
                                                   <span class="badge bg-success fs-6 px-3 py-2">Approved</span>


                                                @elseif($leave->rm_status === 'rmreject')
                                                   <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>

                                                @else
                                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>

                                                @endif
                                            </td>
                                            @if ($approvals->contains('rm_status', 'rmreject'))
                                                <td>
                                                    @if ($leave->rm_status === 'rmreject' && $leave->latestLeaveRejectionReason)
                                                        {{ $leave->latestLeaveRejectionReason->reason }}
                                                    @else
                                                        Not Available
                                                    @endif
                                                </td>
                                            @endif
                                            <td>
                                                @if ($leave->m_status === 'mapprove')
                                                   <span class="badge bg-success fs-6 px-3 py-2">Approved</span>
                                                @elseif($leave->m_status === 'mreject')
                                                   <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>
                                                @endif
                                            </td>

                                            @if ($approvals->contains('m_status', 'mreject'))
                                                <td>
                                                    @if ($leave->m_status === 'mreject' && $leave->latestLeaveRejectionReason)
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
