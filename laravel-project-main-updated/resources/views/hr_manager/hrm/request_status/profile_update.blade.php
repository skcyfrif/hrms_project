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
                                            <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d-m-Y') }}</td>

                                            <td>
                                                @php $status = strtolower($request->hr_status); @endphp

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
