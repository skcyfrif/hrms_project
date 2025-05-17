@extends('hr_head.hr_head_dashboard')
@section('hr_head')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="row profile-body">
            <!-- Middle Wrapper Start -->
            <div class="col-md-12 col-xl-12 middle-wrapper">
                {{-- <li class="breadcrumb-item"> --}}
                <button onclick="window.history.back();" class="btn btn-secondary">
                    Back
                </button>
                {{-- </li> --}}
                <div class="row">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-5">
                            <h6 class="card-title text-center mb-4">Add or Edit Hr Manager Details</h6>

                            <!-- Form Start -->
                            <form method="POST" action="{{ route('store.hrmanager') }}" class="forms-sample"
                                id="employeeForm" enctype="multipart/form-data">
                                @csrf

                                <!-- Step 1: Employee Details -->
                                <div class="form-step" id="step-1">

                                    {{-- Basic Information --}}

                                    <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Basic Information</h3>
                                    <div class="row mb-4">
                                        @if (!$hasRecords)
                                            <div class="col-md-4 mb-3">
                                                <label for="employee_id"
                                                    class="form-label @error('employee_id') is-invalid @enderror">Employee
                                                    ID</label>
                                                <input type="text" class="form-control" id="employee_id"
                                                    name="employee_id" value="{{ old('employee_id') }}">
                                                @error('employee_id')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        @endif

                                        <div class="col-md-4 mb-3">
                                            <label for="name"
                                                class="form-label @error('name') is-invalid @enderror">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name') }}"
                                                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
                                            @error('name')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="photo"
                                                class="form-label @error('photo') is-invalid @enderror">Photo</label>
                                            <input type="file" class="form-control" id="photo" name="photo"
                                                value="{{ old('photo') }}">
                                            @error('photo')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="email"
                                                class="form-label @error('email') is-invalid @enderror">Email</label>
                                            <input type="text" class="form-control" id="email" name="email"
                                                value="{{ old('email') }}">
                                            @error('email')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="phone_number"
                                                class="form-label @error('phone_number') is-invalid @enderror">Phone
                                                Number</label>
                                            <input type="text" class="form-control" id="phone_number" name="phone_number"
                                                value="{{ old('phone_number') }}" value="{{ old('phone_number') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="10">
                                            @error('phone_number')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="dob" class="form-label @error('dob') is-invalid @enderror">Date
                                                of Birth</label>
                                            <input type="date" class="form-control" id="dob" name="dob"
                                                value="{{ old('dob') }}">
                                            @error('dob')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="gender"
                                                class="form-label @error('gender') is-invalid @enderror">Gender</label>
                                            <select class="form-control" id="gender" name="gender"
                                                value="{{ old('gender') }}">
                                                <option value="disable">- - -Select- - -</option>
                                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                                </option>
                                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>
                                                    Female</option>
                                            </select>
                                            @error('gender')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Contact Information --}}


                                        <h3 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">Contact Information
                                        </h3>
                                        {{-- <div class="col-md-4">
                                        <label for="permanent_address" class="form-label @error('permanent_address') is-invalid @enderror">Permanent Address</label>
                                        <textarea class="form-control" id="permanent_address" name="permanent_address" value="{{ old('permanent_address') }}"></textarea>
                                        @error('permanent_address')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                        <h3 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">Permanent Address</h3>

                                        <div class="col-md-4">
                                            <label for="permanent_address_line1"
                                                class="form-label @error('permanent_address_line1') is-invalid @enderror">Address
                                                Line 1</label>
                                            <input type="text" class="form-control" id="permanent_address_line1"
                                                name="permanent_address_line1"
                                                value="{{ old('permanent_address_line1') }}">
                                            @error('permanent_address_line1')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="permanent_address_line2"
                                                class="form-label @error('permanent_address_line2') is-invalid @enderror">Address
                                                Line 2</label>
                                            <input type="text" class="form-control" id="permanent_address_line2"
                                                name="permanent_address_line2"
                                                value="{{ old('permanent_address_line2') }}">
                                            @error('permanent_address_line2')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="permanent_city"
                                                class="form-label @error('permanent_city') is-invalid @enderror">City</label>
                                            <input type="text" class="form-control" id="city"
                                                name="permanent_city" value="{{ old('permanent_city') }}">
                                            @error('permanent_city')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="permanent_district"
                                                class="form-label @error('permanent_district') is-invalid @enderror">District</label>
                                            <input type="text" class="form-control" id="permanent_district"
                                                name="permanent_district" value="{{ old('permanent_district') }}">
                                            @error('permanent_district')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="permanent_state"
                                                class="form-label @error('permanent_state') is-invalid @enderror">State</label>
                                            <input type="text" class="form-control" id="permanent_state"
                                                name="permanent_state" value="{{ old('permanent_state') }}">
                                            @error('permanent_state')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="permanent_pin"
                                                class="form-label @error('permanent_pin') is-invalid @enderror">Pin
                                                Code</label>
                                            <input type="text" class="form-control" id="permanent_pin"
                                                name="permanent_pin" value="{{ old('permanent_pin') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="6">
                                            @error('permanent_pin')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Current Address Section -->
                                        <h3 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">Current Address</h3>

                                        <div class="col-md-4">
                                            <label for="current_address_line1"
                                                class="form-label @error('current_address_line1') is-invalid @enderror">Current
                                                Address Line 1</label>
                                            <input type="text" class="form-control" id="current_address_line1"
                                                name="current_address_line1" value="{{ old('current_address_line1') }}">
                                            @error('current_address_line1')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="current_address_line2"
                                                class="form-label @error('current_address_line2') is-invalid @enderror">Current
                                                Address Line 2</label>
                                            <input type="text" class="form-control" id="current_address_line2"
                                                name="current_address_line2" value="{{ old('current_address_line2') }}">
                                            @error('current_address_line2')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="current_city"
                                                class="form-label @error('current_city') is-invalid @enderror">Current
                                                City</label>
                                            <input type="text" class="form-control" id="current_city"
                                                name="current_city" value="{{ old('current_city') }}">
                                            @error('current_city')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="current_district"
                                                class="form-label @error('current_district') is-invalid @enderror">Current
                                                District</label>
                                            <input type="text" class="form-control" id="current_district"
                                                name="current_district" value="{{ old('current_district') }}">
                                            @error('current_district')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="current_state"
                                                class="form-label @error('current_state') is-invalid @enderror">Current
                                                State</label>
                                            <input type="text" class="form-control" id="current_state"
                                                name="current_state" value="{{ old('current_state') }}">
                                            @error('current_state')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label for="current_pin"
                                                class="form-label @error('current_pin') is-invalid @enderror">Current Pin
                                                Code</label>
                                            <input type="text" class="form-control" id="current_pin"
                                                name="current_pin" value="{{ old('current_pin') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="6">
                                            @error('current_pin')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        {{-- <div class="col-md-4">
                                        <label for="current_address" class="form-label @error('current_address') is-invalid @enderror">Current Address</label>
                                        <textarea class="form-control" id="current_address" name="current_address" value="{{ old('current_address') }}"></textarea>
                                        @error('current_address')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                        <div class="col-md-4">
                                            <label for="emergency_contact"
                                                class="form-label @error('emergency_contact') is-invalid @enderror">Emergency
                                                Contact</label>
                                            <input type="text" class="form-control" id="emergency_contact"
                                                name="emergency_contact" value="{{ old('emergency_contact') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="10">
                                            @error('emergency_contact')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Employment Details --}}


                                        <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Employee Details
                                        </h3>
                                        <div class="col-md-4 mb-3">
                                            <label for="designation"
                                                class="form-label @error('designation') is-invalid @enderror">Designation</label>
                                            <input type="text" class="form-control" id="designation"
                                                name="designation" value="{{ old('designation') }}">
                                            @error('designation')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="department"
                                                class="form-label @error('department') is-invalid @enderror">Department</label>
                                            <input type="text" class="form-control" id="department" name="department"
                                                value="{{ old('department') }}">
                                            @error('department')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="work_location"
                                                class="form-label @error('work_location') is-invalid @enderror">Work
                                                Location</label>
                                            <input type="text" class="form-control" id="work_location"
                                                name="work_location" value="{{ old('work_location') }}">
                                            @error('work_location')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="doj"
                                                class="form-label @error('doj') is-invalid @enderror">Date of
                                                Joining</label>
                                            <input type="date" class="form-control" id="doj" name="doj"
                                                value="{{ old('doj') }}">
                                            @error('doj')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="employment_type"
                                                class="form-label @error('employment_type') is-invalid @enderror">Employment
                                                Type</label>
                                            <select class="form-control @error('employment_type') is-invalid @enderror"
                                                id="employment_type" name="employment_type">
                                                <option value="">- - - Select - - -</option>
                                                <option value="permanent"
                                                    {{ old('employment_type') == 'permanent' ? 'selected' : '' }}>Full-time
                                                </option>
                                                <option value="non_permanent"
                                                    {{ old('employment_type') == 'non_permanent' ? 'selected' : '' }}>
                                                    Intern</option>
                                            </select>
                                            @error('employment_type')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="created_by"
                                                class="form-label @error('created_by') is-invalid @enderror">Created
                                                By</label>
                                            <input type="hidden" class="form-control" id="created_by" name="created_by"
                                                value="{{ auth()->user()->id }}" readonly>
                                            <input type="text" class="form-control" id="created_by"
                                                value="{{ auth()->user()->name }}" readonly>
                                            @error('created_by')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>


                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-primary px-4 py-2"
                                            id="next-1">Next</button>
                                    </div>
                                </div>

                                <!-- Step 2: Additional Details -->
                                <div class="form-step" id="step-2" style="display: none;">

                                    <div class="row mb-4">

                                        {{-- Bank Details --}}
                                        <h3 style="color: red; margin-top: 1cm;">Bank Details</h3>
                                        <div class="col-md-4">
                                            <label for="account_number"
                                                class="form-label @error('account_number') is-invalid @enderror">Account
                                                Number</label>
                                            <input type="text" class="form-control" id="account_number"
                                                name="account_number" value="{{ old('account_number') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="18">
                                            @error('account_number')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="ifsc_code"
                                                class="form-label @error('ifsc_code') is-invalid @enderror">IFSC
                                                CODE</label>
                                            <input type="text" class="form-control" id="ifsc_code" name="ifsc_code"
                                                value="{{ old('ifsc_code') }}"
                                                oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '')"
                                                maxlength="11">
                                            @error('ifsc_code')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="bank_name"
                                                class="form-label @error('bank_name') is-invalid @enderror">Bank
                                                Name</label>
                                            <input type="text" class="form-control" id="bank_name" name="bank_name"
                                                value="{{ old('bank_name') }}">
                                            @error('bank_name')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="branch_name"
                                                class="form-label @error('branch_name') is-invalid @enderror">Branch
                                                Name</label>
                                            <input type="text" class="form-control" id="branch_name"
                                                name="branch_name" value="{{ old('branch_name') }}">
                                            @error('branch_name')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <h3 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">Compensation Details
                                        </h3>
                                        <div class="col-md-4">
                                            <label for="types"
                                                class="form-label @error('types') is-invalid @enderror">Types</label>
                                            <select class="form-control @error('types') is-invalid @enderror"
                                                id="types" name="types">
                                                <option value="">-- Select --</option>
                                                <option value="salary" {{ old('types') == 'salary' ? 'selected' : '' }}>
                                                    Salary</option>
                                                <option value="stipend" {{ old('types') == 'stipend' ? 'selected' : '' }}>
                                                    Stipend</option>
                                                <option value="consolidated_ammount"
                                                    {{ old('types') == 'consolidated_ammount' ? 'selected' : '' }}>
                                                    Consolidated Ammount</option>
                                            </select>
                                            @error('types')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!-- New Fields for Stipend -->
                                        {{-- <div class="col-md-4 stipend-fields" style="display: none;">
                                        <label for="stipend_amount" class="form-label @error('stipend_amount') is-invalid @enderror">Stipend Amount</label>
                                        <input type="text" class="form-control" id="stipend_amount" name="stipend_amount" value="{{ old('stipend_amount') }}">
                                        @error('stipend_amount')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 stipend-fields" style="display: none;">
                                        <label for="bonuses" class="form-label @error('bonuses') is-invalid @enderror">Bonuses</label>
                                        <input type="text" class="form-control" id="bonuses" name="bonuses" value="{{ old('bonuses') }}">
                                        @error('bonuses')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                        <!-- New Fields for Consolidated Amount -->
                                        {{-- <div class="col-md-4 consolidated-fields" style="display: none;">
                                        <label for="consolidated_pay" class="form-label @error('consolidated_pay') is-invalid @enderror">Consolidated Pay</label>
                                        <input type="text" class="form-control" id="consolidated_pay" name="extra_allowance" value="{{ old('extra_allowance') }}">
                                        @error('consolidated_pay')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 consolidated-fields" style="display: none;">
                                        <label for="extra_allowance" class="form-label @error('extra_allowance') is-invalid @enderror">Extra Allowance</label>
                                        <input type="text" class="form-control" id="extra_allowance" name="extra_allowance" value="{{ old('extra_allowance') }}">
                                        @error('extra_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div> --}}

                                        <div class="col-md-4">
                                            <label for="pay_cycle"
                                                class="form-label @error('pay_cycle') is-invalid @enderror">Pay
                                                Cycle</label>
                                            <select class="form-control @error('pay_cycle') is-invalid @enderror"
                                                id="pay_cycle" name="pay_cycle">
                                                <option value="">- - - Select - - -</option>
                                                <option value="monthly"
                                                    {{ old('pay_cycle') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                                <option value="weekly"
                                                    {{ old('pay_cycle') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                                <option value="bi-weekly"
                                                    {{ old('pay_cycle') == 'bi-weekly' ? 'selected' : '' }}>Bi-weekly
                                                </option>
                                            </select>
                                            @error('pay_cycle')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="total_leave_allowed"
                                                class="form-label @error('total_leave_allowed') is-invalid @enderror">Total
                                                Leave Allowed</label>
                                            <input type="text" class="form-control" id="total_leave_allowed"
                                                name="total_leave_allowed" value="{{ old('total_leave_allowed') }}">
                                            @error('total_leave_allowed')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 salary-fields">
                                            <label for="basic_salary"
                                                class="form-label @error('basic_salary') is-invalid @enderror">Basic
                                                Salary</label>
                                            <input type="text" class="form-control" id="basic_salary"
                                                name="basic_salary" value="{{ old('basic_salary') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            @error('basic_salary')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 salary-fields">
                                            <label for="house_rent_allowance"
                                                class="form-label @error('house_rent_allowance') is-invalid @enderror">House
                                                Rent Allowance</label>
                                            <input type="text" class="form-control" id="house_rent_allowance"
                                                name="house_rent_allowance" value="{{ old('house_rent_allowance') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                                            @error('house_rent_allowance')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 salary-fields">
                                            <label for="conveyance_allowance"
                                                class="form-label @error('conveyance_allowance') is-invalid @enderror">Conveyance
                                                Allowance</label>
                                            <input type="text" class="form-control" id="conveyance_allowance"
                                                name="conveyance_allowance" value="{{ old('conveyance_allowance') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                                            @error('conveyance_allowance')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 salary-fields">
                                            <label for="lunch_allowance"
                                                class="form-label @error('lunch_allowance') is-invalid @enderror">Lunch
                                                Allowance</label>
                                            <input type="text" class="form-control" id="lunch_allowance"
                                                name="lunch_allowance" value="{{ old('lunch_allowance') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                                            @error('lunch_allowance')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 salary-fields">
                                            <label for="personal_pay"
                                                class="form-label @error('personal_pay') is-invalid @enderror">Personal
                                                Pay</label>
                                            <input type="text" class="form-control" id="personal_pay"
                                                name="personal_pay" value="{{ old('personal_pay') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                                            @error('personal_pay')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 salary-fields">
                                            <label for="medical_allowance"
                                                class="form-label @error('medical_allowance') is-invalid @enderror">Medical
                                                Allowance</label>
                                            <input type="text" class="form-control" id="medical_allowance"
                                                name="medical_allowance" value="{{ old('medical_allowance') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                                            @error('medical_allowance')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 salary-fields">
                                            <label for="other_allowance"
                                                class="form-label @error('other_allowance') is-invalid @enderror">Other
                                                Allowance</label>
                                            <input type="text" class="form-control" id="other_allowance"
                                                name="other_allowance" value="{{ old('other_allowance') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                                            @error('other_allowance')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4 salary-fields">
                                            <label for="leave_travel_allowance"
                                                class="form-label @error('leave_travel_allowance') is-invalid @enderror">Leave
                                                Travel Allowance</label>
                                            <input type="text" class="form-control" id="leave_travel_allowance"
                                                name="leave_travel_allowance"
                                                value="{{ old('leave_travel_allowance') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                                            @error('leave_travel_allowance')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        {{-- Total Ammount --}}
                                        <div class="row mb-4 salary-fields">
                                            <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Total Ammount
                                            </h3>
                                            <div class="col-md-4">
                                                <label for="total_ammount"
                                                    class="form-label @error('total_ammount') is-invalid @enderror">Total
                                                    Ammount</label>
                                                <input type="text" class="form-control" id="total_ammount"
                                                    name="total_ammount" value="{{ old('total_ammount') }}" readonly>
                                                @error('total_ammount')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Deductions --}}
                                        <div class="row mb-4 salary-fields">
                                            <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Deductions</h3>
                                            <div class="col-md-6">
                                                {{-- <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Deductions</h3> --}}
                                                <label for="professional_tax"
                                                    class="form-label @error('professional_tax') is-invalid @enderror">Professional
                                                    Tax</label>
                                                <input type="text" class="form-control" id="professional_tax"
                                                    name="professional_tax" value="{{ old('professional_tax') }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">

                                                @error('professional_tax')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 salary-fields">
                                                <label for="esic"
                                                    class="form-label @error('esic') is-invalid @enderror">ESIC</label>
                                                <input type="text" class="form-control" id="esic" name="esic"
                                                    value="{{ old('esic') }}"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                @error('esic')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        {{-- Net Salary --}}
                                        <div class="row mb-4 salary-fields">
                                            <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Net Salary</h3>
                                            <div class="col-md-6">
                                                <label for="net_salary_payable"
                                                    class="form-label @error('net_salary_payable') is-invalid @enderror">Net
                                                    Salary Payable</label>
                                                <input type="text" class="form-control" id="net_salary_payable"
                                                    name="net_salary_payable" value="{{ old('net_salary_payable') }}"
                                                    readonly>
                                                @error('net_salary_payable')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- System Access --}}

                                        <div class="row mb-4">
                                            <h3 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">System Access
                                            </h3>

                                            <div class="col-md-4">
                                                <label for="user_role"
                                                    class="form-label @error('user_role') is-invalid @enderror">User
                                                    Role</label>
                                                <select class="form-control" id="user_role" name="user_role"
                                                    value="{{ old('user_role') }}">
                                                    <option value="disable">- - -Select- - -</option>
                                                    {{-- <option value="head">HR Head</option> --}}
                                                    <option value="manager">HR Manager</option>
                                                    {{-- <option value="user">User</option> --}}
                                                </select>
                                                @error('user_role')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-4">
                                                <label for="username"
                                                    class="form-label @error('username') is-invalid @enderror">Username</label>
                                                <select class="form-control" id="username" name="username"
                                                    value="{{ old('username') }}">
                                                    <option value="disable">- - -Select- - -</option>
                                                    {{-- <option value="hr_head">HR Head</option> --}}
                                                    <option value="hr_manager">HR Manager</option>
                                                    {{-- <option value="user">User</option> --}}
                                                </select>
                                                @error('username')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-4">
                                                <label for="password"
                                                    class="form-label @error('password') is-invalid @enderror">Password</label>
                                                <input type="text" class="form-control" id="password"
                                                    name="password" value="{{ old('password') }}">
                                                @error('password')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <!-- Back Button -->
                                            <button type="button" class="btn btn-secondary px-4 py-2"
                                                id="back-2">Back</button>
                                            <!-- Submit Button -->
                                            <button type="submit" class="btn btn-success px-4 py-2">Submit</button>
                                        </div>
                                    </div>

                                    <!-- Step 3: Final Step (If needed) -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // $(document).ready(function () {
        //         // Listen for change event on the employee_id dropdown
        //         $('#employee_id').on('change', function () {
        //             var employee_id = $(this).val();  // Get the selected employee_id

        //             // If the selected employee_id is not "disabled", send an AJAX request
        //             if (employee_id !== 'disabled') {
        //                 $.ajax({
        //                     url: '/hrmanager/details/' + employee_id,  // Call the employee details endpoint
        //                     method: 'GET',
        //                     success: function (response) {
        //                         if (response.success) {
        //                             // Populate the fields with the returned employee data
        //                             $('#name').val(response.data.name);
        //                             $('#department').val(response.data.department);
        //                             $('#designation').val(response.data.designation);
        //                             $('#email').val(response.data.email);
        //                             $('#phone_number').val(response.data.phone_number);
        //                             $('#account_number').val(response.data.account_number);
        //                             $('#ifsc_code').val(response.data.ifsc_code);
        //                             $('#bank_name').val(response.data.bank_name);
        //                             $('#branch_name').val(response.data.branch_name);
        //                             $('#basic_salary').val(response.data.basic_salary);
        //                         } else {
        //                             // Clear the fields if no employee data is found
        //                             $('#name').val('');
        //                             $('#department').val('');
        //                             $('#designation').val('');
        //                             $('#email').val('');
        //                             $('#phone_number').val('');
        //                             $('#account_number').val('');
        //                             $('#ifsc_code').val('');
        //                             $('#bank_name').val('');
        //                             $('#branch_name').val('');
        //                             $('#basic_salary').val('');

        //                             alert(response.message);  // Show an alert if employee not found
        //                         }
        //                     },
        //                     error: function () {
        //                         alert('Error fetching employee data.');
        //                     }
        //                 });
        //             } else {
        //                 // Clear the fields if no employee is selected
        //                 $('#name').val('');
        //                 $('#department').val('');
        //                 $('#designation').val('');
        //                 $('#email').val('');
        //                 $('#phone_number').val('');
        //             }
        //         });
        //     });


        $(document).ready(function() {
            // Go to Step 2
            $('#next-1').click(function() {
                $('#step-1').hide();
                $('#step-2').show();
            });

            // Go Back to Step 1
            $('#back-2').click(function() {
                $('#step-2').hide();
                $('#step-1').show();
            });
        });


        $(document).ready(function() {
            // Function to update Total Amount and Net Salary
            function updatePayslipValues() {
                // Calculate Total Amount
                var totalAmount = 0;
                $('#basic_salary, #house_rent_allowance, #conveyance_allowance, #lunch_allowance, #personal_pay, #medical_allowance, #other_allowance, #leave_travel_allowance')
                    .each(function() {
                        totalAmount += parseFloat($(this).val()) || 0;
                    });
                $('#total_ammount').val(totalAmount.toFixed(2));

                // Calculate Net Salary
                var deductions = 0;
                $('#professional_tax, #esic').each(function() {
                    deductions += parseFloat($(this).val()) || 0;
                });
                var netSalary = totalAmount - deductions;
                $('#net_salary_payable').val(netSalary.toFixed(2));
            }

            // Trigger updates whenever an input field changes
            $('#basic_salary, #house_rent_allowance, #conveyance_allowance, #lunch_allowance, #personal_pay, #medical_allowance, #other_allowance, #leave_travel_allowance, #professional_tax, #esic')
                .on('input', updatePayslipValues);
        });
    </script>
@endsection


















{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function toggleFields() {
            var selectedType = $("#types").val();

            if (selectedType === "stipend" || selectedType === "consolidated_ammount") {
                $(".salary-fields").hide(); // Hide all salary-related fields
            } else {
                $(".salary-fields").show(); // Show them for "salary"
            }
        }

        // Run on page load (to handle pre-selected values)
        toggleFields();

        // Run when the dropdown value changes
        $("#types").change(function () {
            toggleFields();
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        function toggleFields() {
            var selectedType = $("#types").val();

            if (selectedType === "stipend" || selectedType === "consolidated_ammount") {
                $(".salary-fields").hide(); // Hide all salary-related fields
            } else {
                $(".salary-fields").show(); // Show them for "salary"
            }
        }

        // Run on page load (to handle pre-selected values)
        toggleFields();

        // Run when the dropdown value changes
        $("#types").change(function () {
            toggleFields();
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("types").addEventListener("change", function () {
            let selectedType = this.value;

            // Get all fields
            let salaryFields = document.querySelectorAll(".salary-fields");
            let stipendFields = document.querySelectorAll(".stipend-fields");
            let consolidatedFields = document.querySelectorAll(".consolidated-fields");

            // Hide all fields initially
            salaryFields.forEach(field => field.style.display = "none");
            stipendFields.forEach(field => field.style.display = "none");
            consolidatedFields.forEach(field => field.style.display = "none");

            // Show fields based on selected type
            if (selectedType === "salary") {
                salaryFields.forEach(field => field.style.display = "block");
            } else if (selectedType === "stipend") {
                stipendFields.forEach(field => field.style.display = "block");
            } else if (selectedType === "consolidated_ammount") {
                consolidatedFields.forEach(field => field.style.display = "block");
            }
        });
    });
</script> --}}
