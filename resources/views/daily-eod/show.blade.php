@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h3 class="fw-bold mb-1">

                        Daily EOD Details

                    </h3>

                    <p class="text-muted mb-0">

                        {{ date('d M Y', strtotime($eod->eod_date)) }}

                    </p>

                </div>

                <a href="{{ route('daily-eod.index') }}"
                   class="btn btn-light rounded-pill px-4">

                    Back

                </a>

            </div>

        </div>

        <div class="card-body p-4">

            <div class="mb-4">

                <h5 class="fw-bold">

                    Employee

                </h5>

                <p>

                    {{ $eod->user->name }}

                </p>

            </div>

            @foreach($eod->items as $item)

                <div class="border rounded-4 p-4 mb-4 bg-light">

                    <div class="mb-3">

                        <label class="text-muted small">

                            Project

                        </label>

                        <h5 class="fw-bold">

                            {{ $item->project->project_name ?? '-' }}

                        </h5>

                    </div>

                    <div class="mb-3">

                        <label class="text-muted small">

                            Work Done

                        </label>

                        <div class="border rounded-3 bg-white p-3">

                            {!! nl2br(e($item->work_done)) !!}

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">

                            <label class="text-muted small">

                                Blockers

                            </label>

                            <div class="border rounded-3 bg-white p-3">

                                {!! nl2br(e($item->blockers ?? '-')) !!}

                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="text-muted small">

                                Tomorrow Plan

                            </label>

                            <div class="border rounded-3 bg-white p-3">

                                {!! nl2br(e($item->tomorrow_plan ?? '-')) !!}

                            </div>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>

@endsection