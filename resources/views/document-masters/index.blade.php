@extends('layouts.app')

@section('title', 'Document Master')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-4">

        {{-- HEADER --}}

        <div class="card-header bg-white p-4 d-flex justify-content-between align-items-center">

            <div>

                <h4 class="fw-bold mb-1">

                    Document Master

                </h4>

                <p class="text-muted mb-0">

                    Manage employee document types

                </p>

            </div>

            <a href="{{ route('document-masters.create') }}"
               class="btn btn-primary rounded-pill px-4">

                <i class="bi bi-plus-circle me-2"></i>

                Add Document

            </a>

        </div>

        {{-- BODY --}}

        <div class="card-body p-4">

            @if(session('success'))

                <div class="alert alert-success rounded-4">

                    {{ session('success') }}

                </div>

            @endif

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>#</th>

                            <th>Document</th>

                            <th>Required</th>

                            <th>Status</th>

                            <th width="140">

                                Action

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($documents as $key => $document)

                            <tr>

                                <td>

                                    {{ $documents->firstItem() + $key }}

                                </td>

                                <td>

                                    <div class="fw-semibold">

                                        {{ $document->document_name }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $document->description }}

                                    </small>

                                </td>

                                <td>

                                    @if($document->is_required == 'Yes')

                                        <span class="badge bg-success">

                                            Required

                                        </span>

                                    @else

                                        <span class="badge bg-secondary">

                                            Optional

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($document->status == 'Active')

                                        <span class="badge bg-primary">

                                            Active

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Inactive

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <div class="d-flex gap-2">

                                        <a href="{{ route('document-masters.edit', $document->id) }}"
                                           class="btn btn-warning btn-sm rounded-pill px-3">

                                            Edit

                                        </a>

                                        <form method="POST"
                                              action="{{ route('document-masters.destroy', $document->id) }}">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm rounded-pill px-3"
                                                    onclick="return confirm('Delete document?')">

                                                Delete

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center py-5 text-muted">

                                    No documents found

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $documents->links() }}

            </div>

        </div>

    </div>

</div>

@endsection