@extends('hr_head.hr_head_dashboard')
@section('hr_head')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            {{-- <a href="#" class="btn btn-inverse-info">Add Attendance of Employee</a> --}}
            <a href="{{route('add.hrheadattendance')}}" class="btn btn-inverse-info">Add Attendance of Hr Head</a>
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
            <th>date</th>
            <th>check in time</th>
            <th>status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($atens as $key => $item)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$employyye->employee_id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{ \Carbon\Carbon::parse($item->date)->format('d/M/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->check_in_time)->format('h:i A') ?? '---' }}</td>
                    <td>{{$item->status}}</td>
                    <td>
                        {{-- <a href="{{route('edit.employeeattendance' , $item->id)}}" class="btn btn-inverse-warning"> Edit</a> --}}
                        <a href="{{route('delete.hrheadattendance' , $item->id)}}" class="btn btn-inverse-danger" id="delete"> Delete</a>
                        {{-- <a href="{{route('view.employeeattendance' , $item->id)}}" class="btn btn-inverse-danger" style="background-color: #28a745; color: white; border: 1.5px solid #155724;"> View</a>
                        <a href="{{route('view.employeeattendance' , $item->id)}}" class="btn btn-inverse-danger" id="delete"> View</a> --}}
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
