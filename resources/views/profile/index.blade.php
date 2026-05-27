@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="row">

        <div class="col-lg-8 mx-auto">

            {{-- SUCCESS MESSAGE --}}

            @if(session('success'))

                <div class="alert alert-success rounded-4 shadow-sm border-0">

                    {{ session('success') }}

                </div>

            @endif

            {{-- ERROR MESSAGE --}}

            @if(session('error'))

                <div class="alert alert-danger rounded-4 shadow-sm border-0">

                    {{ session('error') }}

                </div>

            @endif

            {{-- PROFILE CARD --}}

            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-header bg-white border-0 p-4">

                    <h4 class="fw-bold mb-0">

                        My Profile

                    </h4>

                </div>

                <div class="card-body p-4">

                    <form method="POST"
                          action="{{ route('profile.update') }}">

                        @csrf

                        <div class="row">

                            {{-- NAME --}}

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Full Name

                                </label>

                                <input type="text"
                                       name="name"
                                       value="{{ old('name', $user->name) }}"
                                       class="form-control rounded-3"
                                       required>

                            </div>

                            {{-- EMAIL --}}

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Email

                                </label>

                                <input type="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       class="form-control rounded-3"
                                       required>

                            </div>

                            {{-- MOBILE --}}

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Mobile Number

                                </label>

                                <input type="text"
                                       name="mobile_number"
                                       value="{{ old('mobile_number', $user->mobile_number) }}"
                                       class="form-control rounded-3">

                            </div>

                            {{-- ROLE --}}

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Role

                                </label>

                                <input type="text"
                                       value="{{ $user->role->name ?? '-' }}"
                                       class="form-control rounded-3 bg-light"
                                       readonly>

                            </div>

                            {{-- DESIGNATION --}}

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Designation

                                </label>

                                <input type="text"
                                       value="{{ $user->designation }}"
                                       class="form-control rounded-3 bg-light"
                                       readonly>

                            </div>

                            {{-- JOINING DATE --}}

                            <div class="col-md-6 mb-4">

                                <label class="form-label fw-semibold">

                                    Joining Date

                                </label>

                                <input type="text"
                                       value="{{ $user->joining_date }}"
                                       class="form-control rounded-3 bg-light"
                                       readonly>

                            </div>

                        </div>

                        <div class="text-end">

                            <button type="submit"
                                    class="btn btn-primary rounded-pill px-5">

                                Update Profile

                            </button>

                        </div>

                    </form>

                </div>

            </div>

            {{-- CHANGE PASSWORD --}}

            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-header bg-white border-0 p-4">

                    <h4 class="fw-bold mb-0">

                        Change Password

                    </h4>

                </div>

                <div class="card-body p-4">

                    <form method="POST"
                          action="{{ route('profile.change-password') }}">

                        @csrf

                        <div class="row">

                            {{-- CURRENT PASSWORD --}}

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    Current Password

                                </label>

                                <input type="password"
                                       name="current_password"
                                       class="form-control rounded-3"
                                       required>

                            </div>

                            {{-- NEW PASSWORD --}}

                            <div class="col-md-4 mb-4">

                                <label class="form-label fw-semibold">

                                    New Password

                                </label>

                                <input type="password"
                                       name="password"
                                       class="form-control rounded-3"
                                       required>

                            </div>

                            {{-- CONFIRM PASSWORD --}}

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

                            <button type="submit"
                                    class="btn btn-success rounded-pill px-5">

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