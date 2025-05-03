@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <a href="{{route('add.employee')}}" class="btn btn-inverse-info">Add Employee Details</a>
            {{-- <a href="#" class="btn btn-inverse-info">Add Employee Details</a> --}}
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
            <th>employee_id </th>
            <th>name</th>
            <th>email</th>
            <th>Role</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($sams as $key => $item)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$item->employee_id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->user_role}}</td>
                    <td>
                        <a href="{{route('edit.employee' , $item->id)}}" class="btn btn-inverse-warning"> Edit</a>
                        <a href="{{route('delete.employee' , $item->id)}}" class="btn btn-inverse-danger" id="delete"> Delete</a>
                        <a href="{{route('view.employee' , $item->id)}}" class="btn btn-inverse-danger" style="background-color: #28a745; color: white; border: 1.5px solid #155724;"> View</a>
                        {{-- <a href="{{route('offer.employee' , $item->id)}}" class="btn btn-inverse-danger" style="background-color: #28a745; color: white; border: 1.5px solid #155724;"> OfferLetter</a> --}}

                     </td>

                </tr>
            @endforeach
                {{-- <tr>
                    <td>sl</td>
                    <td>employee_id</td>
                    <td>name</td>

                    <td>
                        <a href="#" class="btn btn-inverse-warning"> Edit</a>
                        <a href="#" class="btn btn-inverse-danger" id="delete"> Delete</a>

                    </td>

                </tr> --}}
        </tbody>
      </table>
    </div>
  </div>
</div>
        </div>
    </div>

</div>
@endsection
