@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <a href="{{route('add.hrmanagerleave')}}" class="btn btn-inverse-info">Apply leave</a>
            {{-- <a href="#" class="btn btn-inverse-info">Apply leave</a> --}}
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
            <th>total days</th>
            <th>reason</th>
            <th>attached file</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($tests as $key => $item)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$employye->employee_id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->total_days}}</td>
                    <td>{{$item->reason}}</td>
                    {{-- <td>{{$item->upload}}</td> --}}
                    <td>
                        @if($item->upload)
                            <a href="{{ asset($item->upload) }}" target="_blank" class="btn btn-inverse-info">View/Download</a>
                        @else
                            No File uploaded
                        @endif
                    </td>
                    <td>
                        <a href="{{route('edit.hrmanagerleave' , $item->id)}}" class="btn btn-inverse-warning"> Edit</a>
                        <a href="{{route('delete.hrmanagerleave' , $item->id)}}" class="btn btn-inverse-danger" id="delete"> Delete</a>
                    </td>
                </tr>
            @endforeach
            {{-- <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                    <a href="{{route('edit.hrmanagerleave' , $item->id)}}" class="btn btn-inverse-warning"> Edit</a>
                    <a href="{{route('delete.hrmanagerleave' , $item->id)}}" class="btn btn-inverse-danger" id="delete"> Delete</a>
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
