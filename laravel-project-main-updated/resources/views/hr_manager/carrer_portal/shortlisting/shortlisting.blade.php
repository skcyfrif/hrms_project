@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Shortlisted Candidates</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">All Shortlisted Candidates</h6>

                    @if (session('message'))
                        <div class="alert alert-success">{{ session('message') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Employee Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tests as $key => $item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->mobile }}</td>

                                        <td>
                                            <select class="form-select form-select-lg" id="employeeType{{ $key }}" onchange="updateButtonText({{ $key }})">
                                                <option value="">Select</option>
                                                <option value="Intern" {{ $item->employee_type == 'Intern' ? 'selected' : '' }}>Intern</option>
                                                <option value="Full Time" {{ $item->employee_type == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                            </select>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-success" id="offerLetterBtn{{ $key }}" onclick="sendOfferLetter({{ $item->id }}, '{{ $item->name }}', document.getElementById('employeeType{{ $key }}').value)">
                                                Send Offer Letter
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<script>
    // Function to update the button text when employee type changes
    function updateButtonText(key) {
        const select = document.getElementById(`employeeType${key}`);
        const button = document.getElementById(`offerLetterBtn${key}`);
        const type = select.value;
        if (type) {
            button.textContent = `Send Offer Letter for ${type}`;
        } else {
            button.textContent = 'Send Offer Letter';
        }
    }

    // Function to send the offer letter when the button is clicked
    function sendOfferLetter(candidateId, candidateName, employeeType) {
        if (employeeType === 'Intern') {
            // Redirect to the Intern offer letter route
            window.location.href = `/intern/offer/${candidateId}`;
        } else if (employeeType === 'Full Time') {
            // Redirect to the Full Time offer letter route
            window.location.href = `/full/offer/${candidateId}`;
        } else {
            alert('Please select a valid employee type.');
        }
    }
</script>

@endsection
