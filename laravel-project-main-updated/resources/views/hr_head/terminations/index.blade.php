@extends('hr_head.hr_head_dashboard')

@section('hr_head')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('terminations.create') }}" class="btn btn-inverse-info">Add Termination</a>

            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Terminated Employees</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Short Reason</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($terminations as $key => $termination)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $termination->subu->employee_id ?? 'N/A' }}</td>
                                            <td>{{ $termination->subu->name ?? 'N/A' }}</td>
                                            <td>
                                                <button class="btn btn-inverse-info"
                                                    onclick="viewReason('{{ $termination->reason }}')">View</button>
                                            </td>
                                            <td>
                                                <a href="{{ route('terminations.letter', ['id' => $termination->id]) }}"
                                                    class="btn btn-inverse-danger">Send Termination Letter</a>
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

    <!-- Modal for Viewing Reason -->
    <div class="modal fade" id="reasonModal" tabindex="-1" aria-labelledby="reasonModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reasonModalLabel">Termination Reason</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalReasonText">
                    <!-- Reason will be displayed here -->
                </div>
            </div>
        </div>
    </div>
    <style>
        /* Ensures the modal background is always white */
        .modal-content {
            background-color: #ffffff !important;
            color: #000000 !important;
            border-radius: 8px;
            /* Optional: adds smooth corners */
        }
    </style>
    <script>
        // JavaScript for viewing termination reason
        function viewReason(reason) {
            document.getElementById('modalReasonText').innerText = reason;
            var reasonModal = new bootstrap.Modal(document.getElementById('reasonModal'));
            reasonModal.show();
        }
    </script>
@endsection
