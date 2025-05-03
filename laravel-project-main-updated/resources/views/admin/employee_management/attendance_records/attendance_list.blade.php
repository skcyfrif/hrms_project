@extends('admin.admin_dashboard')
@section('admin')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <a href="{{route('add.attendance')}}" class="btn btn-inverse-info">Add Attendance of Employee</a>
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
            {{-- <th>email</th> --}}
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($tests as $key => $item)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$item->employee_id}}</td>
                    <td>{{$item->name}}</td>
                    {{-- <td>{{$item->email}}</td> --}}
                    <td>
                        <a href="{{route('edit.attendance' , $item->id)}}" class="btn btn-inverse-warning"> Edit</a>
                        <a href="{{route('delete.attendance' , $item->id)}}" class="btn btn-inverse-danger" id="delete"> Delete</a>
                        <a href="{{route('view.attendance' , $item->id)}}" class="btn btn-inverse-danger" style="background-color: #28a745; color: white; border: 1.5px solid #155724;"> View</a>
                        {{-- <button style="background-color: #28a745; color: white; border: 7px solid #155724;">View</button> --}}

                        {{-- <a href="{{route('view.attendance' , $item->id)}}" class="btn btn-inverse-danger" id="delete"> View</a> --}}
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
