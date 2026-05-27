@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white p-4">

            <h4 class="fw-bold">

                Department Report

            </h4>

        </div>

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th>Department</th>

                        <th>Total Employees</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($departments as $department)

                        <tr>

                            <td>

                                {{ $department->name }}

                            </td>

                            <td>

                                {{ $department->users_count }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection