<!DOCTYPE html>
<html>
<head>
    <title>Intern Offer Letter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            padding: 30px;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: auto;
        }
        .text-center {
            text-align: center;
        }
        ul, ol {
            margin-left: 20px;
        }
        .section-title {
            border-bottom: 2px solid #000;
            font-weight: bold;
            display: inline-block;
        }
        .print-button {
            margin-top: 20px;
            padding: 10px 15px;
            font-size: 16px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @include('hr_manager.includes.header')
                <div class="card-body">

                    {{-- <br>
                    <br>
                    <br> --}}
                    <br>
                    <h3 class="text-center">Employment Offer Letter for intern</h3><br><br><br>
                    <h5 class="text-center" style="font-weight: bold; text-decoration: underline;">Personal & Confidential</h5>
                    <br>
                    <br>
                    <br>
                    <!-- Display current date -->
                    <p>Date: {{ now()->format('F j, Y') }}</p>
                    <p>Name: {{ $candidate->name }}</p>
                    <p>Applicant ID: {{ $candidate->applicant_id }}</p>
                    <br>
                    <br>

                    {{-- <h4>Subject: Employment Offer with CyfrifProTech Ltd.</h4> --}}
                    <br>
                    <p>Dear {{ $candidate->name }},</p>
                    <br>
                    <p>Further to the interview and discussion We are pleased to offer you the opportunity to join Cyfrifpro Private Limited as an
                        "{{ $candidate->applied_for }}" in the Cyfrifpro Tech Services. This internship is designed to provide you with
                        meaningful and practical experience Software Development, while contributing to our organization’s goals.</p>
                    <br>

                    <p style="border-bottom: 2px solid #000000; font-weight: bold;display: inline-block;">Monthly Stipend:</p><br><br>
                        <ul>You would be entitled to a consolidated amount of Rs 5000/- as a monthly stipend.</ul><br>

                    <p style="border-bottom: 2px solid #000000; font-weight: bold;display: inline-block;">Personal Pay:</p><br><br>
                        <ul>The component of Personal Pay is specific to each individual and varies with regards to a person's level, performance
                            rating, contribution, skills and competencies
                        </ul><br>

                    <p style="border-bottom: 2px solid #000000; font-weight: bold;display: inline-block;">Internship Period:</p><br><br>
                        <ul>You will be on internship for a period of 3 months from the date of your Start . Upon successfully completing the initial
                            3-month internship, your performance will be evaluated, and you may be offered an extension for an additional 3 months.
                            After completing the 6-month internship, management will conduct a final performance review. If your performance meets
                            expectations, you may be offered a position as a full-time member of the core team
                        </ul><br>

                    <p style="border-bottom: 2px solid #000000; font-weight: bold;display: inline-block;">Job description:</p><br><br>
                        <ul>Your duties and responsibilities will be explained to you on your joining the organisation. However, you shall execute and
                            perform all such duties that may be assigned to you by the Organisation from time to time and the Organisation reserves
                            its right to vary these at its discretion.
                        </ul><br>

                    <p style="border-bottom: 2px solid #000000; font-weight: bold;display: inline-block;">Location:</p><br><br>
                        <ul>
                            Your initial place of posting will be Bhubaneswar. Your final place of posting will be intimated to-you subsequently.
                            However, the Organisation reserves the right to transfer you to any other Office/Branch, Subsidiary or Associate Company
                            of the Organisation, in India, that is in-existence or may come into existence at a future date.
                        </ul><br>
                    <p style="border-bottom: 2px solid #000000; font-weight: bold;display: inline-block;">Secrecy:</p><br><br>
                        <ul>
                            It is a condition of your employment that you will not, for whatever reason, divulge without express written authority from
                            the Management, any information relating to the organisation or any of its constituents or employees, as received by you
                            in the course of your employment and after the cessation of your employment with the Organisation.
                        </ul><br>
                    <p style="border-bottom: 2px solid #000000; font-weight: bold;display: inline-block;">Alternative Employment:</p><br><br>
                        <ul>
                            During the course of your employment with the Organisation, you will not engage yourself directly or indirectly in any
                            trade, business, occupation, employment, service or calling whether for remuneration or otherwise, without the prior
                            written consent of the Organisation.
                        </ul><br>
                    <p style="border-bottom: 2px solid #000000; font-weight: bold;display: inline-block;">Maternity Benefits:</p><br><br>
                        <ol>
                            a) All women employees of the Organisation, irrespective of their tenure shall be eligible for Maternity Leave. The
                            Organisation shall allow 26 weeks of Maternity leave to its women employees without pay , of which, not more than 8
                            weeks to precede the date of her expected delivery. The maximum period entitled for maternity benefit by a woman having
                            two or more than two surviving children shall be 12 weeks of which not more than 6 weeks shall precede the date of her
                            expected delivery.<br><br>
                            b) The employee shall be also eligible for leave without pay for a period of 6 weeks in the event of a miscarriage or medical
                            termination of pregnancy.<br><br>
                            c) In case of tubectomy operation, a woman employee is entitled for leave for a period of 2 weeks immediately following
                            the day of her tubectomy operation.<br><br>
                            d) The Organisation shall additionally provide leave without pay for a maximum period of one month for Illness arising
                            out of Pregnancy, delivery, premature birth of the child, miscarriage, medical termination of pregnancy or tubectomy.
                            This benefit is allowed subject to production of Medical Certificate.<br><br>
                            e) A woman employee who legally adopts a child below the age of three months or a commissioning mother, shall be
                            entitled to maternity leave without pay for a period of 12 weeks from the date the child is handed over to the adopting mother or the commissioning mother, as the case may be. The maximum period of maternity leave entitled to a woman
                            employee legally adopting a child of over three months old and below the age of 6 years shall be eight weeks.<br><br>
                            f) In cases where a woman employee is not able to resume her duties at the end of Maternity Leave on account of medical
                            / health reasons, she may be allowed to work from home for a period not exceeding 30 days subject to approval of
                            concerned Department Head and Management provided the nature of work is such that she may work from home.<br>
                        </ol><br>
                    <p style="border-bottom: 2px solid #000000; font-weight: bold;display: inline-block;">Conditions Precedent:</p><br><br>
                    <p>The offer is made to you subject to the following pre-conditions:</p><br>
                        <ul>
                            a) The Organisation receiving satisfactory character references from referees as provided by you (both the referees have
                            to be your Supervisor / Supervisor's Supervisor / HR Official / Ex-Supervisor from your current Organisation only i.e.
                            prior to joining of Cyfrifpro Technology Service ) Additionally, the Organisation reserves the right to seek references from
                            your current/previous employer(s), at any stage, subsequent to your acceptance of this offer letter.<br><br>
                            b) The Organisation receiving attested copies of all your degrees and professional qualifications certificates and
                            documentary evidence of scholarships or prizes won, if any.<br><br>
                            c) The Organisation receiving a copy of the relieving letter from your previous employer.<br><br>
                            d) The Self Declaration given by you in respect of your medical fitness is in order.<br><br>
                            The terms and conditions set out in this letter of appointment constitute service conditions applicable to your employment
                            in the Organisation and with regard to any dispute arising thereof, the Bhubaneswar Courts will have exclusive
                            jurisdiction.<br><br>
                        </ul><br>
                    <ul>
                        This letter is issued on your representation that you were not subjected to disciplinary action by your present or previous
                        employers and/or held guilty in any legal proceedings. In the event any such incident is brought to the notice of the
                        Organisation; the Organisation reserves its right to withdraw this letter/terminate your services without any prior notice
                        and without assigning any reason.
                    </ul><br>
                    <ul>
                        Notwithstanding anything contained in the above paragraphs, your services may be terminated by the Organisation if you
                        are found to be indulging in acts of Commission/Omission which may be prejudicial to the interests of the Organisation
                        or any act of dishonesty, disobedience, insubordination or any other misconduct or neglect of duty or incompetence in the
                        discharge of duty on your part.
                    </ul><br>
                    <ul>
                        Kindly note that you are required to join the Organisation as per the joining date agreed basis our discussion not exceeding
                        30 days from the receipt of the letter. You are required to give acceptance of the offer & above terms and conditions of
                        employment immediately on receipt of this offer letter. This offer letter will be valid for a maximum of 30 days from the
                        date of this letter
                    </ul><br>
                    <p>We welcome you to Cyfrifpro Technology Services and look forward to having a long and mutually
                        Beneficial association with you</p>
                    <!-- Add Print Button -->
                    <br>
                    <br>
                    <!-- <button onclick="window.print();" class="a">Print Offer Letter for intern</button> -->
                </div>
                <!-- @include('hr_manager.includes.footer') -->
            </div>
        </div>
    </div>
</div>
<!-- Print-specific Styles -->

</body>
</html>      
