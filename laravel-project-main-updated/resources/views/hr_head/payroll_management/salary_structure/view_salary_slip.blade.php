@extends('hr_head.hr_head_dashboard')
@section('hr_head')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">

                        <br>
                        <div class="text-center">
                            <!-- Company Name -->
                            <h5 class="text-2xl font-bold mb-2">CyfrifPro Private Limited</h5>

                            <!-- Pay Slip for the Month Text -->
                            <p class="text-xl">Pay Slip for the Month of <span
                                    class="font-semibold">{{ strtoupper(now()->format('F Y')) }}</span></p>
                        </div>


                        <div>
                            <button onclick="window.history.back();" class="btn btn-secondary">
                                Back
                            </button>
                        </div>


                        <div style="position: relative;">
                            <div style="position: absolute; top: -35px; right: 10px;">
                                <button onclick="window.print();" class="a">Print payslip</button>
                            </div>
                        </div>
                        <br>
                        <br>
                        <br>
                        <!-- Employee Details Section -->
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>Employee ID:</strong> {{ $payslip->employee_id }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Employee Name:</strong> {{ $payslip->name }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Gender:</strong> {{ $payslip->gender }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>DOJ:</strong> {{ $payslip->doj }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Grade:</strong> {{ $employee->grade }}</p>
                            </div>

                            <div class="col-md-4">
                                <p><strong>Department:</strong> {{ $payslip->department }}</p>
                            </div>

                            <div class="col-md-4">
                                <p><strong>Work Location:</strong> {{ $payslip->work_location }}</p>
                            </div>

                            <div class="col-md-4">
                                <p><strong>Bank Account Number:</strong> {{ $payslip->account_number }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Standard Days:</strong> {{ $employee->standard_days }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>LOP Days:</strong> {{ $employee->lop_days }}</p>
                            </div>
                        </div>
                        <br>
                        <br>

                        <table class="table table-bordered text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th>Earning</th>
                                    <th>Monthly Rate</th>
                                    <th>Current Month</th>
                                    <th>Arrears</th>
                                    <th>Deductions</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Basic Salary</td>
                                    <td>₹ {{ $employee->basic_salary }}</td>
                                    <td>₹ {{ $employee->basic_salary }}</td>
                                    <td>₹ 0</td>
                                    <td>Professional Tax</td>
                                    <td>₹ {{ $employee->professional_tax ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td>Salary For The Month</td>
                                    <td>₹ {{ $employee->salary_for_the_month }}</td>
                                    <td>₹ {{ $employee->salary_for_the_month }}</td>
                                    <td>₹ 0</td>
                                    <td>ESIC</td>
                                    <td>₹ {{ $employee->esic ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td>House Rent Allowance</td>
                                    <td>₹ {{ $employee->house_rent_allowance }}</td>
                                    <td>₹ {{ $employee->house_rent_allowance }}</td>
                                    <td>₹ 0</td>
                                    <td>Advance</td>
                                    <td>₹ {{ $employee->advance ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td>Conveyance Allowance</td>
                                    <td>₹ {{ $employee->conveyance_allowance }}</td>
                                    <td>₹ {{ $employee->conveyance_allowance }}</td>
                                    <td>₹ 0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Medical Allowance</td>
                                    <td>₹ {{ $employee->medical_allowance }}</td>
                                    <td>₹ {{ $employee->medical_allowance }}</td>
                                    <td>₹ 0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Lunch Allowance</td>
                                    <td>₹ {{ $employee->lunch_allowance }}</td>
                                    <td>₹ {{ $employee->lunch_allowance }}</td>
                                    <td>₹ 0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Personal Pay</td>
                                    <td>₹ {{ $employee->personal_pay }}</td>
                                    <td>₹ {{ $employee->personal_pay }}</td>
                                    <td>₹ 0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Other Allowance</td>
                                    <td>₹ {{ $employee->other_allowance }}</td>
                                    <td>₹ {{ $employee->other_allowance }}</td>
                                    <td>₹ 0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Leave Travel Allowance</td>
                                    <td>₹ {{ $employee->leave_travel_allowance }}</td>
                                    <td>₹ {{ $employee->leave_travel_allowance }}</td>
                                    <td>₹ 0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="table-primary">
                                    <td colspan="1"><strong>Total Amount</strong></td>
                                    <td><strong>₹

                                    </td>
                                    <td><strong>₹
                                            {{ $employee->salary_for_the_month +
                                                $employee->house_rent_allowance +
                                                $employee->conveyance_allowance +
                                                $employee->medical_allowance +
                                                $employee->lunch_allowance +
                                                $employee->personal_pay +
                                                $employee->other_allowance +
                                                $employee->leave_travel_allowance }}</strong>
                                    </td>
                                    <td><strong>₹ 0</strong></td>
                                    <td><strong>Gross Deductions</strong></td>
                                    <td><strong>₹
                                            {{ $employee->professional_tax + $employee->esic + $employee->advance }}</strong>
                                    </td>
                                </tr>
                                <tr class="table-success">
                                    <td colspan="5"><strong>Net Salary Payable</strong></td>
                                    <td><strong>₹
                                            {{ $employee->salary_for_the_month +
                                                $employee->house_rent_allowance +
                                                $employee->conveyance_allowance +
                                                $employee->medical_allowance +
                                                $employee->lunch_allowance +
                                                $employee->personal_pay +
                                                $employee->other_allowance +
                                                $employee->leave_travel_allowance -
                                                ($employee->professional_tax + $employee->esic + $employee->advance) }}</strong>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <p class="fw-bold">Net Salary Payable (In Words):
                            <strong>{{ $employee->net_salary_payables }}</strong></p>
                        <!-- Generated Date and Time -->
                        <!-- Seal and Signature -->
                        <div class="mt-6 flex justify-end items-center">
                            <div class="w-1/3 pt-2">
                                <p class="">Generated on: <span
                                    class="font-medium">{{ now() }}</span></p>
                                <span class="text-xs font-semibold">Seal</span>
                            </div>
                            <div class="w-1/3 pt-2">
                                <span class="text-xs font-semibold">Signature</span>
                            </div>
                        </div>


                        <br>
                        <br>



                    </div>


                </div>
            </div>
        </div>
    </div>
    <!-- Print-specific Styles -->
    <style>
        /* Print-specific Styles */
        @media print {

            .fw-bold {
                display: block !important;
                /* Ensure the element isn't hidden */
            }

            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: white;
            }

            .container {
                width: 100%;
                max-width: 100%;
                margin: 0;
                padding: 20px;
            }

            /* Hide print button during print */
            .print-button {
                display: none;
            }

            .btn-secondary {
            display: none !important;
            }

            /* Adjust the content of the payslip */
            .card-body {
                margin: 0;
                padding: 10px;
            }

            .row {
                display: flex;
                flex-wrap: wrap;
                /* Allow wrapping to the next line */
                justify-content: space-between;
                margin-bottom: 10px;
            }

            /* Adjust columns to have 5 items per row */
            .col-md-4 {
                width: 48%;
                /* 5 items per line */
                margin-bottom: 10px;
            }

            /* Employee details styling */
            .col-md-4 p {
                font-size: 12px;
                margin: 5px 0;
            }

            /* Ensure the table looks good on print */
            .table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                font-size: 12px;
            }

            .table th,
            .table td {
                border: 1px solid black;
                padding: 6px;
                text-align: center;
            }

            .table th {
                background-color: #f0f0f0;
                font-weight: bold;
            }

            /* Remove unnecessary background and box-shadow */
            .card {
                border: none;
                box-shadow: none;
            }

            .navbar,
            .nav,
            .nav-item {
                display: none !important;
            }

            /* Adjust the page layout */
            .table td,
            .table th {
                font-size: 11px;
            }

            /* Ensure the table headers are clear */
            .table th {
                background-color: #f2f2f2;
                font-size: 12px;
            }

            /* Style the footer and signature */
            .mt-6 {
                margin-top: 20px;
            }

            .border-t-2 {
                border-top: 2px dotted black;
            }

            /* Hide unnecessary content */
            .a,
            .mt-2,
            .fw-bold {
                display: none;
            }

            /* Adjust for the net salary section */
            .table-primary,
            .table-success {
                background-color: #f9f9f9;
            }

            /* Remove margins for printed body */
            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
@endsection
