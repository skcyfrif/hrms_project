@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">All Candidates</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
        {{-- <div class="col-md-12 col-xl-12 middle-wrapper"> --}}

            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">All Candidates</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact No</th>
                                    <th>Applied For</th>
                                    <th>Interview Date</th>
                                    <th>Interview Time</th>
                                    <th>Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($interviews as $key => $interview)
                                    @if ($interview->candidate) <!-- Check if candidate exists -->
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $interview->candidate->name }}</td>
                                            <td>{{ $interview->candidate->email }}</td>
                                            <td>{{ $interview->candidate->mobile }}</td>
                                            <td>{{ $interview->candidate->applied_for ?? 'N/A' }}</td>
                                            <td>{{ $interview->interview_date }}</td>
                                            <td>{{ $interview->interview_time }}</td>
                                            <td>{{ $interview->location }}</td>
                                            <td>
                                                <a href="{{ route('rescheduled.candidate', $interview->candidate->id) }}" class="btn btn-warning">Reschedule</a>
                                                <a href="{{ route('shortlist.candidate', $interview->candidate->id) }}"
                                                    class="btn btn-success"
                                                    onclick="return confirmShortlist()">
                                                    Shortlist
                                                </a>
                                                {{-- <a href="#" class="btn btn-info">Hold</a> --}}
                                                <a href="{{ route('hold.candidate', $interview->candidate->id) }}"
                                                    class="btn btn-info"
                                                    onclick="return confirmHold()">
                                                    Hold
                                                </a>
                                                {{-- <a href="{{ route('reject.candidate', $interview->candidate->id) }}" class="btn btn-danger">Reject</a> --}}
                                                <a href="{{ route('reject.candidate', $interview->candidate->id) }}"
                                                    class="btn btn-danger"
                                                    onclick="return confirmReject()">
                                                    Reject
                                                 </a>

                                                 <script>
                                                     function confirmReject() {
                                                         return confirm('Are you sure you want to reject this candidate?');
                                                     }
                                                     function confirmHold() {
                                                         return confirm('Are you sure you want to Hold this candidate?');
                                                     }
                                                     function confirmShortlist() {
                                                         return confirm('Are you sure you want to Shortlisting this candidate?');
                                                     }
                                                 </script>
                                                {{-- <a href="#" class="btn btn-danger">Reject</a> --}}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
