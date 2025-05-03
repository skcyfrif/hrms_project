@extends('admin.admin_dashboard')
@section('admin')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <a href="{{route('view.subu')}}" class="btn btn-inverse-info">Back to View Page</a>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Employee Attendance Details</h6>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th>Check-in Time</th>
                                    <th>Check-out Time</th>
                                    <th>Work Hours</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{$aten->employee_id}}</td>
                                    <td>{{$aten->name}}</td>
                                    <td>{{$aten->date}}</td>
                                    <td>{{$aten->check_in_time}}</td>
                                    <td>{{$aten->check_out_time}}</td>
                                    <td>{{$aten->work_hours}}</td>
                                    <td>{{$aten->status}}</td>
                                    <td>{{$aten->remarks}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
