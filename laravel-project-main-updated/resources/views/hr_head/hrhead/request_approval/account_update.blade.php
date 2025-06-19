@extends('hr_head.hr_head_dashboard')
@section('hr_head')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Update Account Profile Approval</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center mb-4">Update Account Profile Approval Of All HR Manager</h5>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">

                                <thead>
                                    <tr>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Employee ID</th>
                                        <th>Name</th>
                                        <th>Requested Changes</th>
                                        <th>Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>


                                <tbody>
                                    @forelse ($requests as $index => $reques)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $reques->account->employee_id ?? '-' }}</td>
                                            <td>{{ $reques->account->name ?? '-' }}</td>
                                            <td>
                                                <ul>
                                                    @if ($reques->bank_name)
                                                        <li><strong>Bank_Name:</strong> {{ $reques->bank_name }}</li>
                                                    @endif
                                                    @if ($reques->branch_name)
                                                        <li><strong>branch_name:</strong> {{ $reques->branch_name }}</li>
                                                    @endif
                                                    @if ($reques->account_number)
                                                        <li><strong>account_number :</strong> {{ $reques->account_number }}
                                                        </li>
                                                    @endif
                                                    @if ($reques->ifsc_code)
                                                        <li><strong>ifsc_code :</strong>
                                                            {{ $reques->ifsc_code }}</li>
                                                    @endif

                                                </ul>
                                            </td>
                                            <td>
                                                @php $status = strtolower($reques->hr_status); @endphp
                                                @if ($status === 'hrpending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($status === 'hrapproved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($status === 'hrrejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-secondary">Unknown</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($status === 'hrpending')
                                                    <form action="{{ route('hr.accountrequest.approve', $reques->id) }}"
                                                        method="POST" style="display:inline-block">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm btn-success">Approve</button>
                                                    </form>
                                                    <form action="{{ route('hr.accountrequest.reject', $reques->id) }}"
                                                        method="POST" style="display:inline-block">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                                                    </form>
                                                @else
                                                    <span class="text-muted">No Action</span>
                                                @endif
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No pending requests</td>
                                        </tr>
                                    @endforelse
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
