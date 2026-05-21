@extends('layouts.app')

@section('title', 'Leave Types')

@section('content')

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white d-flex justify-content-between">

        <h5 class="fw-bold mb-0">

            Leave Types

        </h5>

        <a href="{{ route('leave-types.create') }}"
           class="btn btn-primary rounded-pill">

            Add Leave Type

        </a>

    </div>

    <div class="card-body">

        <table class="table table-bordered align-middle">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Name</th>

                    <th>Paid</th>

                    <th>Status</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($leaveTypes as $key => $leaveType)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>

                            {{ $leaveType->name }}

                        </td>

                        <td>

                            {{ $leaveType->paid }}

                        </td>

                        <td>

                            <form method="POST"
                                  action="{{ route('leave-types.status', $leaveType->id) }}">

                                @csrf

                                <div class="form-check form-switch">

                                    <input class="form-check-input"
                                           type="checkbox"
                                           onchange="this.form.submit()"
                                           {{ $leaveType->status == 'Active' ? 'checked' : '' }}>

                                </div>

                            </form>

                        </td>

                        <td>

                            <a href="{{ route('leave-types.edit', $leaveType->id) }}"
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