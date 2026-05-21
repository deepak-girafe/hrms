@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- Welcome Card --}}

    <div class="row mb-4">

        <div class="col-12">

            <div class="card border-0 shadow-sm rounded-4 bg-dark text-white">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h3 class="fw-bold mb-2">

                                Welcome,
                                {{ auth()->user()->name }}

                            </h3>

                            <p class="mb-0 opacity-75">

                                Department Head Dashboard

                            </p>

                        </div>

                        <div>

                            <i class="bi bi-diagram-3"
                               style="font-size:70px;opacity:0.2;"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Statistics --}}

    <div class="row g-4 mb-4">

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">

                                Department Employees

                            </p>

                            <h2 class="fw-bold text-primary">

                                {{ $data['employees'] }}

                            </h2>

                        </div>

                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:65px;height:65px;">

                            <i class="bi bi-people fs-2"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">

                                Active Projects

                            </p>

                            <h2 class="fw-bold text-warning">

                                {{ $data['projects'] }}

                            </h2>

                        </div>

                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:65px;height:65px;">

                            <i class="bi bi-kanban fs-2"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-1">

                                Pending Leave Requests

                            </p>

                            <h2 class="fw-bold text-danger">

                                {{ $data['pendingLeaves'] }}

                            </h2>

                        </div>

                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:65px;height:65px;">

                            <i class="bi bi-calendar-x fs-2"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-xl-3 col-md-6">

        @include('dashboard.partials.attendance-widget')

        </div>

    </div>

    {{-- Quick Actions --}}

    <div class="row g-4 mb-4">

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-header bg-white border-0">

                    <h5 class="fw-bold mb-0">

                        Quick Actions

                    </h5>

                </div>

                <div class="card-body">

                    <div class="d-grid gap-3">

                        <a href="{{ route('users.index') }}"
                           class="btn btn-primary rounded-pill">

                            <i class="bi bi-people me-2"></i>

                            View Department Employees

                        </a>

                        <a href="{{ route('projects.index') }}"
                           class="btn btn-warning rounded-pill text-white">

                            <i class="bi bi-kanban me-2"></i>

                            View Projects

                        </a>

                        <a href="#"
                           class="btn btn-danger rounded-pill">

                            <i class="bi bi-calendar-check me-2"></i>

                            Approve Leave Requests

                        </a>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-header bg-white border-0">

                    <h5 class="fw-bold mb-0">

                        Department Overview

                    </h5>

                </div>

                <div class="card-body">

                    <div class="mb-4">

                        <div class="d-flex justify-content-between mb-2">

                            <span class="fw-semibold">

                                Employee Strength

                            </span>

                            <span>

                                {{ $data['employees'] }}

                            </span>

                        </div>

                        <div class="progress"
                             style="height:10px;">

                            <div class="progress-bar bg-primary"
                                 style="width:85%"></div>

                        </div>

                    </div>

                    <div class="mb-4">

                        <div class="d-flex justify-content-between mb-2">

                            <span class="fw-semibold">

                                Project Load

                            </span>

                            <span>

                                {{ $data['projects'] }}

                            </span>

                        </div>

                        <div class="progress"
                             style="height:10px;">

                            <div class="progress-bar bg-warning"
                                 style="width:70%"></div>

                        </div>

                    </div>

                    <div>

                        <div class="d-flex justify-content-between mb-2">

                            <span class="fw-semibold">

                                Leave Requests

                            </span>

                            <span>

                                {{ $data['pendingLeaves'] }}

                            </span>

                        </div>

                        <div class="progress"
                             style="height:10px;">

                            <div class="progress-bar bg-danger"
                                 style="width:40%"></div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Recent Activities --}}

    <div class="row">

        <div class="col-12">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0">

                    <h5 class="fw-bold mb-0">

                        Recent Department Activities

                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table align-middle">

                            <thead>

                                <tr>

                                    <th>Activity</th>

                                    <th>Date</th>

                                    <th>Status</th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td>

                                        Team meeting completed

                                    </td>

                                    <td>

                                        {{ now()->format('d M Y') }}

                                    </td>

                                    <td>

                                        <span class="badge bg-success">

                                            Completed

                                        </span>

                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        Leave approvals pending

                                    </td>

                                    <td>

                                        {{ now()->format('d M Y') }}

                                    </td>

                                    <td>

                                        <span class="badge bg-warning text-dark">

                                            Pending

                                        </span>

                                    </td>

                                </tr>

                                <tr>

                                    <td>

                                        Project review scheduled

                                    </td>

                                    <td>

                                        {{ now()->addDay()->format('d M Y') }}

                                    </td>

                                    <td>

                                        <span class="badge bg-primary">

                                            Upcoming

                                        </span>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection