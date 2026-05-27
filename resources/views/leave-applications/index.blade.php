@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="fw-bold">

            My Leave Applications

        </h3>

        <a href="{{ route('leave-applications.create') }}"
           class="btn btn-primary rounded-pill">

            <i class="bi bi-plus-circle me-2"></i>

            Apply Leave

        </a>

    </div>

    <!-- <div class="row mb-4">

    @foreach($leaveSummary as $summary)

        <div class="col-md-3 mb-3">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <h6 class="text-muted mb-3">

                        {{ $summary['leave_type'] }}

                    </h6>

                    <div class="d-flex justify-content-between mb-2">

                        <span>

                            Allowed

                        </span>

                        <strong class="text-primary">

                            {{ $summary['allowed'] }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-2">

                        <span>

                            Used

                        </span>

                        <strong class="text-danger">

                            {{ $summary['used'] }}

                        </strong>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span>

                            Remaining

                        </span>

                        <strong class="text-success">

                            {{ $summary['pending'] }}

                        </strong>

                    </div>

                </div>

            </div>

        </div>

    @endforeach

</div> -->

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Leave Type</th>

                            <th>From</th>

                            <th>To</th>

                            <th>Total Days</th>

                            <th>Status</th>

                            <th>Approved By</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($leaves as $leave)

                            <tr>

                                <td>

                                    {{ $leave->leaveType->name ?? '-' }}

                                </td>

                                <td>

                                    {{ date('d M Y', strtotime($leave->from_date)) }}

                                </td>

                                <td>

                                    {{ date('d M Y', strtotime($leave->to_date)) }}

                                </td>

                                <td>

                                    {{ $leave->total_days }}

                                </td>

                                <td>

                                    @if($leave->status == 'Approved')

                                        <span class="badge bg-success">

                                            Approved

                                        </span>

                                    @elseif($leave->status == 'Rejected')

                                        <span class="badge bg-danger">

                                            Rejected

                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">

                                            Pending

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    {{ $leave->approver->name ?? '-' }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-5">

                                    No leave applications found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection