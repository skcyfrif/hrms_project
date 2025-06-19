@extends('hr_head.hr_head_dashboard')

@section('hr_head')
    <div class="page-content">

        <div class="row justify-content-center">
            <div class="col-md-8 grid-margin stretch-card">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Terminate Employee</h5>
                        <a href="{{ route('terminations.index') }}" class="btn btn-light text-danger btn-sm">
                            ← Back to List
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('terminations.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="employee_id" class="form-label">Select Employee</label>
                                <select name="employee_id" id="employee_id" class="form-select" required>
                                    <option value="">-- Select HR Manager / Employee --</option>
                                    @foreach ($allUsers as $user)
                                        <option value="{{ $user->id }}">
                                            {{ $user->name }}
                                            @if ($user->user_role === 'hr_manager')
                                                (HR Manager)
                                            @elseif($user->user_role === 'user')
                                                (Employee)
                                            @endif
                                        </option>
                                    @endforeach
                                </select>

                            </div>

                            <div class="mb-3">
                                <label for="reason" class="form-label">Termination Reason</label>
                                <textarea name="reason" id="reason" class="form-control" rows="4" placeholder="Write reason here..." required></textarea>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-danger px-4">Submit Termination</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
