@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            {{-- <a href="{{route('add.salaryapproval')}}" class="btn btn-inverse-info">Add Salary Details of Employee</a> --}}
            <a href="#" class="btn btn-inverse-info">Add Salary Details of Employee</a>

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
            <th>employee_id </th>
            <th>name </th>
            <th>days in month</th>
            <th>no. of working days in current month</th>
            <th>no. of days present</th>
            <th>total holidays</th>
            <th>total leave</th>
            <th>paid leave</th>
            <th>unpaid leave</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach($employees as $key => $employee)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $employee->employee_id }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->total_days }}</td>
                    <td>{{ $employee->working_days }}</td>
                    <td>{{ $employee->present_days }}</td>
                    <td>{{ $employee->total_holidays }}</td>
                    <td>{{ $employee->total_leaves }}</td>
                    <td>{{ $employee->paid_leave }}</td>
                    <td>{{ $employee->unpaid_leave }}</td>
                    <td>
                        <a href="#" class="btn btn-inverse-info">View</a>
                        <a href="#" class="btn btn-inverse-warning">Edit</a>
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
