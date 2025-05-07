@extends('hr_head.hr_head_dashboard')
@section('hr_head')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                {{-- <a href="#" class="btn btn-inverse-info">Add Attendance of Employee</a> --}}
                <a href="{{ route('add.hrheadattendance') }}" class="btn btn-inverse-info">Add Attendance of Hr Head</a>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All Employee</h6>
                        <div class="table-responsive">
                            <form method="GET" action="{{ route('hrhead.attendance') }}" class="row mb-4">
                                <div class="col-md-3">
                                    <label for="month">Month</label>
                                    <select name="month" id="month" class="form-select">
                                        <option value="">-- Select Month --</option>
                                        @for ($m = 1; $m <= 12; $m++)
                                            <option value="{{ sprintf('%02d', $m) }}"
                                                {{ request('month') == sprintf('%02d', $m) ? 'selected' : '' }}>
                                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="year">Year</label>
                                    <select name="year" id="year" class="form-select">
                                        <option value="">-- Select Year --</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}"
                                                {{ request('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3 align-self-end">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                    <a href="{{ route('hrhead.attendance') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </form>
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
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $employee->employee_id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d/M/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->check_in_time)->format('h:i A') ?? '---' }}
                                            </td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                {{-- <a href="{{route('edit.employeeattendance' , $item->id)}}" class="btn btn-inverse-warning"> Edit</a> --}}
                                                <a href="{{ route('delete.hrheadattendance', $item->id) }}"
                                                    class="btn btn-inverse-danger" id="delete"> Delete</a>
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
