@extends('hr_head.hr_head_dashboard')
@section('hr_head')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                {{-- <a href="{{route('add.leave')}}" class="btn btn-inverse-info">Apply leave</a> --}}
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">

                        <div class="form-container">
                            <h1>Submit a Request</h1>

                            @if (session('success'))
                                <div class="alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('forms.submit') }}">
                                @csrf

                                <div class="mb-4">
                                    <label for="requestType">Select Request Type</label>
                                    <select id="requestType" name="request_type" class="form-control"
                                        onchange="handleRequestChange(this)">
                                        <option value="">-- Select --</option>
                                        <option value="salary-increment">Salary Increment</option>
                                        <!-- <option value="make-permanent">Make Permanent</option> -->
                                        <option value="account-details-update">Account Details Update</option>
                                        <option value="update-profile">Update Profile</option>
                                        <option value="any-issue">Any Issue</option>
                                    </select>
                                    @error('request_type')
                                        <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div id="formFields" class="space-y-4"></div>

                                <script>
                                    function handleRequestChange(select) {
                                        const selected = select.value;
                                        showForm(selected);
                                        
                                    }

                                    function showForm(type) {
                                        const container = document.getElementById('formFields');
                                        let html = '';

                                        if (type === 'salary-increment') {
                                            html = `
                                                <div>
                                                    <label>Current Salary</label>
                                                    <input type="number" name="current_salary"  class="form-control">
                                                </div>
                                                <div>
                                                    <label>Expected Increment</label>
                                                    <input type="number" name="expected_increment" class="form-control">
                                                </div>
                                            `;
                                        } else if (type === 'account-details-update') {
                                            html = `
                                                <div class="row">
                                                    <h4 class="text-center" style="color: #6c757d; font-weight: bold;">Previous Account Details</h4>

                                                    <div class="col-md-6 mb-3">
                                                        <label>Bank Name</label>
                                                        <input type="text" name="prv_bank_name" value="{{ $employee->bank_name ?? 'N/A' }}" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>Branch Name</label>
                                                        <input type="text" name="prv_branch_name" value="{{ $employee->branch_name ?? 'N/A' }}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label>Account Number</label>
                                                        <input type="text" name="prv_account_number" value="{{ $employee->account_number ?? 'N/A' }}" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>IFSC Code</label>
                                                        <input type="text" name="prv_ifsc_code" value="{{ $employee->ifsc_code ?? 'N/A' }}" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <h4 class="text-center" style="color: #007bff; font-weight: bold;">Update Account Details</h4>

                                                    <div class="col-md-6 mb-3">
                                                        <label>Bank Name</label>
                                                        <input type="text" name="bank_name" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>Branch Name</label>
                                                        <input type="text" name="branch_name" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label>Account Number</label>
                                                        <input type="text" name="account_number" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>IFSC Code</label>
                                                        <input type="text" name="ifsc_code" class="form-control">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-primary mt-3">Submit Request</button>

                                            `;
                                        } else if (type === 'any-issue') {
                                            html = `
                                                <div>
                                                    <label>Describe the Issue</label>
                                                    <textarea name="issue_description" class="form-control"></textarea>
                                                </div>
                                            `;
                                        } else if (type === 'make-permanent') {
                                            html = `
                                            <form id="makePermanentForm" method="POST" action="/employee/make-permanent/submit">
                                                @csrf
                                                <div class="card p-3" style="background-color: #ffffff; color: #333;">
                                                    <h5>Employee Details:</h5>
                                                    <ul>
                                                        <li><strong>Name:</strong> {{ $employee->name }}</li>
                                                        <li><strong>Internship ID:</strong> {{ $employee->employee_id ?? 'N/A' }}</li>
                                                        <li><strong>Department/Team:</strong> {{ $employee->department ?? 'N/A' }}</li>
                                                        <li><strong>Internship Duration:</strong> {{ \Carbon\Carbon::parse($employee->doj)->format('d M Y') }} to {{ \Carbon\Carbon::today()->format('d M Y') }}</li>
                                                        <li><strong>Mentor:</strong> {{ $employee->supervisor->name ?? 'N/A' }}</li>
                                                    </ul>

                                                    <hr>

                                                    <h5>Request Statement:</h5>
                                                    <p>
                                                        I, <strong>{{ $employee->name }}</strong>, have successfully completed my internship in the <strong>{{ $employee->department ?? 'your department' }}</strong> at Cyfrif Tech Service. During my internship period, I have gained valuable experience and contributed to the assigned tasks and projects to the best of my ability.
                                                    </p>
                                                    <p>
                                                        I am writing this to formally express my interest in continuing my service with the organization as a
                                                        <strong>{{ $employee->designation ?? 'your department' }}</strong>, and I kindly request your consideration for the same.
                                                    </p>
                                                    <p>
                                                        I am eager to contribute further to the company's goals and continue growing with the team.
                                                    </p>

                                                    <hr>

                                                    <h5>Declaration:</h5>
                                                    <p>I hereby confirm that all the above information is accurate and true to the best of my knowledge.</p>

                                                    <div class="form-check mt-3">
                                                        <input class="form-check-input" name="check_in_status" type="checkbox" id="declarationCheck" required>
                                                        <label class="form-check-label" for="declarationCheck">
                                                            I agree to the above declaration.
                                                        </label>
                                                    </div>

                                                    <button type="submit" class="btn btn-primary mt-3">Submit Request</button>
                                                </div>
                                            </form>
                                        `;
                                        } else if (type === 'update-profile') {
                                            html = `
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label>Full Name</label>
                                                        <input type="text" name="name" value="{{ $employee->name ?? '' }}" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>Email</label>
                                                        <input type="email" name="email" value="{{ $employee->email ?? '' }}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label>Phone</label>
                                                        <input type="text" name="phone_number" value="{{ $employee->phone_number ?? '' }}" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>Current Address Line 1</label>
                                                        <input type="text" name="current_address_line1" value="{{ $employee->current_address_line1 ?? '' }}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label>Current Address Line 2</label>
                                                        <input type="text" name="current_address_line2" value="{{ $employee->current_address_line2 ?? '' }}" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>City</label>
                                                        <input type="text" name="current_city" value="{{ $employee->current_city ?? '' }}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label>State</label>
                                                        <input type="text" name="current_state" value="{{ $employee->current_state ?? '' }}" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label>District</label>
                                                        <input type="text" name="current_district" value="{{ $employee->current_district ?? '' }}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label>PIN Code</label>
                                                        <input type="text" name="current_pin" value="{{ $employee->current_pin ?? '' }}" class="form-control">
                                                    </div>
                                                </div>

                                                <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                                            `;
                                        }




                                        container.innerHTML = html;
                                    }
                                </script>


                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endsection

    @section('styles')
        <style>
            .form-container {
                background-color: #ffffff;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
                max-width: 700px;
                margin: 0 auto;
            }

            .form-container h1 {
                font-size: 26px;
                font-weight: 700;
                color: #333;
                margin-bottom: 25px;
                text-align: center;
            }

            .form-container label {
                font-weight: 600;
                color: #444;
                display: block;
                margin-bottom: 6px;
            }

            .form-control {
                width: 50%;
                padding: 10px 14px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 6px;
                font-size: 15px;
                transition: border-color 0.2s ease;
            }

            .form-control:focus {
                border-color: #007bff;
                outline: none;
            }

            .form-container textarea.form-control {
                resize: vertical;
                min-height: 100px;
            }

            .btn-submit {
                background-color: #007bff;
                color: white;
                font-weight: 600;
                padding: 12px 25px;
                border: none;
                border-radius: 6px;
                transition: background-color 0.3s ease;
                width: 100%;
            }

            .btn-submit:hover {
                background-color: #0056b3;
            }

            .alert-success {
                background-color: #d4edda;
                color: #155724;
                padding: 10px 15px;
                border-left: 5px solid #28a745;
                margin-bottom: 20px;
                border-radius: 6px;
            }

            .text-danger {
                color: #e3342f;
            }

            @media (max-width: 768px) {
                .form-container {
                    padding: 20px;
                }
            }
        </style>
    @endsection
