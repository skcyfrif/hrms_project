@extends('employee.employee_dashboard')
@section('employee')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('add.leave') }}" class="btn btn-inverse-info">Apply New leave</a>
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
                                        <th>employee_id</th>
                                        <th>name</th>
                                        <th>leave from</th>
                                        <th>leave to</th>
                                        <th>Leave Type</th>
                                        <th>total days</th>
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
                                            <td>{{ $item->reason }}</td>
                                            <td>{{ $item->total_days }}</td>
                                            <td>
                                                @if ($item->m_status === 'mapprove')
                                                    <span class="text-success">Approved</span>
                                                @elseif ($item->m_status === 'mreject')
                                                    <span class="text-danger">Rejected</span>
                                                @elseif ($item->rm_status === 'rmapprove')
                                                    <span class="text-success">Approved</span>
                                                @elseif ($item->rm_status === 'rmreject')
                                                    <span class="text-danger">Rejected</span>
                                                @else
                                                    <a href="{{ route('edit.leave', $item->id) }}"
                                                        class="btn btn-inverse-warning">Edit</a>
                                                    <a href="{{ route('delete.leave', $item->id) }}"
                                                        class="btn btn-inverse-danger" id="delete">Delete</a>
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
