@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white p-4">

            <h4 class="fw-bold">

                Leave Report

            </h4>

        </div>

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th>Employee</th>

                        <th>Leave Type</th>

                        <th>From</th>

                        <th>To</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($leaves as $leave)

                        <tr>

                            <td>

                                {{ $leave->user->name ?? '-' }}

                            </td>

                            <td>

                                {{ $leave->leave_type }}

                            </td>

                            <td>

                                {{ $leave->from_date }}

                            </td>

                            <td>

                                {{ $leave->to_date }}

                            </td>

                            <td>

                                {{ $leave->status }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="p-4">

            {{ $leaves->links() }}

        </div>

    </div>

</div>

@endsection