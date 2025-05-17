@extends('employee.employee_dashboard')
@section('employee')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('add.employeeattendance') }}" class="btn btn-inverse-info">Add Attendance</a>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">

                            {{-- Filter Form --}}
                            <form method="GET" action="{{ route('employee.attendance.list') }}" class="row mb-4">
                                <div class="col-md-3">
                                    <label for="month">Select Month</label>
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
                                    <label for="year">Select Year</label>
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
                                    <a href="{{ route('employee.attendance.list') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </form>




                            {{-- Attendance Table --}}
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>employee_id</th>
                                        <th>name</th>
                                        <th>date</th>
                                        <th>check_in_time</th>
                                        <th>status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($atens as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $employee->employee_id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->date)->format('d/M/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->check_in_time)->format('h:i A') ?? '---' }}
                                            </td>
                                            <td>{{ $item->status }}</td>
                                            <td>
                                                <a href="{{ route('delete.employeeattendance', $item->id) }}"
                                                    class="btn btn-inverse-danger" id="delete">Delete</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-danger">
                                                No attendance records found for the selected Month.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
