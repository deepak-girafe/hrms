@extends('layouts.app')

@section('title', 'Users')

@section('content')

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0 fw-bold">
            Users Management
        </h5>

        <a href="{{ route('users.create') }}"
           class="btn btn-primary rounded-pill">

            Add User

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

                    <th>Name</th>

                    <th>Role</th>

                    <th>Designation</th>

                    <th>Reporting To</th>

                    <th>Status</th>

                    <th width="100">Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($users as $key => $user)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>

                            <div class="fw-semibold">

                                {{ $user->name }}

                            </div>

                            <small class="text-muted">

                                {{ $user->email }}

                            </small>

                        </td>

                        <td>

                            {{ $user->role->name ?? '-' }}

                        </td>

                        <td>

                            {{ $user->designation }}

                        </td>

                        <td>

                            {{ $user->reportingManager->name ?? '-' }}

                        </td>

                        <td>

                            @if($user->status == 'Active')

                                <span class="badge bg-success">

                                    Active

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Inactive

                                </span>

                            @endif

                        </td>

                        <td>

                            <a href="{{ route('users.edit', $user->id) }}"
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