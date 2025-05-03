@extends('employee.employee_dashboard')
@section('employee')
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
                        <br>
                        <br>
                        <br>
                        <!-- payslip Details Section -->
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
                                <p><strong>Grade:</strong> {{ $payslip->grade }}</p>
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
                                <p><strong>Standard Days:</strong> {{ $payslip->standard_days }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>LOP Days:</strong> {{ $payslip->lop_days }}</p>
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
                                    <td>₹ {{ $payslip->basic_salary }}</td>
                                    <td>₹ {{ $payslip->basic_salary }}</td>
                                    <td>₹ 0</td>
                                    <td>Professional Tax</td>
                                    <td>₹ {{ $payslip->professional_tax ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td>Salary For The Month</td>
                                    <td>₹ {{ $payslip->salary_for_the_month }}</td>
                                    <td>₹ {{ $payslip->salary_for_the_month }}</td>
                                    <td>₹ 0</td>
                                    <td>Professional Tax</td>
                                    <td>₹ {{ $payslip->professional_tax ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td>House Rent Allowance</td>
                                    <td>₹ {{ $payslip->house_rent_allowance }}</td>
                                    <td>₹ {{ $payslip->house_rent_allowance }}</td>
                                    <td>₹ 0</td>
                                    <td>ESIC</td>
                                    <td>₹ {{ $payslip->esic ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td>Conveyance Allowance</td>
                                    <td>₹ {{ $payslip->conveyance_allowance }}</td>
                                    <td>₹ {{ $payslip->conveyance_allowance }}</td>
                                    <td>₹ 0</td>
                                    <td>Advance</td>
                                    <td>₹ {{ $payslip->advance ?? 0 }}</td>
                                </tr>
                                <tr>
                                    <td>Medical Allowance</td>
                                    <td>₹ {{ $payslip->medical_allowance }}</td>
                                    <td>₹ {{ $payslip->medical_allowance }}</td>
                                    <td>₹ 0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Lunch Allowance</td>
                                    <td>₹ {{ $payslip->lunch_allowance }}</td>
                                    <td>₹ {{ $payslip->lunch_allowance }}</td>
                                    <td>₹ 0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Personal Pay</td>
                                    <td>₹ {{ $payslip->personal_pay }}</td>
                                    <td>₹ {{ $payslip->personal_pay }}</td>
                                    <td>₹ 0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Other Allowance</td>
                                    <td>₹ {{ $payslip->other_allowance }}</td>
                                    <td>₹ {{ $payslip->other_allowance }}</td>
                                    <td>₹ 0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Leave Travel Allowance</td>
                                    <td>₹ {{ $payslip->leave_travel_allowance }}</td>
                                    <td>₹ {{ $payslip->leave_travel_allowance }}</td>
                                    <td>₹ 0</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr class="table-primary">
                                    <td colspan="1"><strong>Total Amount</strong></td>
                                    <td><strong>₹

                                    </td>
                                    <td><strong>₹
                                            {{ $payslip->salary_for_the_month +
                                                $payslip->house_rent_allowance +
                                                $payslip->conveyance_allowance +
                                                $payslip->medical_allowance +
                                                $payslip->lunch_allowance +
                                                $payslip->personal_pay +
                                                $payslip->other_allowance +
                                                $payslip->leave_travel_allowance }}</strong>
                                    </td>
                                    <td><strong>₹ 0</strong></td>
                                    <td><strong>Gross Deductions</strong></td>
                                    <td><strong>₹
                                            {{ $payslip->professional_tax + $payslip->esic + $payslip->advance }}</strong>
                                    </td>
                                </tr>
                                <tr class="table-success">
                                    <td colspan="5"><strong>Net Salary Payable</strong></td>
                                    <td><strong>₹
                                            {{ $payslip->salary_for_the_month +
                                                $payslip->house_rent_allowance +
                                                $payslip->conveyance_allowance +
                                                $payslip->medical_allowance +
                                                $payslip->lunch_allowance +
                                                $payslip->personal_pay +
                                                $payslip->other_allowance +
                                                $payslip->leave_travel_allowance -
                                                ($payslip->professional_tax + $payslip->esic + $payslip->advance) }}</strong>
                                    </td>
                                </tr>

                            </tbody>
                        </table>

                        <p class="fw-bold">Net Salary Payable (In Words):
                            <strong>{{ $payslip->net_salary_payables }}</strong></p>
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

                        <button onclick="window.print();" class="a">Print payslip</button>
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

            /* payslip details styling */
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
