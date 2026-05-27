@extends('layouts.app')

@section('content')

<style>

.profile-tabs .nav-link{
    border:none;
    color:#6c757d;
    font-weight:600;
    padding:14px 24px;
    border-radius:14px;
}

.profile-tabs .nav-link.active{
    background:#0d6efd;
    color:#fff;
}

.profile-image{
    width:120px;
    height:120px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid #fff;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

</style>

<div class="container-fluid py-4">

    @if(session('success'))

        <div class="alert alert-success rounded-4">

            {{ session('success') }}

        </div>

    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        {{-- HEADER --}}

        <div class="bg-primary p-5 text-white">

            <div class="d-flex align-items-center gap-4">

            <img src="{{ $user->profile_image
                ? asset('profile-images/'.$user->profile_image)
                : 'https://ui-avatars.com/api/?name='.$user->name }}"
                class="profile-image">

                <div>

                    <h3 class="fw-bold mb-1">

                        {{ $user->name }}

                    </h3>

                    <p class="mb-1">

                        {{ $user->designation }}

                    </p>

                    <small>

                        {{ $user->email }}

                    </small>

                </div>

            </div>

        </div>

        {{-- BODY --}}

        <div class="card-body p-4">

            {{-- TABS --}}

            <ul class="nav nav-pills profile-tabs mb-4"
                role="tablist">

                <li class="nav-item">

                    <button class="nav-link active"
                            data-bs-toggle="pill"
                            data-bs-target="#profileTab">

                        Profile

                    </button>

                </li>

                <li class="nav-item">

                    <button class="nav-link"
                            data-bs-toggle="pill"
                            data-bs-target="#documentsTab">

                        Documents

                    </button>

                </li>

                <li class="nav-item">

                    <button class="nav-link"
                            data-bs-toggle="pill"
                            data-bs-target="#passwordTab">

                        Change Password

                    </button>

                </li>

            </ul>

            <div class="tab-content">

                {{-- PROFILE TAB --}}

                <div class="tab-pane fade show active"
                     id="profileTab">

                    <form method="POST"
                          enctype="multipart/form-data"
                          action="{{ route('profile.updateprofile') }}">

                        @csrf

                        <div class="row">

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Profile Image

                                </label>

                                <input type="file"
                                       name="profile_image"
                                       class="form-control rounded-3">

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Mobile Number

                                </label>

                                <input type="text"
                                       name="mobile_number"
                                       value="{{ $user->mobile_number }}"
                                       class="form-control rounded-3">

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Employee Code

                                </label>

                                <input type="text"
                                       value="{{ $user->employee_code }}"
                                       class="form-control rounded-3 bg-light"
                                       readonly>

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Name

                                </label>

                                <input type="text"
                                       value="{{ $user->name }}"
                                       class="form-control rounded-3 bg-light"
                                       readonly>

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Email

                                </label>

                                <input type="text"
                                       value="{{ $user->email }}"
                                       class="form-control rounded-3 bg-light"
                                       readonly>

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Designation

                                </label>

                                <input type="text"
                                       value="{{ $user->designation }}"
                                       class="form-control rounded-3 bg-light"
                                       readonly>

                            </div>

                        </div>

                        <div class="text-end">

                            <button class="btn btn-primary rounded-pill px-5">

                                Update Profile

                            </button>

                        </div>

                    </form>

                </div>

                {{-- DOCUMENTS TAB --}}

                <div class="tab-pane fade"
                     id="documentsTab">

                    {{-- UPLOAD FORM --}}

                    <form method="POST"
                          enctype="multipart/form-data"
                          action="{{ route('profile.upload-document') }}"
                          class="mb-4">

                        @csrf

                        <div class="row">

                            <div class="col-md-5">

                                <input type="text"
                                       name="document_name"
                                       placeholder="Document Name"
                                       class="form-control rounded-3"
                                       required>

                            </div>

                            <div class="col-md-5">

                                <input type="file"
                                       name="document_file"
                                       class="form-control rounded-3"
                                       required>

                            </div>

                            <div class="col-md-2">

                                <button class="btn btn-success w-100 rounded-3">

                                    Upload

                                </button>

                            </div>

                        </div>

                    </form>

                    {{-- DOCUMENTS TABLE --}}

                    <div class="table-responsive">

                        <table class="table align-middle">

                            <thead>

                                <tr>

                                    <th>Document</th>

                                    <th>Uploaded On</th>

                                    <th width="120">

                                        Action

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                @forelse($user->documents as $document)

                                    <tr>

                                        <td>

                                            {{ $document->document_name }}

                                        </td>

                                        <td>

                                            {{ $document->created_at->format('d M Y') }}

                                        </td>

                                        <td>

                                            <a href="{{ asset('employee-documents/'.$document->document_file) }}"
                                               target="_blank"
                                               class="btn btn-primary btn-sm rounded-pill">

                                                View

                                            </a>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="3"
                                            class="text-center text-muted py-4">

                                            No documents uploaded

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

                {{-- PASSWORD TAB --}}

                <div class="tab-pane fade"
                     id="passwordTab">

                    <form method="POST"
                          action="{{ route('profile.change-password') }}">

                        @csrf

                        <div class="row">

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Current Password

                                </label>

                                <input type="password"
                                       name="current_password"
                                       class="form-control rounded-3"
                                       required>

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    New Password

                                </label>

                                <input type="password"
                                       name="password"
                                       class="form-control rounded-3"
                                       required>

                            </div>

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Confirm Password

                                </label>

                                <input type="password"
                                       name="password_confirmation"
                                       class="form-control rounded-3"
                                       required>

                            </div>

                        </div>

                        <div class="text-end">

                            <button class="btn btn-primary rounded-pill px-5">

                                Change Password

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection