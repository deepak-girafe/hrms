@extends('layouts.app')

@section('title', 'Role Permissions')

@section('content')

<div class="card border-0 shadow-sm rounded-4">

    <div class="card-header bg-white">

        <h5 class="fw-bold mb-0">

            Role Permissions

        </h5>

    </div>

    <div class="card-body">

        <table class="table table-bordered align-middle">

            <thead>

                <tr>

                    <th width="80">

                        #

                    </th>

                    <th>

                        Role

                    </th>

                    <th width="150">

                        Action

                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($roles as $key => $role)

                    <tr>

                        <td>

                            {{ $key + 1 }}

                        </td>

                        <td>

                            {{ $role->name }}

                        </td>

                        <td>

                            <a href="{{ route('role-permissions.edit', $role->id) }}"
                               class="btn btn-primary btn-sm">

                                Manage

                            </a>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection