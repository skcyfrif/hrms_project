@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="page-content">
    <div class="row profile-body">
        <!-- Middle Wrapper Start -->
        <div class="col-md-12 col-xl-12 middle-wrapper">
            <div class="row">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-5">
                        <h6 class="card-title text-center mb-4">Edit Employee Details</h6>

                        <!-- Form Start -->
                        <form method="POST" action="{{ route('update.employee', $emp->id) }}" class="forms-sample" id="employeeForm">
                            @csrf
                            <div class="form-step" id="step-1">
                            <input type="hidden" name="id" value="{{$emp->id}}">

                            <!-- Step 1: Employee ID and Name -->
                            {{-- <div class="form-step" id="step-1"> --}}
                                <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Basic Information</h3>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label for="employee_id" class="form-label">Employee ID</label>
                                        <input type="text" class="form-control" id="employee_id" name="employee_id"
                                               value="{{$emp->employee_id}}" readonly>
                                        @error('employee_id')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               value="{{ $emp->name }}" required>
                                        @error('name')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-4">
                                        <label for="photo" class="form-label">Photo</label>
                                        <input type="file" class="form-control" id="photo" name="photo"
                                               value="{{ $emp->photo }}" required>
                                        @error('photo')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                        @if(isset($emp->photo))
                                                <div class="mt-2">
                                                <img src="{{ asset($emp->photo) }}" alt="Employee Photo" width="120" height="120">

                                                </div>
                                            @endif

                                    </div>
                                    <div class="col-md-4">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="email" name="email"
                                               value="{{ $emp->email }}" required>
                                        @error('email')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="phone_number" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phone_number" name="phone_number"
                                               value="{{ $emp->phone_number }}" required>
                                        @error('phone_number')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="dob" class="form-label">Date of Birth</label>
                                        <input type="date" class="form-control" id="dob" name="dob"
                                               value="{{ $emp->dob }}" required>
                                        @error('dob')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="gender" class="form-label">Gender</label>
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="male" {{  $emp->gender == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ $emp->gender == 'female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    {{-- Contact Information --}}


                                    <h3 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">Contact Information</h3>
                                    {{-- <div class="col-md-4">
                                        <label for="permanent_address" class="form-label">Permanent Address</label>
                                        <textarea class="form-control" id="permanent_address" name="permanent_address" rows="4" required>{{ $emp->permanent_address }}</textarea>
                                        @error('permanent_address')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div> --}}


                                    <h5 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">Permanent Address</h5>
                                    <div class="col-md-4">

                                        <label for="permanent_address_line1" class="form-label @error('permanent_address_line1') is-invalid @enderror">Permanent Address Line 1</label>
                                        <input type="text" class="form-control" id="permanent_address_line1" name="permanent_address_line1" value="{{ old('permanent_address_line1', $emp->permanent_address_line1) }}" required>
                                        @error('permanent_address_line1')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="permanent_address_line2" class="form-label @error('permanent_address_line2') is-invalid @enderror">Permanent Address Line 2</label>
                                        <input type="text" class="form-control" id="permanent_address_line2" name="permanent_address_line2" value="{{ old('permanent_address_line2', $emp->permanent_address_line2) }}" required>
                                        @error('permanent_address_line2')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="permanent_city" class="form-label @error('permanent_city') is-invalid @enderror">Permanent City</label>
                                        <input type="text" class="form-control" id="permanent_city" name="permanent_city" value="{{ old('permanent_city', $emp->permanent_city) }}" required>
                                        @error('permanent_city')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="permanent_district" class="form-label @error('permanent_district') is-invalid @enderror">Permanent District</label>
                                        <input type="text" class="form-control" id="permanent_district" name="permanent_district" value="{{ old('permanent_district', $emp->permanent_district) }}" required>
                                        @error('permanent_district')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="permanent_state" class="form-label @error('permanent_state') is-invalid @enderror">Permanent State</label>
                                        <input type="text" class="form-control" id="permanent_state" name="permanent_state" value="{{ old('permanent_state', $emp->permanent_state) }}" required>
                                        @error('permanent_state')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="permanent_pin" class="form-label @error('permanent_pin') is-invalid @enderror">Permanent Pin Code</label>
                                        <input type="text" class="form-control" id="permanent_pin" name="permanent_pin" value="{{ old('permanent_pin', $emp->permanent_pin) }}" required>
                                        @error('permanent_pin')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Current Address Section -->
                                    <h5 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">Current Address</h5>

                                    <div class="col-md-4">
                                        <label for="current_address_line1" class="form-label @error('current_address_line1') is-invalid @enderror">Current Address Line 1</label>
                                        <input type="text" class="form-control" id="current_address_line1" name="current_address_line1" value="{{ old('current_address_line1', $emp->current_address_line1) }}" required>
                                        @error('current_address_line1')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="current_address_line2" class="form-label @error('current_address_line2') is-invalid @enderror">Current Address Line 2</label>
                                        <input type="text" class="form-control" id="current_address_line2" name="current_address_line2" value="{{ old('current_address_line2', $emp->current_address_line2) }}" required>
                                        @error('current_address_line2')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="current_city" class="form-label @error('current_city') is-invalid @enderror">Current City</label>
                                        <input type="text" class="form-control" id="current_city" name="current_city" value="{{ old('current_city', $emp->current_city) }}" required>
                                        @error('current_city')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="current_district" class="form-label @error('current_district') is-invalid @enderror">Current District</label>
                                        <input type="text" class="form-control" id="current_district" name="current_district" value="{{ old('current_district', $emp->current_district) }}" required>
                                        @error('current_district')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="current_state" class="form-label @error('current_state') is-invalid @enderror">Current State</label>
                                        <input type="text" class="form-control" id="current_state" name="current_state" value="{{ old('current_state', $emp->current_state) }}" required>
                                        @error('current_state')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label for="current_pin" class="form-label @error('current_pin') is-invalid @enderror">Current Pin Code</label>
                                        <input type="text" class="form-control" id="current_pin" name="current_pin" value="{{ old('current_pin', $emp->current_pin) }}" required>
                                        @error('current_pin')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- <div class="col-md-4">
                                        <label for="current_address" class="form-label">Current Address</label>
                                        <textarea class="form-control" id="current_address" name="current_address" rows="4" required>{{ $emp->current_address }}</textarea>
                                        @error('current_address')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                    <div class="col-md-4">
                                        <label for="emergency_contact" class="form-label">Emergency Contact</label>
                                        <input type="text" class="form-control" id="emergency_contact" name="emergency_contact"
                                               value="{{ $emp->emergency_contact }}">
                                        @error('emergency_contact')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Employment Details --}}


                                    <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Employee Details</h3>
                                    <div class="col-md-4">
                                        <label for="designation" class="form-label">Designation</label>
                                        <input type="text" class="form-control" id="designation" name="designation"
                                               value="{{ $emp->designation }}">
                                        @error('designation')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="department" class="form-label">Department</label>
                                        <input type="text" class="form-control" id="department" name="department"
                                               value="{{ $emp->department }}">
                                        @error('department')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="work_location" class="form-label">Work Location</label>
                                        <input type="text" class="form-control" id="work_location" name="work_location"
                                               value="{{ $emp->work_location }}" required>
                                        @error('work_location')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="doj" class="form-label">Date of Joining</label>
                                        <input type="date" class="form-control" id="doj" name="doj"
                                               value="{{ $emp->doj }}" required>
                                        @error('doj')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="employment_type" class="form-label">Employment Type</label>
                                        <select class="form-control" id="employment_type" name="employment_type" required>
                                            <option value="permanent" {{  $emp->employment_type == 'permanent' ? 'selected' : '' }}>Full-time</option>
                                            <option value="non_permanent" {{ $emp->employment_type == 'non_permanent' ? 'selected' : '' }}>Intern</option>
                                        </select>
                                        @error('employment_type')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="created_by" class="form-label @error('created_by') is-invalid @enderror">Created By</label>
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
                                    <button type="button" class="btn btn-primary px-4 py-2" id="next-1">Next</button>
                                </div>
                            </div>

                            <!-- Step 2: Department, Designation, Employment Type, Work Location -->
                            <div class="form-step" id="step-2" style="display: none;">

                            {{-- bank details --}}
                            <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Bank Details</h3>
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label for="account_number" class="form-label">Account Number</label>
                                    <input type="text" class="form-control" id="account_number" name="account_number"
                                        value="{{ $emp->account_number }}" required>
                                    @error('account_number')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="ifsc_code" class="form-label">IFSC CODE</label>
                                    <input type="text" class="form-control" id="ifsc_code" name="ifsc_code"
                                        value="{{ $emp->ifsc_code }}" required>
                                    @error('ifsc_code')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="bank_name" class="form-label">Bank Name</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name"
                                        value="{{ $emp->bank_name }}" required>
                                    @error('bank_name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="branch_name" class="form-label">Branch Name</label>
                                    <input type="text" class="form-control" id="branch_name" name="branch_name"
                                        value="{{ $emp->branch_name }}" required>
                                    @error('branch_name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <h3 style="color: red; margin-top: 1cm;margin-bottom: 0.5cm;">Compensation Details</h3>
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label for="types" class="form-label">Types</label>
                                        <select class="form-control" id="types" name="types" required>
                                            <option value="salary" {{  $emp->types == 'salary' ? 'selected' : '' }}>Salary</option>
                                            <option value="stipend" {{ $emp->types == 'stipend' ? 'selected' : '' }}>Stipend</option>
                                            <option value="consolidated_ammount" {{ $emp->types == 'consolidated_ammount' ? 'selected' : '' }}>Consolidated Ammount</option>
                                        </select>
                                        @error('types')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                            <!-- New Fields for Stipend -->
                                    <div class="col-md-4 stipend-fields" style="display: none;">
                                        <label for="stipend_amount" class="form-label">Stipend Amount</label>
                                        <input type="text" class="form-control" id="stipend_amount" name="stipend_amount"
                                               value="{{ $emp->stipend_amount }}">
                                        @error('stipend_amount')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 stipend-fields" style="display: none;">
                                        <label for="bonuses" class="form-label">Bonuses</label>
                                        <input type="text" class="form-control" id="bonuses" name="bonuses"
                                               value="{{ $emp->bonuses }}">
                                        @error('bonuses')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <!-- New Fields for Consolidated Amount -->
                                    <div class="col-md-4 consolidated-fields" style="display: none;">
                                        <label for="consolidated_pay" class="form-label">Consolidated Pay</label>
                                        <input type="text" class="form-control" id="consolidated_pay" name="consolidated_pay"
                                               value="{{ $emp->consolidated_pay }}">
                                        @error('consolidated_pay')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 consolidated-fields" style="display: none;">
                                        <label for="extra_allowance" class="form-label">Extra Allowance</label>
                                        <input type="text" class="form-control" id="extra_allowance" name="extra_allowance"
                                               value="{{ $emp->extra_allowance }}">
                                        @error('extra_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col-md-4">
                                        <label for="pay_cycle" class="form-label">Pay Cycle</label>
                                        <select class="form-control" id="pay_cycle" name="pay_cycle" required>
                                            <option value="monthly" {{  $emp->pay_cycle == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            <option value="weekly" {{ $emp->pay_cycle == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                            <option value="bi-weekly" {{ $emp->pay_cycle == 'bi-weekly' ? 'selected' : '' }}>Bi-weekly</option>
                                        </select>
                                        @error('pay_cycle')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="total_leave_allowed" class="form-label">Total Leave Allowed</label>
                                        <input type="text" class="form-control" id="total_leave_allowed" name="total_leave_allowed"
                                               value="{{ $emp->total_leave_allowed }}">
                                        @error('total_leave_allowed')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 salary-fields">
                                        <label for="basic_salary" class="form-label">Basic Salary</label>
                                        <input type="text" class="form-control" id="basic_salary" name="basic_salary"
                                               value="{{$emp->basic_salary}}" required>
                                        @error('basic_salary')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 salary-fields">
                                        <label for="house_rent_allowance" class="form-label">House Rent Allowance</label>
                                        <input type="text" class="form-control" id="house_rent_allowance" name="house_rent_allowance"
                                               value="{{ $emp->house_rent_allowance }}" required>
                                        @error('house_rent_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 salary-fields">
                                        <label for="conveyance_allowance" class="form-label">Conveyance Allowance</label>
                                        <input type="text" class="form-control" id="conveyance_allowance" name="conveyance_allowance"
                                               value="{{ $emp->conveyance_allowance }}" required>
                                        @error('conveyance_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 salary-fields">
                                        <label for="lunch_allowance" class="form-label">Lunch Allowance</label>
                                        <input type="text" class="form-control" id="lunch_allowance" name="lunch_allowance"
                                               value="{{ $emp->lunch_allowance }}" required>
                                        @error('lunch_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 salary-fields">
                                        <label for="personal_pay" class="form-label">Personal Pay</label>
                                        <input type="text" class="form-control" id="personal_pay" name="personal_pay"
                                               value="{{ $emp->personal_pay }}" required>
                                        @error('personal_pay')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 salary-fields">
                                        <label for="medical_allowance" class="form-label">Medical Allowance</label>
                                        <input type="text" class="form-control" id="medical_allowance" name="medical_allowance"
                                               value="{{ $emp->medical_allowance }}" required>
                                        @error('medical_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 salary-fields">
                                        <label for="other_allowance" class="form-label">Other Allowance</label>
                                        <input type="text" class="form-control" id="other_allowance" name="other_allowance"
                                               value="{{ $emp->other_allowance }}" required>
                                        @error('other_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4 salary-fields">
                                        <label for="leave_travel_allowance" class="form-label">Leave Travel Allowance</label>
                                        <input type="text" class="form-control" id="leave_travel_allowance" name="leave_travel_allowance"
                                               value="{{ $emp->leave_travel_allowance }}" required>
                                        @error('leave_travel_allowance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Total Ammount --}}
                                <div class="row mb-4 salary-fields">
                                    <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Total Ammount</h3>
                                    <div class="col-md-6">
                                        <label for="total_ammount" class="form-label">Total Ammount</label>
                                        <input type="text" class="form-control" id="total_ammount" name="total_ammount"
                                               value="{{ $emp->total_ammount }}" readonly>
                                        @error('total_ammount')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Deductions --}}
                                <div class="row mb-4 salary-fields">
                                    <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Deductions</h3>
                                    <div class="col-md-4">
                                        <label for="professional_tax" class="form-label">Professional Tax</label>
                                        <input type="text" class="form-control" id="professional_tax" name="professional_tax"
                                               value="{{$emp->professional_tax}}" required>
                                        @error('professional_tax')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="esic" class="form-label">ESIC</label>
                                        <input type="text" class="form-control" id="esic" name="esic"
                                               value="{{$emp->esic}}" required>
                                        @error('esic')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <label for="advance" class="form-label">Advance</label>
                                        <input type="text" class="form-control" id="advance" name="advance"
                                               value="{{$emp->advance}}" required>
                                        @error('advance')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div> --}}
                                </div>

                                {{-- Net Salary --}}
                                <div class="row mb-4 salary-fields">
                                    <h3 style="color: red; margin-top: 1cm; margin-bottom: 0.5cm;">Net Salary</h3>
                                    <div class="col-md-6">
                                        <label for="net_salary_payable" class="form-label">Net Salary Payable</label>
                                        <input type="text" class="form-control" id="net_salary_payable" name="net_salary_payable"
                                               value="{{ $emp->net_salary_payable }}" readonly>
                                        @error('net_salary_payable')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                {{-- System Access --}}
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label for="user_role" class="form-label">User Role</label>
                                        <select class="form-control" id="user_role" name="user_role" required>
                                            <option value="user" {{  $emp->user_role == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="reportmanager" {{  $emp->user_role == 'reportmanager' ? 'selected' : '' }}>Report Manager</option>
                                        </select>
                                        @error('user_role')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Assigned To field (will show if 'user' role is selected) -->
                                        <div class="col-md-4" id="assigned_to_field" style="{{ $emp->user_role == 'user' ? '' : 'display: none;' }}">
                                            <label for="assigned_to" class="form-label">Assigned To</label>
                                            <select class="form-control" id="assigned_to" name="assigned_to" required>
                                                <option value="disable">- - -Select Report Manager- - -</option>
                                                <!-- Populate this dropdown with dynamic options based on the available report managers -->
                                                @foreach ($reportManagers as $manager)
                                                    <option value="{{ $manager->id }}" {{ $emp->assigned_to == $manager->id ? 'selected' : '' }}>
                                                        {{ $manager->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('assigned_to')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <script>
                                            // JavaScript to show/hide 'Assigned To' field based on 'User Role' selection
                                            document.getElementById('user_role').addEventListener('change', function() {
                                                var userRole = this.value;
                                                var assignedToField = document.getElementById('assigned_to_field');

                                                // If the user role is 'user', show the 'Assigned To' field
                                                if (userRole === 'user') {
                                                    assignedToField.style.display = 'block';
                                                    fetchAssignedToManagers();
                                                } else {
                                                    // If not 'user', hide the 'Assigned To' field
                                                    assignedToField.style.display = 'none';
                                                }
                                            });

                                            // Fetch report managers for the logged-in HR manager
                                            function fetchAssignedToManagers() {
                                                fetch('/get-report-managers')  // Make sure this URL is correct
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        var assignedToSelect = document.getElementById('assigned_to');
                                                        assignedToSelect.innerHTML = '<option value="disable">- - -Select Report Manager- - -</option>';

                                                        // Populate the dropdown with fetched report managers
                                                        data.reportManagers.forEach(manager => {
                                                            var option = document.createElement('option');
                                                            option.value = manager.id;
                                                            option.textContent = manager.name;
                                                            assignedToSelect.appendChild(option);
                                                        });
                                                    })
                                                    .catch(error => console.error('Error fetching report managers:', error));
                                            }

                                            // Trigger the 'change' event on page load to set the visibility of the 'Assigned To' field
                                            window.onload = function() {
                                                document.getElementById('user_role').dispatchEvent(new Event('change'));
                                            };
                                        </script>

                                    <div class="col-md-4">
                                        <label for="username" class="form-label">Username</label>
                                        <select class="form-control" id="username" name="username" required>
                                            <option value="user" {{  $emp->username == 'user' ? 'selected' : '' }}>User</option>
                                            <option value="reportmanager" {{  $emp->username == 'reportmanager' ? 'selected' : '' }}>Report Manager</option>

                                        </select>
                                        @error('username')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="text" class="form-control" id="password" name="password"
                                               value="{{ $emp->password }}">
                                        @error('password')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary px-4 py-2" id="back-2">Back</button>
                                    <button type="submit" class="btn btn-success px-4 py-2">Save Changes</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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

    $(document).ready(function () {
        // Function to update Total Amount and Net Salary
        function updatePayslipValues() {
            // Calculate Total Amount (sum of all earning fields)
            var totalAmount = 0;
            $('#basic_salary, #house_rent_allowance, #conveyance_allowance, #lunch_allowance, #personal_pay, #medical_allowance, #other_allowance, #leave_travel_allowance').each(function() {
                totalAmount += parseFloat($(this).val()) || 0;
            });
            $('#total_ammount').val(totalAmount.toFixed(2)); // Display the result with 2 decimal points

            // Calculate Net Salary (total amount minus all deductions)
            var totalDeductions = 0;
            // $('#professional_tax, #esic').each(function() {
            $('#professional_tax, #esic').each(function() {
                totalDeductions += parseFloat($(this).val()) || 0;
            });
            var netSalary = totalAmount - totalDeductions;
            $('#net_salary_payable').val(netSalary.toFixed(2)); // Display the result with 2 decimal points
        }

        // Trigger updates whenever an input field changes (for both earnings and deductions)
        $('#basic_salary, #house_rent_allowance, #conveyance_allowance, #lunch_allowance, #personal_pay, #medical_allowance, #other_allowance, #leave_travel_allowance, #professional_tax, #esic').on('input', updatePayslipValues);
        // $('#basic_salary, #house_rent_allowance, #conveyance_allowance, #lunch_allowance, #personal_pay, #medical_allowance, #other_allowance, #leave_travel_allowance, #professional_tax, #esic').on('input', updatePayslipValues);
    });
</script>
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
</script> --}}
{{-- <script>
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



@endsection
