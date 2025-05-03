@extends('hr_head.hr_head_dashboard')
@section('hr_head')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">

                    <br>
                    <h3 class="text-center">Employment Offer Letter</h3>
                    <br>
                    <br>
                    <br>
                    <!-- Display current date -->
                    <p>Date: {{ now()->format('F j, Y') }}</p>
                    <p>Name: {{ $employee->name }}</p>
                    <p>Permanent Address: {{ $employee->permanent_address }}</p>
                    <br>
                    <br>

                    <h4>Subject: Employment Offer with CyfrifProTech Ltd.</h4>
                    <br>
                    <p>Dear {{ $employee->name }},</p>
                    <br>
                    <p>We are thrilled to extend an offer for you to join  as a {{ $employee->designation }} with our {{ $employee->department }}. We were thoroughly impressed by your skills, experience, and potential, and we believe you will be a valuable addition to our team.</p>
                    <br>
                    <h5>1. Position Details</h5><br>
                    <ul>
                        <li>Position: {{ $employee->designation }}</li><br>
                        <li>Reporting to: {{ $employee->manager }}</li><br>
                        <li>Start Date: {{ \Carbon\Carbon::parse($employee->doj)->format('F j, Y') }}</li><br>
                        <li>Employment Type: {{ $employee->employment_type }}</li><br>
                        <li>Location: {{ $employee->work_location }}</li><br>
                    </ul>

                    <h5>2. Compensation and Benefits</h5><br>
                    <ul>
                        <li>Health, Dental, and Vision Insurance</li><br>
                        <li>Retirement Savings Plan (401k) with company match</li><br>
                        <li>Paid Time Off: {{ $employee->paid_time_off }} days</li><br>
                        <li>Paid Holidays</li><br>
                        <li>[Other Benefits, e.g., wellness programs, remote work stipend, etc.]</li><br>
                    </ul>

                    <h5>3. Terms and Conditions</h5><br>
                    <p>Your employment with  is at-will, meaning either you or the company may terminate employment
                        at any time, with or without cause or notice.</p>
                    <br>
                    <p>This offer is contingent upon successful completion of background checks and verification ofprovided references,
                        as well as compliance with company policies, which you will receive during your onboarding.</p>
                    <br>
                    <h5>4. Acceptance</h5><br>
                    <p>Please confirm your acceptance of this offer by signing and returning a copy of this letter by
                        {{ \Carbon\Carbon::parse($employee->acceptance_deadline)->format('F j, Y') }}.
                        We are excited to have you on board and look forward to the impactful contributions you will bring.</p>

                    <p>Welcome to CyfrifProTech Ltd.</p>
                    <br>
                    <p>Warm regards,</p>
                    <p>{{ $employee->manager }}</p>
                    <p>{{ $employee->manager_designation }}</p>
                    <p></p>



                    <br>
                    <p>Acceptance of Offer</p><br>
                    <p>I, {{ $employee->name }}, accept the offer for employment with CyfrifProTech Ltd.  as outlined above.</p>

                    <p>Signature: ___________________________</p>
                    <p>Date: ___________________________</p>


                    <!-- Add Print Button -->
                    <br>
                    <br>
                    <button onclick="window.print();" class="a">Print Appointment Letter</button>
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
    }
</style>
@endsection
