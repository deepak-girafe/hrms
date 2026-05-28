@extends('layouts.app')

@section('title', 'Employee Documents')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        {{-- HEADER --}}

        <div class="card-header bg-white p-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <h4 class="fw-bold mb-1">

                        Employee Documents

                    </h4>

                    <p class="text-muted mb-0">

                        {{ $user->name }}

                    </p>

                </div>

                <a href="{{ route('users.index') }}"
                   class="btn btn-light border rounded-pill px-4">

                    <i class="bi bi-arrow-left me-2"></i>

                    Back

                </a>

            </div>

        </div>

        {{-- BODY --}}

        <div class="card-body p-4">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th width="60">

                                #

                            </th>

                            <th>

                                Document Name

                            </th>

                            <th>

                                Uploaded On

                            </th>

                            <th width="140">

                                Action

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($user->documents as $key => $document)

                            <tr>

                                <td>

                                    {{ $key + 1 }}

                                </td>

                                <td>

                                    <div class="fw-semibold">

                                        {{ $document->documentMaster->document_name ?? '-' }}

                                    </div>

                                </td>

                                <td>

                                    {{ $document->created_at->format('d M Y') }}

                                </td>

                                <td>

                                    <a href="{{ asset('employee-documents/'.$document->document_file) }}"
                                       target="_blank"
                                       class="btn btn-primary btn-sm rounded-pill px-3">

                                        <i class="bi bi-eye me-1"></i>

                                        View

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4"
                                    class="text-center py-5 text-muted">

                                    No documents uploaded

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection