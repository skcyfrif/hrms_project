@extends('admin.admin_dashboard')
@section('admin')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <button onclick="window.history.back();" class="btn btn-secondary">
                    Back to HR Managers
                </button>
            </li>

            {{-- <li class="breadcrumb-item active" aria-current="page">
                Employees Created by {{ $hrManager->name }}
            </li> --}}
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Employees Created by {{ $hrManager->name }}</h6>
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
                                @foreach ($employees as $key => $employee)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $employee->employee_id }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->user_role }}</td>
                                        <td>
                                            <a href="{{route('admin.employee.details' , $employee->id)}}" class="btn btn-inverse-danger" style="background-color: #28a745; color: white; border: 1.5px solid #155724;"> View</a>
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
