@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
    <div class="page-content">
        <h6 class="text-center"> profile status </h6>


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
                                        <th>Name</th>
                                        <th>Requested Changes</th>
                                        <th>Apply date</th>
                                        <th>Status</th>

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
                                            <td>{{ \Carbon\Carbon::parse($reques->created_at)->format('d-m-Y') }}</td>

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


                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">No update requests found.</td>

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
