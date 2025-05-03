@extends('report_manager.report_manager_dashboard')
@section('report_manager')
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
                                        <th>Nmae</th>
                                        <th>Claim Date</th>
                                        <th>Status</th>
                                        @if ($approvals->contains('status', 'reject'))
                                            <th>Rejection Reason</th>
                                        @endif

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($approvals as $key => $leave)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $leave->claimstatusofemployee->employee_id }}</td>
                                            <td>{{ $leave->name }}</td>
                                            <td>{{ $leave->claim_date }}</td>
                                            <td>
                                                @if ($leave->status === 'approve')
                                                    <span class="badge bg-success fs-6 px-3 py-2">Approved</span>
                                                @elseif($leave->status === 'reject')
                                                    <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>
                                                @endif
                                            </td>
                                            @if ($approvals->contains('status', 'reject'))
                                                <td>
                                                    @if ($leave->status === 'reject' && $leave->latestRejectionReason)
                                                        {{ $leave->latestRejectionReason->reason }}
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
