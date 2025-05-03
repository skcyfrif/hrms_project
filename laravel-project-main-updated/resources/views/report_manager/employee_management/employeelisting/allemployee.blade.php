@extends('report_manager.report_manager_dashboard')
@section('report_manager')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <a href="#" class="btn btn-inverse-info">All Details of Employee</a>
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
            <th>Employee ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>user_role</th>
            <th>Designation</th>
          </tr>
        </thead>
        <tbody>
            @foreach($employees as $key => $employee)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $employee->employee_id }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->user_role }}</td>
                                    <td>{{ $employee->designation }}</td>
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
