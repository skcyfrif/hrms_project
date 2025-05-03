@extends('employee.employee_dashboard')
@section('employee')

<div class="page-content">
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            {{-- <li class="breadcrumb-item"><a href="{{ route('employee.payslips') }}">Payslips</a></li> --}}
            {{-- <li class="#">Payslips</a></li> --}}
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Select Month and Year</h6>
                    {{-- <form action="{{ route('Payslip') }}" method="POST"> --}}
                    {{-- <form action="#" method="POST"> --}}
                        @csrf
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="month">Month</label>
                                <select name="month" id="month" class="form-control">
                                    @foreach($months as $key => $month)
                                        <option value="{{ $key }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="year">Year</label>
                                <select name="year" id="year" class="form-control">
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 align-self-end">
                                <a href="{{ route('view.mypayslip', ['year' => date('Y'), 'month' => date('m')]) }}"
                                    id="viewPayslipBtn"
                                    class="btn btn-inverse-info">
                                    View Payslip
                                 </a>

                                {{-- <a href="#" class="btn btn-inverse-info">View Payslip</a> --}}

                                <a href="#" class="btn btn-inverse-info">Download Payslip</a>
                                {{-- <a href="{{ route('download.mypayslip', ['id' => $employeeId->id]) }}" class="btn btn-inverse-info">Download Payslip</a> --}}

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("viewPayslipBtn").addEventListener("click", function (event) {
            event.preventDefault();

            var selectedMonth = document.getElementById("month").value;
            var selectedYear = document.getElementById("year").value;

            var payslipUrl = "{{ route('view.mypayslip') }}" + "?year=" + selectedYear + "&month=" + selectedMonth;

            window.location.href = payslipUrl;
        });
    });
</script>

@endsection
