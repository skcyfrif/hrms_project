<!DOCTYPE html>
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
            <strong>Admin</strong><br>
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
</html>
