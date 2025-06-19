<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payslip</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        @media print {

            @page {
            size: A4 portrait;
            margin: 10mm;
        }
            .btn,
            .print-button {
                display: none !important;
            }

            body {
                font-family: Arial, sans-serif;
                background-color: white;
                margin: 0;
                padding: 0;
            }

            .container {
                width: 100%;
                padding: 20px;
            }

            .card-body {
                margin: 0;
                padding: 10px;
            }

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

            .mt-6 {
                margin-top: 20px;
            }

            .table-primary,
            .table-success {
                background-color: #f9f9f9 !important;
            }
        }

        .label {
            min-width: 160px;
        }

        .employee-details .d-flex {
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h5 class="text-2xl fw-bold">CyfrifPro Private Limited</h5>
            <p class="fs-5">Pay Slip for the Month of <strong>{{ strtoupper(now()->format('F Y')) }}</strong></p>
        </div>

        <div class="d-flex justify-content-between mb-3">
            <button onclick="window.history.back();" class="btn btn-secondary">Back</button>
            <button onclick="window.print();" class="btn btn-primary print-button">Print Payslip</button>
        </div>

        <!-- Employee Info -->
        <div class="employee-details my-4">
            @php
                $fields = [
                    'Employee ID' => $payslip->employeesalarystructureinhrm->employee_id,
                    'Employee Name' => $payslip->name,
                    'Gender' => $payslip->gender,
                    'DOJ' => $payslip->doj,
                    'Grade' => $payslip->grade,
                    'Department' => $payslip->department,
                    'Work Location' => $payslip->employeesalarystructureinhrm->work_location,
                    'Account Number' => $payslip->account_number,
                    'Standard Days' => $payslip->standard_days,
                    'No Of Days Present' => $payslip->no_of_working_day,
                    'LOP Days' => $payslip->lop_days,
                ];
            @endphp

            <div class="row">
                @foreach(array_chunk($fields, ceil(count($fields)/2), true) as $chunk)
                    <div class="col-md-6">
                        @foreach($chunk as $label => $value)
                            <div class="d-flex mb-1">
                                <div class="label fw-bold">{{ $label }}</div>
                                <div>: {{ $value }}</div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Payslip Table -->
        <table class="table table-bordered text-center mt-4">
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
                    <td><strong>Total Amount</strong></td>
                    <td></td>
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
                    <td><strong>₹ {{ $payslip->professional_tax + $payslip->esic + $payslip->advance }}</strong></td>
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

        <!-- Net Salary in Words -->
        <p class="fw-bold mt-3">Net Salary Payable : <strong>{{ $payslip->net_salary_payables }}</strong></p>

        <!-- Footer -->
        <div class="d-flex justify-content-between mt-5">
            <div>
                <p>Generated on: <strong>{{ now() }}</strong></p>
                <span class="text-muted">Seal & Signature</span>
            </div>
            {{-- <div>
                <span class="text-muted">Signature</span>
            </div> --}}
        </div>
    </div>
</body>

</html>
