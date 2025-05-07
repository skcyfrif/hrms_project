@extends('hr_manager.hr_manager_dashboard')
@section('hr_manager')
<div class="page-content">
    <h6 class="text-center">Check Leave Balance of {{ $hrManagerName }}</h6>


                <nav class="page-breadcrumb">
                    <ol class="breadcrumb">
                    </ol>
                </nav>

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    {{-- <h6 class="card-title">All Employee</h6> --}}
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>employee id</th>
                                    <th>name</th>
                                    <th>year</th>
                                    <th>total leave allowed</th>
                                    <th>total leave Till Yet</th>
                                    <th>total leave taken Till Yet</th>
                                    <th>current leave Till Yet</th>
                                    <th>current leave balance</th>
                                    <th>total unpaid leave</th>

                                </tr>
                            </thead>




                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
