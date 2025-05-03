@extends('admin.admin_dashboard')

@section('admin')
<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">All HR Heads</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">All HR Heads</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hrHeads as $key => $head)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $head->employee_id }}</td>
                                        <td>{{ $head->name }}</td>
                                        <td>{{ $head->email }}</td>
                                        <td>{{ $head->user_role }}</td>
                                        <td>
                                            <a href="{{ route('admin.hrhead.managers', $head->id) }}" class="btn btn-success">View Managers</a>
                                            {{-- <a href="{{ route('admin.hrhead.attendance', $head->id) }}" class="btn btn-success">View Attendance</a> --}}
                                            <a href="{{route('admin.hrhead.details' , $head->id)}}" class="btn btn-inverse-danger" style="background-color: #28a745; color: white; border: 1.5px solid #155724;"> View</a>
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
