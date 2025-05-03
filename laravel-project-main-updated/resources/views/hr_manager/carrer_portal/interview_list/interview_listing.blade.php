@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            {{-- <a href="{{route('add.employee')}}" class="btn btn-inverse-info">Add Employee Details</a> --}}
            {{-- <a href="#" class="btn btn-inverse-info">Add Employee Details</a> --}}
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
<div class="card">
  <div class="card-body">
    <h6 class="card-title">All Candidates</h6>
    <div class="table-responsive">
      <table id="dataTableExample" class="table">
        <thead>
          <tr>
            <th>Sl</th>
            <th>name</th>
            <th>email</th>
            <th>mobile</th>
            <th>applied_for</th>
            <th>applied_date</th>
            <th>resume</th>
            <th>status</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($tests as $key => $item)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->email}}</td>
                <td>{{$item->mobile}}</td>
                <td>{{$item->applied_for}}</td>
                <td>{{$item->applied_date}}</td>
                <td>
                    @if($item->resume)
                        <a href="{{ asset($item->resume) }}" target="_blank" class="btn btn-inverse-info">View/Download</a>
                    @else
                        No Resume
                    @endif
                </td>

                <td>
                    @php
                        switch ($item->status) {
                            case '1':
                                echo 'Unschedule Pending';
                                break;
                            case '2':
                                echo 'Scheduled';
                                break;
                            case '3':
                                echo 'Shortlist';
                                break;
                            case '4':
                                echo 'Hold';
                                break;
                        }
                    @endphp
                </td>

                    <td>
                        <a href="{{ route('schedule.interview' , $item->id) }}" class="btn btn-success">Scheduled Interview</a>
                        {{-- <a href="{{route('edit.apply' , $item->id)}}" class="btn btn-inverse-warning"> Edit</a> --}}

                        <a href="#" class="btn btn-warning" style="background-color: rgb(159, 207, 209); color:  #28a745; #155724;"> Moved to Draft</a>
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
