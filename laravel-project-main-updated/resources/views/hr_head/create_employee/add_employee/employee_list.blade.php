@extends('hr_head.hr_head_dashboard')
@section('hr_head')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <a href="{{route('add.hrmanager')}}" class="btn btn-inverse-info">Add Hr Manager</a>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
    <h6 class="card-title">All HR Manager</h6>
    <div class="table-responsive">
      <table id="dataTableExample" class="table">
        <thead>
          <tr>
            <th>Sl</th>
            <th>employee_id</th>
            <th>name</th>
            <th>email</th>
            <th>role</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($managers as $key => $item)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$item->employee_id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->user_role}}</td>
                    <td>
                        <a href="{{route('edit.hrmanager' , $item->id)}}" class="btn btn-inverse-warning"> Edit</a>
                        {{-- <a href="{{route('delete.hrmanager' , $item->id)}}" class="btn btn-inverse-danger" id="delete"> Delete</a> --}}
                        <a href="{{route('view.employees' , $item->id)}}" class="btn btn-inverse-danger" style="background-color: #28a745; color: white; border: 1.5px solid #155724;"> View</a>
                        <a href="{{route('offer.employee' , $item->id)}}" target="_blank" class="btn btn-inverse-danger" style="background-color: #28a745; color: white; border: 1.5px solid #155724;"> Appointment Letter</a>
                        <a href="{{ route('manager.employees', $item->id) }}" class="btn btn-inverse-danger" style="background-color: #28a745; color: white; border: 1.5px solid #155724;">View All Employees</a>
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
