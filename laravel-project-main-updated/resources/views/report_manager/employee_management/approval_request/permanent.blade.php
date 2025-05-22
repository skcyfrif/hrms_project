@extends('report_manager.report_manager_dashboard')
@section('report_manager')
    <div class="page-content">
        <h6 class="text-center">Make Permanent</h6>

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
                                        <th>employee id </th>
                                        <th>name</th>
                                        <th>designation</th>
                                        {{-- <th>m Status</th> --}}
                                        <th>Rm Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($requests as $index => $req)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $req->employee->employee_id ?? 'N/A' }}</td>
                                            <td>{{ $req->employee->name ?? 'N/A' }}</td>
                                            <td>{{ $req->employee->designation ?? 'N/A' }}</td>
                                            {{-- <td>
                                                @if ($req->mstatus === 'mapprove')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($req->mstatus === 'mreject')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </td> --}}
                                            <td>
                                                @if ($req->rmstatus === 'rmapprove')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($req->rmstatus === 'rmreject')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @endif
                                            </td>
                                            {{-- <td>
                                                <form action="{{ route('rm.rmapprove.permanent', $req->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf

                                                    @if ($req->rmstatus === 'rmpending')
                                                        <button type="submit" name="action" value="rmapprove" class="btn btn-success btn-sm">Approve</button>
                                                        <!-- Modal trigger for reject -->
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rmRejectModal{{ $req->id }}">
                                                            Reject
                                                        </button>
                                                    @elseif ($req->rmstatus === 'rmapprove')
                                                        <!-- Allow revert to reject -->
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rmRejectModal{{ $req->id }}">
                                                            Reject
                                                        </button>
                                                    @elseif ($req->rmstatus === 'rmreject')
                                                        <button type="submit" name="action" value="rmapprove" class="btn btn-success btn-sm">Approve</button>
                                                    @endif
                                                </form>

                                                <!-- Reject Modal -->
                                                <div class="modal fade" id="rmRejectModal{{ $req->id }}" tabindex="-1" aria-labelledby="rmRejectModalLabel{{ $req->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="POST" action="{{ route('rm.rmapprove.permanent', $req->id) }}">
                                                            @csrf
                                                            <input type="hidden" name="action" value="rmreject">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="rmRejectModalLabel{{ $req->id }}">Reason for Rejection</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <textarea name="rejection_reason" class="form-control" rows="4" required placeholder="Enter reason..."></textarea>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-danger">Submit Rejection</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td> --}}




                                            <td>
                                                <form action="{{ route('rm.rmapprove.permanent', $req->id) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf

                                                    @if ($req->rmstatus === 'rmpending')
                                                        <button type="submit" name="action" value="rmapprove"
                                                            class="btn btn-success btn-sm">Approve</button>

                                                        <!-- Trigger modal -->
                                                        <button type="button" class="btn btn-danger btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#rejectModal{{ $req->id }}">
                                                            Reject
                                                        </button>
                                                    @elseif ($req->rmstatus === 'rmapprove')
                                                        <span class="text-success fw-bold">Approved</span>
                                                    @elseif ($req->rmstatus === 'rmreject')
                                                        <span class="text-danger fw-bold">Rejected</span>
                                                    @endif
                                                </form>

                                                <!-- Modal only if pending -->
                                                @if ($req->rmstatus === 'rmpending')
                                                    <div class="modal fade" id="rejectModal{{ $req->id }}"
                                                        tabindex="-1" aria-labelledby="rejectModalLabel{{ $req->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="POST"
                                                                action="{{ route('rm.rmapprove.permanent', $req->id) }}">
                                                                @csrf
                                                                <input type="hidden" name="action" value="mreject">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="rejectModalLabel{{ $req->id }}">Reason
                                                                            for Rejection</h5>
                                                                        <button type="button" class="btn-close"
                                                                            data-bs-dismiss="modal"
                                                                            aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <textarea name="rejection_reason" class="form-control" rows="4" required placeholder="Enter reason..."></textarea>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit" class="btn btn-danger">Submit
                                                                            Rejection</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                @endif
                                            </td>



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
