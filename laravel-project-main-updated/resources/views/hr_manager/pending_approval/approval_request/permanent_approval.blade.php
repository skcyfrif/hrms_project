@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
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
                                        <th>m Status</th>
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
                                            {{-- <td>{{ $req->employee->mstatus ?? 'N/A' }}</td> --}}
                                            <td>
                                                @if ($req->mstatus === 'mapprove')
                                                    <span class="badge bg-success fs-6 px-3 py-2">Approved</span>

                                                @elseif($req->mstatus === 'mreject')
                                                    <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>

                                                @else
                                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>

                                                @endif
                                            </td>
                                            <td>
                                                @if ($req->rmstatus === 'rmapprove')
                                                    <span class="badge bg-success fs-6 px-3 py-2">Approved</span>

                                                @elseif($req->rmstatus === 'rmreject')
                                                    <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>

                                                @else
                                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>

                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('hrm.mapprove.permanent', $req->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf

                                                    @if($req->mstatus === 'mpending')
                                                        <button type="submit" name="action" value="mapprove" class="btn btn-success btn-sm">Approve</button>
                                                        <!-- Trigger modal -->
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $req->id }}">
                                                            Reject
                                                        </button>
                                                    @elseif($req->mstatus === 'mapprove')
                                                        <!-- Trigger modal -->
                                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $req->id }}">
                                                            Reject
                                                        </button>
                                                    @elseif($req->mstatus === 'mreject')
                                                        <button type="submit" name="action" value="mapprove" class="btn btn-success btn-sm">Approve</button>
                                                    @endif
                                                </form>

                                                <!-- Modal -->
                                                <div class="modal fade" id="rejectModal{{ $req->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $req->id }}" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form method="POST" action="{{ route('hrm.mapprove.permanent', $req->id) }}">
                                                            @csrf
                                                            <input type="hidden" name="action" value="mreject">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="rejectModalLabel{{ $req->id }}">Reason for Rejection</h5>
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
