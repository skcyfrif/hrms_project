@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
<div class="page-content">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Hold Candidates</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">All Hold Candidates</h6>

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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tests as $key => $interview)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $interview->name }}</td>
                                        <td>{{ $interview->email }}</td>
                                        <td>{{ $interview->mobile }}</td>
                                        <td>
                                            <a href="{{ route('reschedule.interview', $interview->id) }}"
                                                class="btn btn-success"
                                                onclick="return confirmReschedule()">
                                                reschedule
                                            </a>
                                            {{-- <a href="{{ route('rescheduled.candidate', $interview->id) }}" class="btn btn-warning">Reschedule</a> --}}

                                            <a href="{{ route('reject.candidates', $interview->id) }}"
                                                class="btn btn-danger"
                                                onclick="return confirmReject()">
                                                Reject
                                             </a>

                                             <script>
                                                 function confirmReject() {
                                                     return confirm('Are you sure you want to reject this candidate?');
                                                 }
                                                 function confirmReschedule() {
                                                     return confirm('Are you sure you want to Reschedule this candidate?');
                                                 }
                                             </script>

                                            {{-- <a href="{{ route('reject.candidates', $interview->candidate->id) }}" class="btn btn-success">Reject</a> --}}
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
@endsection
