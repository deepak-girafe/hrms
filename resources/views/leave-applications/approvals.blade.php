@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <h3 class="fw-bold mb-4">

        Leave Approvals

    </h3>

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Employee</th>

                            <th>Leave Type</th>

                            <th>Dates</th>

                            <th>Total Days</th>

                            <th>Reason</th>

                            <th>Status</th>

                            <th width="200">

                                Action

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($leaves as $leave)

                            <tr>

                                <td>

                                    {{ $leave->user->name }}

                                </td>

                                <td>

                                    {{ $leave->leaveType->name }}

                                </td>

                                <td>

                                    {{ date('d M', strtotime($leave->from_date)) }}

                                    -

                                    {{ date('d M Y', strtotime($leave->to_date)) }}

                                </td>

                                <td>

                                    {{ $leave->total_days }}

                                </td>

                                <td>

                                    {{ $leave->reason }}

                                </td>

                                <td>

                                    <span class="badge bg-warning text-dark">

                                        Pending

                                    </span>

                                </td>

                                <td>

                                    <div class="d-flex gap-2">

                                        <form method="POST"
                                              action="{{ route('leave-approvals.approve',$leave->id) }}">

                                            @csrf

                                            <button class="btn btn-success btn-sm rounded-pill">

                                                Approve

                                            </button>

                                        </form>

                                        <form method="POST"
                                              action="{{ route('leave-approvals.reject',$leave->id) }}">

                                            @csrf

                                            <button class="btn btn-danger btn-sm rounded-pill">

                                                Reject

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection