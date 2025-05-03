@extends('hr_head.hr_head_dashboard')
@section('hr_head')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <a href="{{route('view.subu')}}" class="btn btn-inverse-info">view page</a>
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
            <th>photo</th>
          </tr>
        </thead>
        <tbody>
            {{-- @foreach ($tests as $key => $item)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$item->employee_id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>


                </tr>
            @endforeach --}}

        </tbody>
      </table>
    </div>
  </div>
</div>
        </div>
    </div>

</div>
@endsection
