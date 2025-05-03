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
                        <p class="text-xl">Pay Slip for the Month of <span class="font-semibold">{{ strtoupper(now()->format('F Y')) }}</span></p>
                    </div>
                    <br>
                    <br>
                    <br>
                    <!-- Employee Details Section -->
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>Employee ID:</strong> {{ $abc->employee_id }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Employee Name:</strong> {{ $abc->name }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Gender:</strong> {{ $abc->gender }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>DOJ:</strong> {{ $abc->doj }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Grade:</strong> {{ $def->grade }}</p>
                        </div>

                        <div class="col-md-4">
                            <p><strong>Department:</strong> {{ $abc->department }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Work Location:</strong> {{ $abc->work_location }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Bank Account Number:</strong> {{ $abc->account_number }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Standard Days:</strong> {{ $def->standard_days }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>LOP Days:</strong> {{ $def->lop_days }}</p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>Refund Days:</strong> {{ $def->refund_days }}</p>
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
                                <td>₹ {{ $def->basic_salary }}</td>
                                <td>₹ {{ $def->basic_salary }}</td>
                                <td>₹ 0</td>
                                <td>Professional Tax</td>
                                <td>₹ {{ $def->professional_tax ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>House Rent Allowance</td>
                                <td>₹ {{ $def->house_rent_allowance }}</td>
                                <td>₹ {{ $def->house_rent_allowance }}</td>
                                <td>₹ 0</td>
                                <td>ESIC</td>
                                <td>₹ {{ $def->esic ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>Conveyance Allowance</td>
                                <td>₹ {{ $def->conveyance_allowance }}</td>
                                <td>₹ {{ $def->conveyance_allowance }}</td>
                                <td>₹ 0</td>
                                <td>Advance</td>
                                <td>₹ {{ $def->advance ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>Medical Allowance</td>
                                <td>₹ {{ $def->medical_allowance }}</td>
                                <td>₹ {{ $def->medical_allowance }}</td>
                                <td>₹ 0</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Lunch Allowance</td>
                                <td>₹ {{ $def->lunch_allowance }}</td>
                                <td>₹ {{ $def->lunch_allowance }}</td>
                                <td>₹ 0</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Personal Pay</td>
                                <td>₹ {{ $def->personal_pay }}</td>
                                <td>₹ {{ $def->personal_pay }}</td>
                                <td>₹ 0</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Other Allowance</td>
                                <td>₹ {{ $def->other_allowance }}</td>
                                <td>₹ {{ $def->other_allowance }}</td>
                                <td>₹ 0</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Leave Travel Allowance</td>
                                <td>₹ {{ $def->leave_travel_allowance }}</td>
                                <td>₹ {{ $def->leave_travel_allowance }}</td>
                                <td>₹ 0</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr class="table-primary">
                                <td colspan="1"><strong>Total Amount</strong></td>
                                <td><strong>₹

                                </td>
                                <td><strong>₹
                                    {{
                                        $def->basic_salary +
                                        $def->house_rent_allowance +
                                        $def->conveyance_allowance +
                                        $def->medical_allowance +
                                        $def->lunch_allowance +
                                        $def->personal_pay +
                                        $def->other_allowance +
                                        $def->leave_travel_allowance
                                    }}</strong>
                                </td>
                                <td><strong>₹ 0</strong></td>
                                <td><strong>Gross Deductions</strong></td>
                                <td><strong>₹
                                    {{
                                        $def->professional_tax +
                                        $def->esic +
                                        $def->advance
                                    }}</strong>
                                </td>
                            </tr>
                            <tr class="table-success">
                                <td colspan="5"><strong>Net Salary Payable</strong></td>
                                <td><strong>₹ {{
                                    ($def->basic_salary +
                                    $def->house_rent_allowance +
                                    $def->conveyance_allowance +
                                    $def->medical_allowance +
                                    $def->lunch_allowance +
                                    $def->personal_pay +
                                    $def->other_allowance +
                                    $def->leave_travel_allowance) -
                                    ($def->professional_tax +
                                    $def->esic +
                                    $def->advance)
                                 }}</strong></td>
                            </tr>
                        </tbody>
                    </table>

                    <p class="fw-bold">Net Salary Payable (In Words): <strong>{{ $def->net_salary_payable }}</strong></p>
<br>
<br>
<br>
<br>
<br>

                    <!-- Generated Date and Time -->
                    <p class="mt-2 text-sm text-gray-600">Generated on: <span class="font-medium">{{ now() }}</span></p>

                    <!-- Seal and Signature -->
                    <div class="mt-6 flex items-center justify-between">
                        <div class="border-t-2 border-dotted w-1/3 text-center pt-2">
                            <span class="text-xs font-semibold">Seal</span>
                        </div>
                        <div class="border-t-2 border-dotted w-1/3 text-center pt-2">
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
    @media print {
        /* Hide the print button when printing */
        .a {
            display: none;
        }

        /* Make the content fit nicely on the page */
        .card-body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            margin: 20px;
            padding: 20px;
        }

        /* Ensure that headings are prominent */
        h3, h4, h5 {
            font-size: 18px;
            font-weight: bold;
        }

        /* Adjust spacing */
        p {
            margin-bottom: 10px;
        }

        /* Remove unnecessary background and box shadow */
        .card {
            border: none;
            box-shadow: none;
        }

        /* Set page margins */
        body {
            margin: 0px;
            padding: 0px;
        }

        /* Adjust list styling */
        ul {
            padding-left: 20px;
        }

        /* Ensure no page breaks in the middle of content */
        .card-body p, .card-body ul {
            page-break-inside: avoid;
        }
        .navbar, .nav, .nav-item{
            display: none !important;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        .table th, .table td {
            border: 1px solid black;
            padding: 0px;
            text-align: center;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

    }
</style>
@endsection
