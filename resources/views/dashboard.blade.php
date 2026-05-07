@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <p class="text-muted mb-1">
                                Employees
                            </p>

                            <h3 class="fw-bold mb-0">
                                120
                            </h3>
                        </div>

                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-people fs-3"></i>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <p class="text-muted mb-1">
                                Present Today
                            </p>

                            <h3 class="fw-bold mb-0 text-success">
                                98
                            </h3>
                        </div>

                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-calendar-check fs-3"></i>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <p class="text-muted mb-1">
                                Absent
                            </p>

                            <h3 class="fw-bold mb-0 text-danger">
                                12
                            </h3>
                        </div>

                        <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-person-x fs-3"></i>

                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center">

                        <div>
                            <p class="text-muted mb-1">
                                Leaves
                            </p>

                            <h3 class="fw-bold mb-0 text-warning">
                                10
                            </h3>
                        </div>

                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;">

                            <i class="bi bi-calendar-event fs-3"></i>

                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@endsection