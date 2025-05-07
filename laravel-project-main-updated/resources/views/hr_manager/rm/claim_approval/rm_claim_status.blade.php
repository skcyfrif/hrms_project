@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')


<div class="page-content">
    <h6 class="text-center">Report Managers Claim Approval</h6>
    <nav class="page-breadcrumb">
        <ol class="breadcrumb"></ol>
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
                                    <th>Name</th>
                                    <th>claim date</th>
                                    <th>Claim Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($claims as $key => $claim)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $claim->employeeclaimstatusinhrm->employee_id }}</td>
                                        <td>{{ $claim->name }}</td>
                                        <td>{{ $claim->claim_date }}</td>
                                        <td>
                                            @if ($claim->status === 'approve')
                                                <span class="badge bg-success fs-6 px-3 py-2">Approved</span>
                                            @elseif($claim->status === 'reject')
                                                <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>
                                            @else
                                                <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>
                                            @endif
                                        </td>



                                        <td>
                                            @if($claim->status == 'approve')
                                                <!-- Show Reject button when claim is approved -->
                                                <button class="btn btn-inverse-danger rejectBtn"
                                                        data-id="{{ $claim->id }}"
                                                        data-employee="{{ $claim->employee_id }}">
                                                    Reject
                                                </button>
                                            @elseif($claim->status == 'reject')
                                                <!-- Show Approve button when claim is rejected -->
                                                <a href="{{ route('approve.claim', $claim->id) }}"
                                                   class="btn btn-inverse-success">
                                                    Approve
                                                </a>
                                            @elseif($claim->status == 'pending')
                                                <!-- Show both Approve & Reject buttons when claim is pending -->
                                                <a href="{{ route('approve.claim', $claim->id) }}"
                                                   class="btn btn-inverse-success">
                                                    Approve
                                                </a>
                                                <button class="btn btn-inverse-danger rejectBtn"
                                                        data-id="{{ $claim->id }}"
                                                        data-employee="{{ $claim->employee_id }}">
                                                    Reject
                                                </button>
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

<!-- Reject Claim Modal -->
<div class="modal fade" id="rejectClaimModal" tabindex="-1" aria-labelledby="rejectClaimModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white">Reject Claim Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="rejectClaimForm" method="POST" action="{{ route('reject.claim.submit') }}">
                    @csrf
                    <input type="hidden" name="claim_id" id="claim_id">
                    <input type="hidden" name="employee_id" id="employee_id">
                    <input type="hidden" name="rejected_by" value="{{ auth()->user()->id }}">
                    <input type="hidden" name="status" value="reject">

                    <div class="mb-3">
                        <label for="reason" class="form-label text-white">Rejection Reason</label>
                        <textarea class="form-control" id="reason" name="reason" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-danger">Reject Claim</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".rejectBtn").forEach(button => {
            button.addEventListener("click", function () {
                let claimId = this.getAttribute("data-id");
                let employeeId = this.getAttribute("data-employee");
                document.getElementById("claim_id").value = claimId;
                document.getElementById("employee_id").value = employeeId;

                var rejectModal = new bootstrap.Modal(document.getElementById("rejectClaimModal"));
                rejectModal.show();
            });
        });
    });
</script>

@endsection
