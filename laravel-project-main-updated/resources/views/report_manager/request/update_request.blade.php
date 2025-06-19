@extends('report_manager.report_manager_dashboard')
@section('report_manager')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
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

                            <form method="POST" action="{{ route('form.submits') }}">
                                @csrf

                                <div class="mb-4">
                                    <label for="requestType">Select Request Type</label>
                                    <select id="requestType" name="request_type" class="form-control"
                                        onchange="handleRequestChange(this)">
                                        <option value="">-- Select --</option>
                                        <option value="salary-increment">Salary Increment</option>
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
                                        // if (selected === 'make-permanent') {
                                        //     window.location.href = "{{ route('make.permanent.form') }}"; // redirects to new page
                                        // } else {
                                        //     showForm(selected);
                                        // }
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
