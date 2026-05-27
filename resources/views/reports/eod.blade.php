@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white p-4">

            <h4 class="fw-bold">

                EOD Productivity Report

            </h4>

        </div>

        <div class="table-responsive">

            <table class="table">

                <thead>

                    <tr>

                        <th>Employee</th>

                        <th>Date</th>

                        <th>Total Projects</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($eods as $eod)

                        <tr>

                            <td>

                                {{ $eod->user->name ?? '-' }}

                            </td>

                            <td>

                                {{ $eod->eod_date }}

                            </td>

                            <td>

                                {{ $eod->items->count() }}

                            </td>

                            <td>

                                {{ $eod->status }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="p-4">

            {{ $eods->links() }}

        </div>

    </div>

</div>

@endsection