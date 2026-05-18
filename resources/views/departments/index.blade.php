@extends('layouts.app')

@section('title', 'Departments')

@section('content')

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0 fw-bold">

            Departments Management

        </h5>

        <a href="{{ route('departments.create') }}"
           class="btn btn-primary rounded-pill">

            Add Department

        </a>

    </div>

    <div class="card-body">

        @if(session('success'))

            <div class="alert alert-success">

                {{ session('success') }}

            </div>

        @endif

        <table class="table table-bordered align-middle">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Department</th>

                    <th>Status</th>

                    <th width="100">Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($departments as $key => $department)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>

                            <div class="fw-semibold">

                                {{ $department->name }}

                            </div>

                            <small class="text-muted">

                                {{ $department->description }}

                            </small>

                        </td>

                        <td>

                            <form method="POST"
                                  action="{{ route('departments.status', $department->id) }}">

                                @csrf

                                <div class="form-check form-switch">

                                    <input class="form-check-input"
                                           type="checkbox"
                                           onchange="this.form.submit()"
                                           {{ $department->status == 'Active' ? 'checked' : '' }}>

                                </div>

                            </form>

                        </td>

                        <td>

                            <a href="{{ route('departments.edit', $department->id) }}"
                               class="btn btn-warning btn-sm">

                                Edit

                            </a>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection