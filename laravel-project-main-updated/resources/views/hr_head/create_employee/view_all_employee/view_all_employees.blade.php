@extends('hr_head.hr_head_dashboard')
@section('hr_head')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('hrmanager.list') }}">Back to Managers</a></li>
            <li class="breadcrumb-item active" aria-current="page">All Employees of {{ $manager->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">All Employees of {{ $manager->name }}</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>action</th>
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
                                            <a href="{{route('offer.employee' , $employee->id)}}" target="_blank" class="btn btn-inverse-danger" style="background-color: #28a745; color: white; border: 1.5px solid #155724;"> Appointment Letter</a>
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
