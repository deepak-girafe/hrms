@extends('layouts.app')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css"
      rel="stylesheet">

<div class="container-fluid py-4">

    {{-- Header --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Attendance Calendar

            </h3>

            <p class="text-muted mb-0">

                Monthly attendance overview

            </p>

        </div>

        <div>

            <a href="{{ route('dashboard') }}"
               class="btn btn-dark rounded-pill">

                <i class="bi bi-arrow-left me-2"></i>

                Back to Dashboard

            </a>

        </div>

    </div>

    {{-- Summary Cards --}}

    @php

        $presentDays = $monthlyAttendance
            ->where('status', 'Present')
            ->count();

        $totalHours = $monthlyAttendance
            ->sum('working_hours');

        $avgHours = $presentDays > 0
            ? round($totalHours / $presentDays, 2)
            : 0;

    @endphp

    {{-- Summary Cards --}}

    <div class="row g-4 mb-4">

        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <h6 class="text-muted">

                        Present Days

                    </h6>

                    <h2 class="fw-bold text-success"
                        id="presentDays">

                        0

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <h6 class="text-muted">

                        Total Hours

                    </h6>

                    <h2 class="fw-bold text-primary"
                        id="totalHours">

                        0

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-xl-4 col-md-6">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <h6 class="text-muted">

                        Average Hours

                    </h6>

                    <h2 class="fw-bold text-warning"
                        id="avgHours">

                        0

                    </h2>

                </div>

            </div>

        </div>

        <div class="col-xl-5 col-md-6" style="display:none">

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body">

                    <h6 class="text-muted">

                        Month

                    </h6>

                    <h2 class="fw-bold text-danger"
                        id="currentMonth">

                        {{ now()->format('F') }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    {{-- Calendar --}}

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div id="attendanceCalendar"></div>

        </div>

    </div>

</div>

{{-- Attendance Modal --}}

<div class="modal fade"
     id="attendanceModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content border-0 rounded-4">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">

                    Attendance Details

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <div class="card border-0 shadow-sm rounded-4">

                            <div class="card-header bg-success text-white">

                                Punch In Selfie

                            </div>

                            <div class="card-body text-center">

                                <img src=""
                                     id="punchInImage"
                                     class="img-fluid rounded-4">

                            </div>

                        </div>

                    </div>

                    <div class="col-md-6 mb-4">

                        <div class="card border-0 shadow-sm rounded-4">

                            <div class="card-header bg-danger text-white">

                                Punch Out Selfie

                            </div>

                            <div class="card-body text-center">

                                <img src=""
                                     id="punchOutImage"
                                     class="img-fluid rounded-4">

                            </div>

                        </div>

                    </div>

                </div>

                <div class="row text-center">

                    <div class="col-md-4">

                        <h6 class="text-muted">

                            Punch In

                        </h6>

                        <h5 id="punchInTime"></h5>

                    </div>

                    <div class="col-md-4">

                        <h6 class="text-muted">

                            Punch Out

                        </h6>

                        <h5 id="punchOutTime"></h5>

                    </div>

                    <div class="col-md-4">

                        <h6 class="text-muted">

                            Working Hours

                        </h6>

                        <h5 id="workingHours"></h5>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

<script>

document.addEventListener(

    'DOMContentLoaded',

    function() {

        const calendarEl = document.getElementById(
            'attendanceCalendar'
        );

        const calendar = new FullCalendar.Calendar(

            calendarEl,

            {

                initialView: 'dayGridMonth',

                height: 750,

                events:
                '{{ route("attendance.events") }}',

                /*
                |--------------------------------------------------------------------------
                | Month Change
                |--------------------------------------------------------------------------
                */

                datesSet: function(info) {

                    updateSummary(

                        info.startStr,
                        info.endStr

                    );
                },

                /*
                |--------------------------------------------------------------------------
                | Event Click
                |--------------------------------------------------------------------------
                */

                eventClick: function(info) {

                    document.getElementById(
                        'punchInTime'
                    ).innerHTML =
                        info.event.extendedProps.punchIn;

                    document.getElementById(
                        'punchOutTime'
                    ).innerHTML =
                        info.event.extendedProps.punchOut;

                    document.getElementById(
                        'workingHours'
                    ).innerHTML =
                        info.event.extendedProps.workingHours
                        + ' hrs';

                    document.getElementById(
                        'punchInImage'
                    ).src =
                        info.event.extendedProps.punchInImage;

                    document.getElementById(
                        'punchOutImage'
                    ).src =
                        info.event.extendedProps.punchOutImage;

                    new bootstrap.Modal(

                        document.getElementById(
                            'attendanceModal'
                        )

                    ).show();
                }

            }

        );

        calendar.render();

        /*
        |--------------------------------------------------------------------------
        | Update Summary Cards
        |--------------------------------------------------------------------------
        */

        function updateSummary(start, end)
        {
            fetch(

                '{{ route("attendance.summary") }}'

                + '?start=' + start

                + '&end=' + end

            )

            .then(response => response.json())

            .then(data => {

                document.getElementById(
                    'presentDays'
                ).innerHTML = data.presentDays;

                document.getElementById(
                    'totalHours'
                ).innerHTML = data.totalHours;

                document.getElementById(
                    'avgHours'
                ).innerHTML = data.avgHours;

                document.getElementById(
                    'currentMonth'
                ).innerHTML = data.month;

            });
        }
    }

);

</script>
@endsection