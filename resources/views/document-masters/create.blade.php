@extends('layouts.app')

@section('title', 'Add Document')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white p-4">

            <h4 class="fw-bold mb-0">

                Add Document

            </h4>

        </div>

        <div class="card-body p-4">

            <form method="POST"
                  action="{{ route('document-masters.store') }}">

                @csrf

                <div class="row">

                    <div class="col-md-6 mb-4">

                        <label class="form-label fw-semibold">

                            Document Name

                        </label>

                        <input type="text"
                               name="document_name"
                               class="form-control rounded-3"
                               required>

                    </div>

                    <div class="col-md-3 mb-4">

                        <label class="form-label fw-semibold">

                            Required

                        </label>

                        <select name="is_required"
                                class="form-select rounded-3">

                            <option value="Yes">

                                Yes

                            </option>

                            <option value="No">

                                No

                            </option>

                        </select>

                    </div>

                    <div class="col-md-3 mb-4">

                        <label class="form-label fw-semibold">

                            Status

                        </label>

                        <select name="status"
                                class="form-select rounded-3">

                            <option value="Active">

                                Active

                            </option>

                            <option value="Inactive">

                                Inactive

                            </option>

                        </select>

                    </div>

                    <div class="col-md-12 mb-4">

                        <label class="form-label fw-semibold">

                            Description

                        </label>

                        <textarea name="description"
                                  rows="4"
                                  class="form-control rounded-3"></textarea>

                    </div>

                </div>

                <div class="text-end">

                    <button class="btn btn-primary rounded-pill px-5">

                        Save Document

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection