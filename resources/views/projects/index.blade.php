@extends('layouts.app')

@section('title', 'Projects')

@section('content')

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white d-flex justify-content-between">

        <h5 class="fw-bold mb-0">

            Projects

        </h5>

        <a href="{{ route('projects.create') }}"
           class="btn btn-primary rounded-pill">

            Add Project

        </a>

    </div>

    <div class="card-body">

        <table class="table table-bordered align-middle">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Project</th>

                    <th>Timeline</th>

                    <th>Priority</th>

                    <th>Status</th>

                    <th>Team</th>

                    <th>Action</th>

                </tr>

            </thead>

            <tbody>

                @foreach($projects as $key => $project)

                    <tr>

                        <td>{{ $key + 1 }}</td>

                        <td>

                            <div class="fw-semibold">

                                {{ $project->project_name }}

                            </div>

                            <small class="text-muted">

                                {{ $project->project_code }}

                            </small>

                        </td>

                        <td>

                            {{ $project->start_date }}
                            <br>
                            {{ $project->end_date }}

                        </td>

                        <td>

                            <span class="badge bg-info">

                                {{ $project->priority }}

                            </span>

                        </td>

                        <td>

                            <span class="badge bg-primary">

                                {{ $project->status }}

                            </span>

                        </td>

                        <td>

                            @foreach($project->users as $user)

                                <span class="badge bg-secondary">

                                    {{ $user->name }}

                                </span>

                            @endforeach

                        </td>

                        <td>

                            <a href="{{ route('projects.edit', $project->id) }}"
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