@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white p-4">

            <h4 class="fw-bold">

                Attendance Report

            </h4>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Employee</th>

                        <th>Date</th>

                        <th>Punch In</th>

                        <th>Punch Out</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($attendance as $row)

                        <tr>

                            <td>

                                {{ $row->user->name ?? '-' }}

                            </td>

                            <td>

                                {{ $row->attendance_date }}

                            </td>

                            <td>

                                {{ $row->punch_in }}

                            </td>

                            <td>

                                {{ $row->punch_out }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="p-4">

            {{ $attendance->links() }}

        </div>

    </div>

</div>

@endsection