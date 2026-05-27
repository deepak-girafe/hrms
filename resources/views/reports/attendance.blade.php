@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow rounded-4">

        <!-- Header -->
        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h3 class="fw-bold mb-1">

                        Attendance Report

                    </h3>

                    <p class="text-muted mb-0">

                        View employee attendance details

                    </p>

                </div>

            </div>

        </div>

        <!-- Filters -->
        <div class="px-4 pb-3">

            <form method="GET"
                  action="{{ route('reports.attendance') }}">

                <div class="row g-3">

                    <!-- Employee -->
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">

                            Employee

                        </label>

                        <input type="text"
                               name="employee"
                               value="{{ request('employee') }}"
                               class="form-control rounded-3"
                               placeholder="Search employee">

                    </div>

                    <!-- From Date -->
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">

                            From Date

                        </label>

                        <input type="date"
                               name="from_date"
                               value="{{ request('from_date') }}"
                               class="form-control rounded-3">

                    </div>

                    <!-- To Date -->
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">

                            To Date

                        </label>

                        <input type="date"
                               name="to_date"
                               value="{{ request('to_date') }}"
                               class="form-control rounded-3">

                    </div>

                    <!-- Buttons -->
                    <div class="col-md-3 d-flex align-items-end gap-2">

                        <button type="submit"
                                class="btn btn-primary rounded-3 px-4">

                            <i class="bi bi-search"></i>

                            Filter

                        </button>

                        <a href="{{ route('reports.attendance') }}"
                           class="btn btn-light border rounded-3 px-4">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

        <!-- Table -->
        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="bg-light">

                    <tr>

                        <th class="px-4 py-3">

                            Employee

                        </th>

                        <th class="py-3">

                            Date

                        </th>

                        <th class="py-3">

                            Punch In

                        </th>

                        <th class="py-3">

                            Punch Out

                        </th>

                        <th class="py-3">

                            Working Hours

                        </th>

                        <th class="py-3">

                            Status

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($attendance as $row)

                        @php

                            $workingHours = '-';

                            if($row->punch_in && $row->punch_out){

                                $start = \Carbon\Carbon::parse($row->punch_in);

                                $end = \Carbon\Carbon::parse($row->punch_out);

                                $workingHours = $start->diff($end)->format('%h hrs %i mins');
                            }

                        @endphp

                        <tr>

                            <td class="px-4">

                                <div class="fw-semibold">

                                    {{ $row->user->name ?? '-' }}

                                </div>

                                <small class="text-muted">

                                    {{ $row->user->employee_code ?? '' }}

                                </small>

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($row->attendance_date)->format('d M Y') }}

                            </td>

                            <td>

                                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">

                                    {{ $row->punch_in ?? '-' }}

                                </span>

                            </td>

                            <td>

                                <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">

                                    {{ $row->punch_out ?? '-' }}

                                </span>

                            </td>

                            <td>

                                {{ $workingHours }}

                            </td>

                            <td>

                                @if($row->punch_out)

                                    <span class="badge bg-success rounded-pill px-3">

                                        Completed

                                    </span>

                                @else

                                    <span class="badge bg-warning text-dark rounded-pill px-3">

                                        In Progress

                                    </span>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-5 text-muted">

                                No attendance records found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        <div class="p-4 border-top">

            {{ $attendance->withQueryString()->links() }}

        </div>

    </div>

</div>

@endsection