



@extends('admin.admin_dashboard')
@section('admin')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb d-flex justify-content-between align-items-center">
            <li>
                <button onclick="window.history.back();" class="btn btn-primary">
                    ← Back To DashBoard
                </button>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Employees List
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{-- <h6 class="card-title">Employees Created by {{ $hrManager->name }}</h6> --}}
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Doj</th>
                                    <th>Work Location</th>
                                    <th>Created By</th>
                                    <th>Role</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hrm as $hrHead)
                                <tr>
                                    <td>{{ $hrHead->employee_id }}</td>
                                    <td>{{ $hrHead->name }}</td>
                                    <td>{{ $hrHead->doj }}</td>
                                    <td>{{ $hrHead->work_location }}</td>
                                    <td>{{ $hrHead->creator->name ?? 'N/A' }}</td>
                                    <td>{{ $hrHead->user_role }}</td>
                                    <td>{{ $hrHead->email }}</td>
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
