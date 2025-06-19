<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Employment Offer Letter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 40px;
            color: #333;
        }

        .letter-container {
            max-width: 700px;
            margin: 0 auto;
            background: #fff;
            padding: 30px 40px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 6px;
        }

        h3 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #222;
        }

        h4 {
            font-size: 20px;
            margin-top: 30px;
            margin-bottom: 10px;
            color: #222;
        }

        h5 {
            font-size: 18px;
            margin-top: 25px;
            margin-bottom: 10px;
            color: #444;
        }

        p {
            line-height: 1.6;
            margin: 10px 0;
        }

        ul {
            padding-left: 20px;
            margin: 0 0 20px 0;
        }

        ul li {
            margin-bottom: 8px;
        }

        .footer-signature {
            margin-top: 40px;
        }

        .footer-signature p {
            margin: 4px 0;
        }

        .buttons {
            margin-top: 30px;
            text-align: center;
        }

        .btn {
            cursor: pointer;
            padding: 10px 20px;
            border: none;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border-radius: 4px;
            margin: 0 10px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        @media print {
            .btn {
                display: none;
            }

            body {
                background: white;
                padding: 0;
            }

            .letter-container {
                box-shadow: none;
                border-radius: 0;
                padding: 0;
                margin: 0;
            }
        }
    </style>
</head>

<body>

    <div class="letter-container">

        <h3>Employment Offer Letter</h3>

        <p>Date: {{ now()->format('F j, Y') }}</p>
        <p>Name: {{ $employee->name }}</p>
        <p>Permanent Address: {{ $employee->permanent_address }}</p>

        <h4>Subject: Employment Offer with CyfrifProTech Ltd.</h4>

        <p>Dear {{ $employee->name }},</p>

        <p>We are thrilled to extend an offer for you to join as a <strong>{{ $employee->designation }}</strong> with
            our <strong>{{ $employee->department }}</strong>. We were thoroughly impressed by your skills, experience,
            and potential, and we believe you will be a valuable addition to our team.</p>

        <h5>1. Position Details</h5>
        <ul>
            <li>Position: {{ $employee->designation }}</li>
            <li>Reporting to: {{ $employee->manager }}</li>
            <li>Start Date: {{ \Carbon\Carbon::parse($employee->doj)->format('F j, Y') }}</li>
            <li>Employment Type: {{ $employee->employment_type }}</li>
            <li>Location: {{ $employee->work_location }}</li>
        </ul>

        <h5>2. Compensation and Benefits</h5>
        <ul>
            <li>Health, Dental, and Vision Insurance</li>
            <li>Retirement Savings Plan (401k) with company match</li>
            <li>Paid Time Off: {{ $employee->paid_time_off }} days</li>
            <li>Paid Holidays</li>
            <li>[Other Benefits, e.g., wellness programs, remote work stipend, etc.]</li>
        </ul>

        <h5>3. Terms and Conditions</h5>
        <p>Your employment with CyfrifProTech Ltd. is at-will, meaning either you or the company may terminate
            employment at any time, with or without cause or notice.</p>
        <p>This offer is contingent upon successful completion of background checks and verification of provided
            references, as well as compliance with company policies, which you will receive during your onboarding.</p>

        <h5>4. Acceptance</h5>
        <p>Please confirm your acceptance of this offer by signing and returning a copy of this letter by
            <strong>{{ \Carbon\Carbon::parse($employee->acceptance_deadline)->format('F j, Y') }}</strong>. We are
            excited to have you on board and look forward to the impactful contributions you will bring.</p>

        <p>Welcome to CyfrifProTech Ltd.</p>

        <p>Warm regards,</p>
        <div class="footer-signature">
            <p>{{ $employee->manager }}</p>
            <p>{{ $employee->manager_designation }}</p>
        </div>

        <h5>Acceptance of Offer</h5>
        <p>I, {{ $employee->name }}, accept the offer for employment with CyfrifProTech Ltd. as outlined above.</p>
        <p>Signature: ___________________________</p>
        <p>Date: ___________________________</p>

        <div class="buttons">
            <button onclick="window.print();" class="btn">Print Appointment Letter</button>
            {{-- <button onclick="window.history.back();" class="btn" style="background-color:#6c757d;">Back</button> --}}
            <button onclick="
  if (window.history.length > 1) {
    window.history.back();
  } else {
    window.location.href='{{ route('hrmanager.list') }}';
  }
" class="btn" style="background-color:#6c757d;">Back</button>

        </div>

    </div>

</body>

</html>
