@extends('admin.admin_dashboard')
@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



<div class="page-content">
    <div class="row profile-body">
        <!-- Middle Wrapper Start -->
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <nav class="page-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <button onclick="window.history.back();" class="btn btn-secondary">
                            Back
                        </button>
                    </li>

                    {{-- <li class="breadcrumb-item active" aria-current="page">
                        Employees Created by {{ $hrManager->name }}
                    </li> --}}
                </ol>
            </nav>
            <div class="row">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <h6 class="card-title text-center mb-4">View Hr Head Details</h6>

                        <!-- Employee Details -->
                        <div class="row mb-4">
                            <!-- Basic Information -->
                            <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Basic Information</h3>
                            <div class="col-md-4 mb-3">
                                <label for="employee_id" class="form-label">Employee ID</label>
                                <input type="text" class="form-control" value="{{ $test->employee_id }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" value="{{ $test->name }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="photo" class="form-label">Photo</label>

                                <!-- Show the image if available -->
                                @if($test->photo)
                                    <img src="{{ asset($test->photo) }}" alt="Employee Photo" style="width: 150px; height: auto;">
                                @else
                                    <p>No photo available</p>
                                @endif
                            </div>



                            <div class="col-md-4 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" value="{{ $test->email }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" value="{{ $test->phone_number }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="text" class="form-control" value="{{ $test->dob }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <input type="text" class="form-control" value="{{ $test->gender }}" readonly>
                            </div>

                            <!-- Contact Information -->
                            <h3 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">Contact Information</h3>
                            <h5 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">Permanent Address</h5>

                            <!-- Permanent Address Section -->
                            <div class="col-md-4 mb-3">
                                <label for="permanent_address_line1" class="form-label">Permanent Address Line 1</label>
                                <input type="text" class="form-control" id="permanent_address_line1" name="permanent_address_line1" value="{{ $test->permanent_address_line1 }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="permanent_address_line2" class="form-label">Permanent Address Line 2</label>
                                <input type="text" class="form-control" id="permanent_address_line2" name="permanent_address_line2" value="{{ $test->permanent_address_line2 }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="permanent_city" class="form-label">Permanent City</label>
                                <input type="text" class="form-control" id="permanent_city" name="permanent_city" value="{{ $test->permanent_city }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="permanent_district" class="form-label">Permanent District</label>
                                <input type="text" class="form-control" id="permanent_district" name="permanent_district" value="{{ $test->permanent_district }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="permanent_state" class="form-label">Permanent State</label>
                                <input type="text" class="form-control" id="permanent_state" name="permanent_state" value="{{ $test->permanent_state }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="permanent_pin" class="form-label">Permanent Pin Code</label>
                                <input type="text" class="form-control" id="permanent_pin" name="permanent_pin" value="{{ $test->permanent_pin }}" readonly>
                            </div>

                            <!-- Current Address Section -->
                            <h5 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">Current Address</h5>

                            <div class="col-md-4 mb-3">
                                <label for="current_address_line1" class="form-label">Current Address Line 1</label>
                                <input type="text" class="form-control" id="current_address_line1" name="current_address_line1" value="{{ $test->current_address_line1 }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="current_address_line2" class="form-label">Current Address Line 2</label>
                                <input type="text" class="form-control" id="current_address_line2" name="current_address_line2" value="{{ $test->current_address_line2 }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="current_city" class="form-label">Current City</label>
                                <input type="text" class="form-control" id="current_city" name="current_city" value="{{ $test->current_city }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="current_district" class="form-label">Current District</label>
                                <input type="text" class="form-control" id="current_district" name="current_district" value="{{ $test->current_district }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="current_state" class="form-label">Current State</label>
                                <input type="text" class="form-control" id="current_state" name="current_state" value="{{ $test->current_state }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="current_pin" class="form-label">Current Pin Code</label>
                                <input type="text" class="form-control" id="current_pin" name="current_pin" value="{{ $test->current_pin }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="emergency_contact" class="form-label">Emergency Contact</label>
                                <textarea class="form-control" readonly>{{ $test->emergency_contact }}</textarea>
                            </div>

                            <!-- Employment Details -->
                            <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Employment Details</h3>
                            <div class="col-md-4 mb-3">
                                <label for="designation" class="form-label">Designation</label>
                                <input type="text" class="form-control" value="{{ $test->designation }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" value="{{ $test->department }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="work_location" class="form-label">Work Location</label>
                                <input type="text" class="form-control" value="{{ $test->work_location }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="doj" class="form-label">Date of Joining</label>
                                <input type="text" class="form-control" value="{{ $test->doj }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="employment_type" class="form-label">Employment Type</label>
                                <input type="text" class="form-control" value="{{ $test->employment_type }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="created_by" class="form-label">Created By</label>
                                <input type="text" class="form-control" value="{{ $test->created_by }}" readonly>
                            </div>


                            <!-- Bank Details-->
                            <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Bank Details</h3>
                            <div class="col-md-4 mb-3">
                                <label for="account_number" class="form-label">Account Number</label>
                                <input type="text" class="form-control" value="{{ $test->account_number }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="ifsc_code" class="form-label">IFSC CODE</label>
                                <input type="text" class="form-control" value="{{ $test->ifsc_code }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="bank_name" class="form-label">Bank Name</label>
                                <input type="text" class="form-control" value="{{ $test->bank_name }}" readonly>
                            </div>



                            <!-- Compensation Details -->
                            <h3 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">Compensation Details</h3>
                            <div class="col-md-4 mb-3">
                                <label for="types" class="form-label">Types</label>
                                <input type="text" class="form-control" value="{{ $test->types }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="pay_cycle" class="form-label">Pay Cycle</label>
                                <input type="text" class="form-control" value="{{ $test->pay_cycle }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="total_leave_allowed" class="form-label">Total Leave Allowed</label>
                                <input type="text" class="form-control" value="{{ $test->total_leave_allowed }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="basic_salary" class="form-label">Basic Salary</</label>
                                <input type="text" class="form-control" value="{{ $test->basic_salary }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="house_rent_allowance" class="form-label">House Rent Allowance</label>
                                <input type="text" class="form-control" value="{{ $test->house_rent_allowance }}" readonly>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="conveyance_allowance" class="form-label">Conveyance Allowance</label>
                                <input type="text" class="form-control" value="{{ $test->conveyance_allowance }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="lunch_allowance" class="form-label">Lunch Allowance</label>
                                <input type="text" class="form-control" value="{{ $test->lunch_allowance }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="personal_pay" class="form-label">Personal Pay</label>
                                <input type="text" class="form-control" value="{{ $test->personal_pay }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="medical_allowance" class="form-label">Medical Allowance</label>
                                <input type="text" class="form-control" value="{{ $test->medical_allowance }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="other_allowance" class="form-label">Other Allowance</label>
                                <input type="text" class="form-control" value="{{ $test->other_allowance }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="leave_travel_allowance" class="form-label">Leave Travel Allowance</label>
                                <input type="text" class="form-control" value="{{ $test->leave_travel_allowance }}" readonly>
                            </div>


                                {{-- Total Ammount --}}
                            <div class="col-md-4 mb-3">
                                <label for="total_ammount" class="form-label">Total Ammount</label>
                                <input type="text" class="form-control" value="{{ $test->total_ammount }}" readonly>
                            </div>
                            {{-- Deductions --}}
                            <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Deductions</h3>
                            <div class="col-md-4 mb-3">
                                <label for="professional_tax" class="form-label">Professional Tax</label>
                                <input type="text" class="form-control" value="{{ $test->professional_tax }}" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="esic" class="form-label">ESIC</label>
                                <input type="text" class="form-control" value="{{ $test->esic }}" readonly>
                            </div>


                            {{-- Net Salary --}}
                            <div class="col-md-4 mb-3">
                                <label for="net_salary_payable" class="form-label">Net Salary</label>
                                <input type="text" class="form-control" value="{{ $test->net_salary_payable }}" readonly>
                            </div>

                        </div>

                            <!-- System Access -->
                        <div class="row mb-4">
                            <h3 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">System Access</h3>
                            <div id="system-access">
                                <div class="col-md-4">
                                    <label for="user_role" class="form-label">User Role</label>
                                    <input type="text" class="form-control" value="{{ $test->user_role }}" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" value="{{ $test->username }}" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control" value="{{ $test->password }}" readonly>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="#" class="btn btn-primary px-4 py-2">Back to List</a>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
