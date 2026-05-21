@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- Welcome Row --}}

    <div class="row mb-4">

        <div class="col-12">

            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <h3 class="fw-bold mb-2">

                                Welcome Back,
                                {{ auth()->user()->name }}

                            </h3>

                            <p class="mb-0 opacity-75">

                                HRMS Admin Dashboard Overview

                            </p>

                        </div>

                        <div>

                            <i class="bi bi-speedometer2"
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

                                Total Employees

                            </p>

                            <h2 class="fw-bold mb-0">

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

                                Departments

                            </p>

                            <h2 class="fw-bold mb-0 text-success">

                                {{ $data['departments'] }}

                            </h2>

                        </div>

                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:65px;height:65px;">

                            <i class="bi bi-diagram-3 fs-2"></i>

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

                            <h2 class="fw-bold mb-0 text-warning">

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

                                Pending Leaves

                            </p>

                            <h2 class="fw-bold mb-0 text-danger">

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

    </div>

    {{-- Employee Status --}}

    <div class="row g-4 mb-4">

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-header bg-white border-0">

                    <h5 class="fw-bold mb-0">

                        Employee Status

                    </h5>

                </div>

                <div class="card-body">

                    <div class="row text-center">

                        <div class="col-6 border-end">

                            <h2 class="text-success fw-bold">

                                {{ $data['activeEmployees'] }}

                            </h2>

                            <p class="text-muted mb-0">

                                Active Employees

                            </p>

                        </div>

                        <div class="col-6">

                            <h2 class="text-danger fw-bold">

                                {{ $data['inactiveEmployees'] }}

                            </h2>

                            <p class="text-muted mb-0">

                                Inactive Employees

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="col-lg-6">

            <div class="card border-0 shadow-sm rounded-4 h-100">

                <div class="card-header bg-white border-0">

                    <h5 class="fw-bold mb-0">

                        Quick Actions

                    </h5>

                </div>

                <div class="card-body">

                    <div class="d-grid gap-3">

                        <a href="{{ route('users.create') }}"
                           class="btn btn-primary rounded-pill">

                            <i class="bi bi-person-plus me-2"></i>

                            Add Employee

                        </a>

                        <a href="{{ route('projects.create') }}"
                           class="btn btn-warning rounded-pill text-white">

                            <i class="bi bi-kanban me-2"></i>

                            Create Project

                        </a>

                        <a href="{{ route('leave-policies.index') }}"
                           class="btn btn-success rounded-pill">

                            <i class="bi bi-calendar-check me-2"></i>

                            Manage Leave Policies

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- System Overview --}}

    <div class="row">

        <div class="col-12">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0">

                    <h5 class="fw-bold mb-0">

                        System Overview

                    </h5>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table align-middle">

                            <thead>

                                <tr>

                                    <th>Module</th>
                                    <th>Status</th>
                                    <th>Remarks</th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td>Employee Management</td>

                                    <td>

                                        <span class="badge bg-success">

                                            Active

                                        </span>

                                    </td>

                                    <td>

                                        Working properly

                                    </td>

                                </tr>

                                <tr>

                                    <td>Leave Management</td>

                                    <td>

                                        <span class="badge bg-success">

                                            Active

                                        </span>

                                    </td>

                                    <td>

                                        Policies configured

                                    </td>

                                </tr>

                                <tr>

                                    <td>Project Management</td>

                                    <td>

                                        <span class="badge bg-success">

                                            Active

                                        </span>

                                    </td>

                                    <td>

                                        Teams assigned

                                    </td>

                                </tr>

                                <tr>

                                    <td>Role Permissions</td>

                                    <td>

                                        <span class="badge bg-success">

                                            Active

                                        </span>

                                    </td>

                                    <td>

                                        RBAC implemented

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