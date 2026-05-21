@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1 text-capitalize">

                {{ $roleName }} Dashboard

            </h3>

            <p class="text-muted mb-0">

                Welcome back,
                {{ auth()->user()->name }}

            </p>

        </div>

    </div>

    {{-- Cards --}}

    <div class="row g-4 mb-4">

        {{-- Employees --}}

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="text-muted">

                                Employees

                            </h6>

                            <h2 class="fw-bold text-primary">

                                {{ $employees }}

                            </h2>

                        </div>

                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-people fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Projects --}}

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="text-muted">

                                Projects

                            </h6>

                            <h2 class="fw-bold text-success">

                                {{ $projects }}

                            </h2>

                        </div>

                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-kanban fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Attendance --}}

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="text-muted">

                                Today's Attendance

                            </h6>

                            <h2 class="fw-bold text-warning">

                                {{ $todayAttendance }}

                            </h2>

                        </div>

                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-calendar-check fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Leaves --}}

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h6 class="text-muted">

                                Pending Leaves

                            </h6>

                            <h2 class="fw-bold text-danger">

                                {{ $pendingLeaves }}

                            </h2>

                        </div>

                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-calendar-x fs-3"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Attendance Widget --}}

        @include('dashboard.partials.attendance-widget')

    </div>

    {{-- Team Members --}}

    @if($teamMembers->count())

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white">

                <h5 class="fw-bold mb-0">

                    Team Members

                </h5>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table align-middle">

                        <thead>

                            <tr>

                                <th>Name</th>

                                <th>Email</th>

                                <th>Designation</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($teamMembers as $member)

                                <tr>

                                    <td>

                                        {{ $member->name }}

                                    </td>

                                    <td>

                                        {{ $member->email }}

                                    </td>

                                    <td>

                                        {{ $member->designation }}

                                    </td>

                                    <td>

                                        <span class="badge bg-success">

                                            {{ $member->status }}

                                        </span>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    @endif

</div>

@endsection