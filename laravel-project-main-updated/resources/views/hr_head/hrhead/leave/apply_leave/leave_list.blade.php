@extends('hr_head.hr_head_dashboard')
@section('hr_head')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('add.hrheadleave') }}" class="btn btn-inverse-info">Apply New leave</a>
                {{-- <a href="#" class="btn btn-inverse-info">Apply leave</a> --}}
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Employee</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>employee_id</th>
                                        <th>name</th>
                                        <th>leave from</th>
                                        <th>leave to</th>
                                        <th>total days</th>
                                        <th>Leave Type</th>
                                        <th>attached file</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tests as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $employye->employee_id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->leave_from }}</td>
                                            <td>{{ $item->leave_to }}</td>
                                            <td>{{ $item->total_days }}</td>
                                            <td>{{ $item->reason }}</td>
                                            <td>
                                                @if ($item->upload)
                                                    <a href="{{ asset($item->upload) }}" target="_blank"
                                                        class="btn btn-inverse-info">View/Download</a>
                                                @else
                                                    No File uploaded
                                                @endif
                                            </td>
                                            <td>
                                                @if ($item->admin_status === 'adminapprove')
                                                    <span class="text-success">Approved</span>
                                                @elseif ($item->admin_status === 'adminreject')
                                                    <span class="text-danger">Rejected</span>
                                                @else
                                                    <a href="{{ route('edit.hrheadleave', $item->id) }}" class="btn btn-inverse-warning">Edit</a>
                                                    <a href="{{ route('delete.hrheadleave', $item->id) }}" class="btn btn-inverse-danger" id="delete">Delete</a>
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
