@extends('employee.employee_dashboard')
@section('employee')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <a href="{{ route('add.claim') }}" class="btn btn-inverse-info">Add Expense Details of Employee</a>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">All payslip</h6>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>employee_id </th>
                                        <th>name</th>
                                        <th>claim_date</th>
                                        <th>claim_ammount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($claims as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $employyee->employee_id }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->claim_date }}</td>
                                            <td>{{ $item->reimbursed }}</td>


                                            <td>
                                                @if ($item->status === 'approve')
                                                    <span class="text-success">Approved</span>
                                                @elseif ($item->status === 'reject')
                                                    <span class="text-danger">Rejected</span>
                                                @else
                                                    <a href="{{ route('edit.claim', $item->id) }}"
                                                        class="btn btn-inverse-warning">Edit</a>
                                                    <a href="{{ route('delete.claim', $item->id) }}"
                                                        class="btn btn-inverse-danger" id="delete">Delete</a>
                                                @endif
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
