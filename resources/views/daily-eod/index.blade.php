@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Daily EOD Reports

            </h2>

            <p class="text-muted mb-0">

                Employee daily work updates

            </p>

        </div>

        @if(strtolower(auth()->user()->role->name) != 'admin')

            <a href="{{ route('daily-eod.create') }}"
               class="btn btn-primary rounded-pill px-4 shadow-sm">

                + Submit EOD

            </a>

        @endif

    </div>

    {{-- SUCCESS MESSAGE --}}

    @if(session('success'))

        <div class="alert alert-success rounded-4 border-0 shadow-sm">

            {{ session('success') }}

        </div>

    @endif

    {{-- ERROR MESSAGE --}}

    @if(session('error'))

        <div class="alert alert-danger rounded-4 border-0 shadow-sm">

            {{ session('error') }}

        </div>

    @endif

    {{-- CARD --}}

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="bg-light">

                    <tr>

                        <th class="ps-4 py-3">

                            Employee

                        </th>

                        <th class="py-3">

                            Projects

                        </th>

                        <th class="py-3">

                            Total Updates

                        </th>

                        <th class="py-3">

                            Date

                        </th>

                        <th class="py-3">

                            Status

                        </th>

                        <th class="text-end pe-4 py-3">

                            Action

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($eods as $eod)

                        <tr>

                            {{-- EMPLOYEE --}}

                            <td class="ps-4">

                                <div class="fw-semibold">

                                    {{ $eod->user->name ?? '-' }}

                                </div>

                            </td>

                            {{-- PROJECTS --}}

                            <td>

                                @foreach($eod->items as $item)

                                    <span class="badge bg-primary mb-1">

                                        {{ $item->project->project_name ?? '-' }}

                                    </span>

                                @endforeach

                            </td>

                            {{-- TOTAL UPDATES --}}

                            <td>

                                <span class="badge bg-dark">

                                    {{ $eod->items->count() }}

                                    Updates

                                </span>

                            </td>

                            {{-- DATE --}}

                            <td>

                                {{ date('d M Y', strtotime($eod->eod_date)) }}

                            </td>

                            {{-- STATUS --}}

                            <td>

                                @if($eod->status == 'Reviewed')

                                    <span class="badge bg-success">

                                        Reviewed

                                    </span>

                                @else

                                    <span class="badge bg-warning text-dark">

                                        Submitted

                                    </span>

                                @endif

                            </td>

                            {{-- ACTIONS --}}

                            <td class="text-end pe-4">

                                <div class="d-flex justify-content-end gap-2">

                                    {{-- VIEW --}}

                                    <a href="{{ route('daily-eod.show', $eod->id) }}"
                                       class="btn btn-sm btn-primary rounded-pill px-3">

                                        View

                                    </a>

                                    {{-- REVIEW --}}

                                    @if(

                                        strtolower(auth()->user()->role->name)

                                        == 'admin'

                                        ||

                                        in_array(

                                            strtolower(auth()->user()->role->name),

                                            [

                                                'manager',
                                                'team lead',
                                                'department head'

                                            ]

                                        )

                                    )

                                        @if($eod->status != 'Reviewed')

                                            <form method="POST"
                                                  action="{{ route('daily-eod.review', $eod->id) }}">

                                                @csrf

                                                <button type="submit"
                                                        class="btn btn-success btn-sm rounded-pill px-3">

                                                    Mark Reviewed

                                                </button>

                                            </form>

                                        @endif

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-5">

                                <div class="text-muted">

                                    No EOD reports found

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}

        @if($eods->hasPages())

            <div class="p-4 border-top">

                {{ $eods->links() }}

            </div>

        @endif

    </div>

</div>

@endsection