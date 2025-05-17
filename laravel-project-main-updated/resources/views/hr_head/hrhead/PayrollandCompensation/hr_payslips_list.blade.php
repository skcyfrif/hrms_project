@extends('hr_head.hr_head_dashboard')
@section('hr_head')
    <div class="page-content">
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">

            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Select Month and Year</h6>

                        @csrf
                        <div class="form-row">
                            <div class="col-md-4">
                                <label for="month">Month</label>
                                <select name="month" id="month" class="form-control">
                                    @foreach ($months as $key => $month)
                                        <option value="{{ $key }}">{{ $month }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="year">Year</label>
                                <select name="year" id="year" class="form-control">
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 d-flex justify-content-center align-items-end">
                                <a href="{{ route('view.hrpayslip', ['year' => date('Y'), 'month' => date('m')]) }}"
                                    id="viewPayslipBtn" class="btn btn-primary btn-lg rounded-pill shadow">
                                    <i class="bi bi-download me-2"></i> Download Payslip
                                </a>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("viewPayslipBtn").addEventListener("click", function(event) {
                event.preventDefault();

                var selectedMonth = document.getElementById("month").value;
                var selectedYear = document.getElementById("year").value;

                var payslipUrl = "{{ route('view.hrpayslip') }}" + "?year=" + selectedYear + "&month=" +
                    selectedMonth;

                window.location.href = payslipUrl;
            });
        });
    </script>
@endsection
