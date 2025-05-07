@extends('report_manager.report_manager_dashboard')
@section('report_manager')
    <div class="page-content">
        <h6 class="text-center">Leave Approval Of All Employees</h6>

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
                                        <th>name </th>
                                        <th>leave from</th>
                                        <th>leave to</th>
                                        <th>total days</th>
                                        <th>reason</th>
                                        {{-- <th>m Status</th> --}}
                                        <th>Rm Status</th>
                                        <th>file</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($approvals as $key => $leave)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            {{-- <td>{{ $leave->employee_id }}</td> --}}
                                            <td>{{ $leave->employeeleavestatusinrm->employee_id }}</td>
                                            <td>{{ $leave->name }}</td>
                                            <td>{{ $leave->leave_from }}</td>
                                            <td>{{ $leave->leave_to }}</td>
                                            <td>{{ $leave->total_days }}</td>
                                            <td>{{ $leave->reason }}</td>
                                            {{-- <td>
                                                @if ($leave->m_status === 'mapprove')
                                                    <span class="badge bg-success fs-6 px-3 py-2">Approved</span>

                                                @elseif($leave->m_status === 'mreject')
                                                    <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>
                                                @else
                                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>

                                                @endif
                                            </td> --}}
                                            <td>
                                                @if ($leave->rm_status === 'rmapprove')
                                                    <span class="badge bg-success fs-6 px-3 py-2">Approved</span>

                                                @elseif($leave->rm_status === 'rmreject')
                                                    <span class="badge bg-danger fs-6 px-3 py-2">Rejected</span>

                                                @else
                                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">Pending</span>

                                                @endif
                                            </td>
                                            <td>
                                                @if ($leave->upload)
                                                    <a href="{{ asset($leave->upload) }}" target="_blank"
                                                        class="btn btn-inverse-info">View/Download</a>
                                                @else
                                                    No file uploaded
                                                @endif
                                            </td>

                                            <td>
                                                @if ($leave->rm_status == 'rmapprove')
                                                    <!-- Show Reject button when leave is approved -->
                                                    <button class="btn btn-inverse-danger rejectBtn"
                                                        data-id="{{ $leave->id }}"
                                                        data-employee="{{ $leave->employee_id }}">
                                                        Reject
                                                    </button>
                                                @elseif($leave->rm_status == 'rmreject')
                                                    <!-- Show Approve button when leave is rejected -->
                                                    <a href="{{ route('rmapprove.leave', $leave->id) }}"
                                                        class="btn btn-inverse-success">
                                                        Approve
                                                    </a>
                                                @elseif($leave->rm_status == 'rmpending')
                                                    <!-- Show both Approve & Reject buttons when leave is pending -->
                                                    <a href="{{ route('rmapprove.leave', $leave->id) }}"
                                                        class="btn btn-inverse-success">
                                                        Approve
                                                    </a>
                                                    <button class="btn btn-inverse-danger rejectBtn"
                                                        data-id="{{ $leave->id }}"
                                                        data-employee="{{ $leave->employee_id }}">
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

    <div class="modal fade" id="rejectLeaveModal" tabindex="-1" aria-labelledby="rejectLeaveModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white">Reject Leave Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="rejectLeaveForm" method="POST" action="{{ route('rmreject.leave.submit') }}">
                        @csrf
                        <input type="hidden" name="leave_id" id="leave_id">
                        <input type="hidden" name="employee_id" id="employee_id">
                        <input type="hidden" name="rejected_by" value="{{ auth()->user()->id }}">
                        <input type="hidden" name="status" value="rmreject">

                        <!-- Rejection Reason Field -->
                        <div class="mb-3">
                            <label for="reason" class="form-label text-white">Rejection Reason</label>
                            <textarea class="form-control" id="reason" name="reason" required></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn btn-danger">Reject Leave</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".rejectBtn").forEach(button => {
                button.addEventListener("click", function() {
                    let leaveId = this.getAttribute("data-id");
                    let employeeId = this.getAttribute("data-employee");
                    document.getElementById("leave_id").value = leaveId;
                    document.getElementById("employee_id").value = employeeId;
                    var rejectModal = new bootstrap.Modal(document.getElementById(
                        "rejectLeaveModal"));
                    rejectModal.show();
                });
            });
        });
    </script>
@endsection
