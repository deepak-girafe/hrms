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

        <style>

.dashboard-card{
    transition:0.3s;
    cursor:pointer;
}

.dashboard-card:hover{
    transform:translateY(-5px);
}

.icon-box{
    width:65px;
    height:65px;
    border-radius:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:28px;
}

</style>

<div class="row g-4 mb-4">

    {{-- TOTAL EMPLOYEES --}}

    <div class="col-xl-4 col-md-6">

        <a href="{{ route('users.index') }}"
           class="text-decoration-none">

            <div class="card dashboard-card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-2">

                                Total Employees

                            </p>

                            <h2 class="fw-bold text-dark mb-0">

                                {{ $employees }}

                            </h2>

                        </div>

                        <div class="icon-box bg-primary-subtle text-primary">

                            <i class="bi bi-people-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>

    {{-- TOTAL PROJECTS --}}

    <div class="col-xl-4 col-md-6">

        <a href="{{ route('projects.index') }}"
           class="text-decoration-none">

            <div class="card dashboard-card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-2">

                                Total Projects

                            </p>

                            <h2 class="fw-bold text-dark mb-0">

                                {{ $projects }}

                            </h2>

                        </div>

                        <div class="icon-box bg-success-subtle text-success">

                            <i class="bi bi-kanban-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>

    {{-- ON LEAVE TODAY --}}

    <div class="col-xl-4 col-md-6">

        <a href="{{ route('users.index', ['on_leave' => 1]) }}"
           class="text-decoration-none">

            <div class="card dashboard-card border-0 shadow-sm rounded-4 h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>

                            <p class="text-muted mb-2">

                                On Leave Today

                            </p>

                            <h2 class="fw-bold text-dark mb-0">

                                {{ $onLeaveToday }}

                            </h2>

                        </div>

                        <div class="icon-box bg-danger-subtle text-danger">

                            <i class="bi bi-calendar-x-fill"></i>

                        </div>

                    </div>

                </div>

            </div>

        </a>

    </div>

    {{-- ATTENDANCE WIDGET --}}

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