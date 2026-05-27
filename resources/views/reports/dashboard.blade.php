@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="row g-4">

        <div class="col-md-3">

            <div class="card border-0 shadow-sm rounded-4 p-4">

                <h6 class="text-muted">

                    Total Employees

                </h6>

                <h2 class="fw-bold">

                    {{ $data['totalEmployees'] }}

                </h2>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm rounded-4 p-4">

                <h6 class="text-muted">

                    Active Employees

                </h6>

                <h2 class="fw-bold text-success">

                    {{ $data['activeEmployees'] }}

                </h2>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm rounded-4 p-4">

                <h6 class="text-muted">

                    Today Present

                </h6>

                <h2 class="fw-bold text-primary">

                    {{ $data['todayPresent'] }}

                </h2>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card border-0 shadow-sm rounded-4 p-4">

                <h6 class="text-muted">

                    Pending Leaves

                </h6>

                <h2 class="fw-bold text-danger">

                    {{ $data['pendingLeaves'] }}

                </h2>

            </div>

        </div>

    </div>

</div>

@endsection