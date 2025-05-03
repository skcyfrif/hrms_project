@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @include('hr_manager.includes.header')
                <div class="card-body">

                    <br>
                    <br>
                    <br>
                    <br>
                    <h3 class="text-center">Employment Offer Letter for Full time</h3><br><br><br>
                    <h5 class="text-center" style="font-weight: bold; text-decoration: underline;">Personal & Confidential</h5>
                    <br>
                    <br>
                    <br>
                    <!-- Display current date -->
                    <p>Date: {{ now()->format('F j, Y') }}</p>
                    <p>Applicant ID: {{ $candidate->applicant_id }}</p>
                    <p>Name: {{ $candidate->name }}</p>


                    {{-- <p>Permanent Address: {{ $employee->permanent_address }}</p> --}}
                    <br>
                    <br>

                    {{-- <h4>Subject: Employment Offer with CyfrifProTech Ltd.</h4> --}}
                    <br>
                    <p>Dear {{ $candidate->name }},</p>
                    <br>
                    <p>Further to the interview and discussion you had with us, we are pleased to offer you the position of "{{ $candidate->applied_for }}" in Cyfrif Education Academy subject to the following terms and conditions:</p>
                    <br>
                    <h6 style="text-decoration: underline;">Monthly Compensation:</h6><br>
                        <p>
                            You would be entitled to a consolidated amount of Rs 12000/- as a monthly payout. Whenever your student strength exceeds 40, you will additionally be entitled to receive Rs 200/- per student on a monthly basis, and vice versa
                        </p><br>
                    <h6 style="text-decoration: underline;">Leave Travel Allowance:</h6><br>
                        <p>
                            You would be entitled to LTA @ one month's salary, after completion of one year of service in the Organisation.
                        </p><br>
                    <h6>Personal Pay:</h6><br><br>
                        <p>
                            The component of Personal Pay is specific to each individual and varies with regards to a person's level, performance rating, contribution, skills and competencies.
                        </p><br>
                    <h6 style="text-decoration: underline;">Probationary Period:</h6><br>
                        <p>
                            You will be on probation for a period of six months from the date of your employment. Subject to satisfactory performance during the probationary period you will be confirmed in the services of the Organisation. During probationary period either party may terminate the services by giving one month's notice or salary in lieu thereof at the Organisation's discretion. However, after confirmation either party will be required to give three months' notice or Salary in lieu of notice at the organisation's discretion.
                        </p><br>
                    <h6 style="text-decoration: underline;"> Job description:</h6><br>
                        <p>
                            Your duties and responsibilities will be explained to you on your joining the organisation. However, you shall execute and perform all such duties that may be assigned to you by the Organisation from time to time and the Organisation reserves its right to vary these at its discretion.
                        </p><br>
                    <h6 style="text-decoration: underline;"> Location:</h6><br>
                        <p>
                            Your initial place of posting will be Bhubaneswar	. Your final place of posting will be intimated to-you subsequently. However, the Organisation reserves the right to transfer you to any other Office/Branch, Subsidiary or Associate Company of the Organisation, in India, that is in-existence or may come into existence at a future date.
                        </p><br>
                    <h6 style="text-decoration: underline;">Secrecy:</h6><br>
                        <p>
                            It is a condition of your employment that you will not, for whatever reason, divulge without express written authority from the Management, any information relating to the organisation or any of its constituents or employees, as received by you in the course of your employment and after the cessation of your employment with the Organisation.
                        </p><br>
                    <h6 style="text-decoration: underline;"> Alternative Employment:</h6><br>
                        <p>
                            During the course of your employment with the Organisation, you will not engage yourself directly or indirectly in any trade, business, occupation, employment, service or calling whether for remuneration or otherwise, without the prior written consent of the Organisation.
                        </p><br>
                    <h6 style="text-decoration: underline;"> Maternity Benefits:</h6><br>
                        <p>
                            a) All women employees of the Organisation, irrespective of their tenure shall be eligible for Maternity Leave. The Organisation shall allow 26 weeks of Maternity leave to its women employees without pay , of which, not more than 8 weeks to precede the date of her expected delivery. The maximum period entitled for maternity benefit by a woman having two or more than two surviving children shall be 12 weeks of which not more than 6 weeks shall precede the date of her expected delivery.<br>
                            <br>
                            b) The employee shall be also eligible for leave without pay for a period of 6 weeks in the event of a miscarriage or medical termination of pregnancy.<br>
                            <br>
                            c) In case of tubectomy operation, a woman employee is entitled for leave for a period of 2 weeks immediately following the day of her tubectomy operation.<br>
                            <br>
                            d) The Organisation shall additionally provide leave without pay for a maximum period of one month for Illness arising out of Pregnancy, delivery, premature birth of the child, miscarriage, medical termination of pregnancy or tubectomy. This benefit is allowed subject to production of Medical Certificate.<br>
                            <br>
                            e) A woman employee who legally adopts a child below the age of three months or a commissioning mother, shall be entitled to maternity leave without pay for a period of 12 weeks from the date the child is handed over to the adopting mother or the commissioning mother, as the case may be. The maximum period of maternity leave entitled to a woman employee legally adopting a child of over three months old and below the age of 6 years shall be eight weeks.<br>
                            <br>
                            f) In cases where a woman employee is not able to resume her duties at the end of Maternity Leave on account of medical / health reasons, she may be allowed to work from home for a period not exceeding 30 days subject to approval of concerned Department Head and Management provided the nature of work is such that she may work from home.<br>
                            <br>
                        </p><br>
                    <h6 style="text-decoration: underline;"> Crèche facility:</h6><br>
                        <p>
                            a) The Organisation will provide crèche facility in line with regulatory guidelines. The offices / locations where such facilities would be made available and the applicable terms and conditions would be notified in the Employee Portal of the Organisation.
                        </p><br>
                    <h6 style="text-decoration: underline;"> Conditions Precedent:</h6><br>
                        <p>
                            The offer is made to you subject to the following pre-conditions:
                        </p><br>
                            <ul>
                                a) The Organisation receiving satisfactory character references from referees as provided by you (both the referees have to be your Supervisor / Supervisor's Supervisor / HR Official / Ex-Supervisor from your current Organisation only i.e. prior to joining of Cyfrifpro Education Academy ) Additionally, the Organisation reserves the right to seek references from your current/previous employer(s), at any stage, subsequent to your acceptance of this offer letter. <br>
                                <br>
                                b) The Organisation receiving attested copies of all your degrees and professional qualifications certificates and documentary evidence of scholarships or prizes won, if any.<br>
                                <br>
                                c) The Organisation receiving a copy of the relieving letter from your previous employer.<br>
                                <br>
                                d) The Self Declaration given by you in respect of your medical fitness is in order.<br>
                            </ul><br>
                        <p>
                            The terms and conditions set out in this letter of appointment constitute service conditions applicable to your employment in the Organisation and with regard to any dispute arising thereof, the Bhubaneswar Courts will have exclusive jurisdiction.
                        </p><br>

                        <p>
                            This letter is issued on your representation that you were not subjected to disciplinary action by your present or previous employers and/or held guilty in any legal proceedings. In the event any such incident is brought to the notice of the Organisation; the Organisation reserves its right to withdraw this letter/terminate your services without any prior notice and without assigning any reason.
                        </p><br>

                        <p>
                            Notwithstanding anything contained in the above paragraphs, your services may be terminated by the Organisation if you are found to be indulging in acts of Commission/Omission which may be prejudicial to the interests of the Organisation or any act of dishonesty, disobedience, insubordination or any other misconduct or neglect of duty or incompetence in the discharge of duty on your part.
                        </p><br>

                        <p>
                            Kindly note that you are required to join the Organisation as per the joining date agreed basis our discussion not exceeding 30 days from the receipt of the letter. You are required to give acceptance of the offer & above terms and conditions of employment immediately on receipt of this offer letter. This offer letter will be valid for a maximum of 30 days from the date of this letter.
                        </p><br>

                        <p>
                            We welcome you to Cyfrif Academy and look forward to having a long and mutually
                            Beneficial association with you.
                        </p><br>

                        <p>Yours truly,</p><br>

                        <p>For Cyfrif Education Academy.</p>





                    <!-- Add Print Button -->
                    <br>
                    <br>
                    <button onclick="window.print();" class="a">Print Offer Letter for Full Time</button>
                </div>
                @include('hr_manager.includes.footer')
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
