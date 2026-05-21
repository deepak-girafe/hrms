@extends('layouts.app')

@section('title', 'Leave Policies')

@section('content')

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white d-flex justify-content-between">

        <h5 class="fw-bold mb-0">

            Leave Policies

        </h5>

        <a href="{{ route('leave-policies.create') }}"
           class="btn btn-primary rounded-pill">

            Add Leave Policy

        </a>

    </div>

    <div class="card-body">

        <table class="table table-bordered align-middle">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Role</th>

                    <th>Leave Type</th>

                    <th>Employment</th>

                    <th>Allowed</th>

                    <th>Cycle</th>

                    <th>Status</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($leavePolicies as $key => $policy)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>{{ $policy->role->name ?? '-' }}</td>

                        <td>{{ $policy->leaveType->name ?? '-' }}</td>

                        <td>{{ $policy->employment_type }}</td>

                        <td>{{ $policy->allowed_leaves }}</td>

                        <td>{{ $policy->leave_cycle }}</td>

                        <td>

                            <form method="POST"
                                  action="{{ route('leave-policies.status', $policy->id) }}">

                                @csrf

                                <div class="form-check form-switch">

                                    <input class="form-check-input"
                                           type="checkbox"
                                           onchange="this.form.submit()"
                                           {{ $policy->status == 'Active' ? 'checked' : '' }}>

                                </div>

                            </form>

                        </td>

                        <td>

                            <a href="{{ route('leave-policies.edit', $policy->id) }}"
                               class="btn btn-warning btn-sm">

                                Edit

                            </a>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection