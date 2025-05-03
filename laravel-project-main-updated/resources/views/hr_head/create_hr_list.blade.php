@extends('admin.admin_dashboard')
@section('admin')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <a href="{{route('add.hr')}}" class="btn btn-inverse-info">Add HR</a>
            {{-- <a href="#" class="btn btn-inverse-info">Add HR manager</a> --}}
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
            <th>hr_id</th>
            <th>name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($hrs as $key => $item)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$item->hr_id}}</td>
                    <td>{{$item->name}}</td>
                    <td>
                        <a href="{{route('edit.hr' , $item->id)}}" class="btn btn-inverse-warning"> Edit</a>
                        <a href="{{route('delete.hr' , $item->id)}}" class="btn btn-inverse-danger" id="delete"> Delete</a>
                    </td>

                </tr>
            @endforeach

                {{-- <tr>
                    <td></td>
                    <td>hr_id</td>
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
