@extends('admin.admin_dashboard')
@section('admin')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.hr_heads') }}">Back to HR Heads</a>
            </li>
            {{-- <li class="breadcrumb-item active" aria-current="page">
                Managers Created by {{ $hrHead->name }}
            </li> --}}
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Managers Created by {{ $hrHead->name }}</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Manager ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($managers as $key => $manager)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $manager->employee_id }}</td>
                                        <td>{{ $manager->name }}</td>
                                        <td>{{ $manager->email }}</td>
                                        <td>{{ $manager->user_role }}</td>
                                        <td>
                                            <a href="{{ route('admin.manager.employees', $manager->id) }}" class="btn btn-info">View Employees</a>
                                            <a href="{{route('admin.hrmanager.details' , $manager->id)}}" class="btn btn-inverse-danger" style="background-color: #28a745; color: white; border: 1.5px solid #155724;"> View</a>
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
