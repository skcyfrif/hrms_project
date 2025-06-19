{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termination Letter</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 40px; background-color: #f4f4f9; }
        .letter-container { background: #fff; padding: 30px; max-width: 700px; margin: 0 auto; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        h2 { text-align: center; font-size: 28px; margin-bottom: 20px; color: #333; }
        p { margin: 10px 0; }
        .header { text-align: left; margin-bottom: 20px; }
        .footer { text-align: right; margin-top: 30px; }
        .footer strong { display: block; }
        .btn-print { text-align: center; margin-top: 20px; }
        .btn-print button { padding: 10px 20px; background-color: #007bff; color: #fff; border: none; cursor: pointer; }
        .btn-print button:hover { background-color: #0056b3; }
        .company-details { font-size: 14px; color: #777; }
        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="letter-container">
        <div class="header">
            <p class="company-details"><strong>Cyfrif Pro Private Limited</strong><br>Hansapala, Bhubaneswar, Odisha, 755001<br>Phone: 1234567891 | Email: demo@gmail.com</p>
            <p><strong>Date:</strong> {{ date('d M Y') }}</p>
        </div>

        <h2>Termination Letter</h2>

        <p><strong>Employee Name:</strong> {{ $termination->subu->name }}</p>
        <p><strong>Employee Address:</strong> {{ $termination->subu->permanent_address_line1 }}</p>

        <p>Dear {{ $termination->subu->name }},</p>

        <p>We regret to inform you that your employment with <strong>Cyfrif Pro Private Limited</strong> will be terminated effective <strong>{{ date('d M Y') }}</strong>. This decision has been made after careful consideration.</p>

        <h4>Reason for Termination:</h4>
        <p>{{ $termination->reason }}</p>

        <h4>Final Pay and Benefits:</h4>
        <p>Your final paycheck will include payment for all work performed until your last working day, along with any unused benefits.</p>

        <h4>Return of Company Property:</h4>
        <p>Please ensure that you return all company property by your last day of employment.</p>

        <h4>Exit Interview:</h4>
        <p>You may schedule an exit interview with HR to discuss your experience at Cyfrif Pro Private Limited.</p>

        <p class="footer">
            Sincerely,<br>
            <strong>HR Head</strong><br>
            Cyfrif Pro Private Limited
        </p>

        <div class="btn-print">
            <button onclick="window.print()">Print Letter</button>
        </div>
        <div class="btn-print">
            <button onclick="window.history.back();" class="btn btn-secondary">
                        Back
                    </button>
        </div>
    </div>
</body>
</html> --}}


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Termination Letter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 40px;
            background-color: #f4f4f9;
        }

        .letter-container {
            background: #fff;
            padding: 30px;
            max-width: 100%;
            /* background-image: url('{{ asset('images/Picture11.jpeg') }}');
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed; */

        }

        h2 {
            text-align: center;
            font-size: 28px;
            margin-bottom: 20px;
            color: #333;
        }

        p {
            margin: 10px 0;
        }

        .header {
            text-align: left;
            margin-bottom: 20px;
        }

        .footer {
            text-align: right;
            margin-top: 30px;
        }

        .footer strong {
            display: block;
        }

        .btn-print {
            text-align: center;
            margin-top: 20px;
        }

        .btn-print button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .btn-print button:hover {
            background-color: #0056b3;
        }

        .company-details {
            font-size: 14px;
            color: #777;
        }

        .terminet_footer {
            color: #0070c0;
        }

        @media print {
            .btn-print {
                display: none;
            }
        }

        .company-footer {
            text-align: center;
            font-size: 13px;
            color: #555;
            margin-top: 50px;
            padding-top: 15px;
        }

        @page {
            margin: 0;
            size: auto;
        }

        .footer-line {

            color: #0070c0;
            text-align: center;
        }



        .website-orange {
            color: #f18012;
            font-weight: bold;
        }
    </style>
</head>


<body>


    <div class="letter-container">
        <div class="letterhead">
            <img src="{{ asset('images/Picture11.jpeg') }}" alt="Company Letterhead"
                style="width: 50%; max-height: 80px; object-fit: contain; margin-left: -50px; margin-top: -20px;">
        </div><br>
        {{-- <div class="header">
            <p class="company-details"><strong>Cyfrif Pro Private Limited</strong><br>Hansapala, Bhubaneswar, Odisha,
                755001<br>Phone: 1234567891 | Email: demo@gmail.com</p>
            <p><strong>Date:</strong> {{ date('d M Y') }}</p>
        </div> --}}

        <h2>Termination Letter</h2>

        <p><strong>Employee Name:</strong> {{ $termination->subu->name }}</p>
        <p><strong>Employee Designation:</strong> {{ $termination->subu->designation }}</p><br><br>

        <p style="text-align: center"><strong>Subject: Termination of Employment</strong></p><br><br>

        <p>Dear {{ $termination->subu->name }},</p>


        <p>This letter serves as formal notice that your employment with is terminated with immediate effect, effective
            as of <strong>Cyfrifpro Private Limited</strong>, with is terminated with immediate effect, effective as of
            <strong>{{ date('d M Y') }}</strong>.
        </p><br><br>



        <p>This decision has been taken after careful review of your conduct and performance, which have been found to
            be in violation of the company's Code of Conduct and below the standards expected by the organization.
            Despite previous warnings and opportunities for improvement, there has been insufficient progress.</p>
        <br><br>

        <p>Please ensure that all company property, including documents, devices, and access cards, are returned to the
            HR department without delay. You will receive your final settlement and any dues as per applicable company
            policy and statutory requirements.</p><br><br>
        <p>We advise you to treat the contents of this letter as confidential. If you have any questions regarding your
            final settlement or return of company property, please contact </p><br><br>
        <p>We wish you the best in your future endeavors.</p>

        <p class="footer">
            Sincerely,<br>
            <strong>Sarada Dash</strong>
            Cyfrif Pro Private Limited
        </p>

        <div class="btn-print">
            <button onclick="window.print()">Print Letter</button>
        </div>
        <div class="btn-print">
            <button onclick="window.history.back();" class="btn btn-secondary">
                Back
            </button>
        </div>

        <div class="company-footer">
            <p class="footer-line">
                -------------------------------
                <span class="website-orange"> www.cyfrifprotech.com </span>
               --------------------------------
            </p>
            <p class="terminet_footer">
                <strong>Cyfrifpro Private Limited</strong>, Awfis, Ground Floor, Ginger Hotel,
                Opp. NALCO Head Office, Jaydev Vihar, Bhubaneswar, Odisha 751013
            </p>
        </div>



    </div>
</body>

</html>
