@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Update Profile Approval</li>
            </ol>
        </nav>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h5 class="text-center mb-4">Update Profile Approval Of All Reporting Manager</h5>

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
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
                                    @forelse ($requests as $index => $request)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $request->employee->employee_id ?? '-' }}</td>
                                            <td>{{ $request->employee->name ?? '-' }}</td>
                                            <td>
                                                <ul>
                                                    @if ($request->name)
                                                        <li><strong>Name:</strong> {{ $request->name }}</li>
                                                    @endif
                                                    @if ($request->email)
                                                        <li><strong>Email:</strong> {{ $request->email }}</li>
                                                    @endif
                                                    @if ($request->phone_number)
                                                        <li><strong>Phone Number:</strong> {{ $request->phone_number }}</li>
                                                    @endif
                                                    @if ($request->current_address_line1)
                                                        <li><strong>Address Line 1:</strong>
                                                            {{ $request->current_address_line1 }}</li>
                                                    @endif
                                                    @if ($request->current_address_line2)
                                                        <li><strong>Address Line 2:</strong>
                                                            {{ $request->current_address_line2 }}</li>
                                                    @endif
                                                    @if ($request->current_city)
                                                        <li><strong>City:</strong> {{ $request->current_city }}</li>
                                                    @endif
                                                    @if ($request->current_state)
                                                        <li><strong>State:</strong> {{ $request->current_state }}</li>
                                                    @endif
                                                    @if ($request->current_district)
                                                        <li><strong>District:</strong> {{ $request->current_district }}
                                                        </li>
                                                    @endif
                                                    @if ($request->current_pin)
                                                        <li><strong>PIN:</strong> {{ $request->current_pin }}</li>
                                                    @endif
                                                </ul>
                                            </td>
                                            <td>
                                                @php $status = strtolower($request->m_status); @endphp
                                                @if ($status === 'mpending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($status === 'mapproved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($status === 'mrejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @else
                                                    <span class="badge bg-secondary">Unknown</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if ($status === 'mpending')
                                                    <form action="{{ route('hrm.profile.approve', $request->id) }}"
                                                        method="POST" style="display:inline-block">
                                                        @csrf
                                                        <button type="submit"
                                                            class="btn btn-sm btn-success">Approve</button>
                                                    </form>
                                                    <form action="{{ route('hrm.profile.reject', $request->id) }}"
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
