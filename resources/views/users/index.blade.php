@extends('layouts.app')

@section('title', 'Users Management')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
      rel="stylesheet" />

<style>
.filter-control{
    height:48px;
    border-radius:14px;
}

.select2-container .select2-selection--single{
    height:48px !important;
    border-radius:14px !important;
    border:1px solid #dee2e6 !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered{
    line-height:46px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow{
    height:46px !important;
}
.filter-card{
    border-radius:20px;
}

.user-avatar{
    width:45px;
    height:45px;
    border-radius:50%;
    background:#0d6efd;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:16px;
}

.table td,
.table th{
    vertical-align:middle;
}

.badge-soft{
    
    color:#0d6efd;
    font-weight:600;
    
    border-radius:20px;
}

.table-hover tbody tr:hover{
    background:#f8fbff;
}

</style>

<div class="container-fluid py-4">

    {{-- PAGE HEADER --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Users Management

            </h3>

            <p class="text-muted mb-0">

                Manage employees, departments and reporting hierarchy

            </p>

        </div>

        @if(in_array(strtolower(optional(auth()->user()->role)->name), ['admin', 'hr']))

        <a href="{{ route('users.create') }}"
        class="btn btn-primary rounded-pill px-4 shadow-sm">

            <i class="bi bi-plus-circle me-1"></i>

            Add User

        </a>

        @endif

    </div>

    {{-- FILTER CARD --}}

    <div class="card border-0 shadow-sm filter-card mb-4">

        <div class="card-body p-4">

            <form method="GET">

            <div class="row g-3 align-items-end">

                {{-- SEARCH --}}

                <div class="col-xl-2 col-lg-6">

                    <label class="form-label fw-semibold">

                        Search Employee

                    </label>

                    <input type="text"
                        name="name"
                        value="{{ request('name') }}"
                        class="form-control filter-control"
                        placeholder="Name / Email">

                </div>

                {{-- ROLE --}}

                <div class="col-xl-2 col-lg-6">

                    <label class="form-label fw-semibold">

                        Role

                    </label>

                    <select name="role_id"
                            class="form-select select2 filter-control">

                        <option value="">

                            All Roles

                        </option>

                        @foreach($roles as $role)

                            <option value="{{ $role->id }}"
                                {{ request('role_id') == $role->id ? 'selected' : '' }}>

                                {{ $role->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- DEPARTMENT --}}

                <div class="col-xl-2 col-lg-6">

                    <label class="form-label fw-semibold">

                        Department

                    </label>

                    <select name="department_id"
                            class="form-select select2 filter-control">

                        <option value="">

                            All Departments

                        </option>

                        @foreach($departments as $department)

                            <option value="{{ $department->id }}"
                                {{ request('department_id') == $department->id ? 'selected' : '' }}>

                                {{ $department->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- REPORTING TO --}}

                <div class="col-xl-2 col-lg-6">

                    <label class="form-label fw-semibold">

                        Reporting To

                    </label>

                    <select name="reporting_to"
                            class="form-select select2 filter-control">

                        <option value="">

                            All Managers

                        </option>

                        @foreach($managers as $manager)

                            <option value="{{ $manager->id }}"
                                {{ request('reporting_to') == $manager->id ? 'selected' : '' }}>

                                {{ $manager->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- ON LEAVE TODAY --}}

                <div class="col-xl-2 col-lg-6">

                    <label class="form-label fw-semibold">

                        Leave Status

                    </label>

                    <select name="on_leave"
                            class="form-select select2 filter-control">

                        <option value="">

                            All Employees

                        </option>

                        <option value="1"
                            {{ request('on_leave') == '1' ? 'selected' : '' }}>

                            On Leave Today

                        </option>

                    </select>

                </div>

                {{-- FROM DATE --}}

                <div class="col-xl-2 col-lg-6">

                    <label class="form-label fw-semibold">

                        From

                    </label>

                    <input type="date"
                        name="from_date"
                        value="{{ request('from_date') }}"
                        class="form-control filter-control">

                </div>

                {{-- TO DATE --}}

                <div class="col-xl-2 col-lg-6">

                    <label class="form-label fw-semibold">

                        To

                    </label>

                    <input type="date"
                        name="to_date"
                        value="{{ request('to_date') }}"
                        class="form-control filter-control">

                </div>

                {{-- BUTTONS --}}

                <div class="col-xl-4 col-lg-12">

                    <div class="">

                        <button type="submit"
                                class="btn btn-primary rounded-3">

                            Filter

                        </button>

                        <a href="{{ route('users.index') }}"
                        class="btn btn-light border rounded-3">

                            Reset

                        </a>

                    </div>

                </div>

                </div>

            </form>

        </div>

    </div>

    {{-- SUCCESS MESSAGE --}}

    @if(session('success'))

        <div class="alert alert-success rounded-4 shadow-sm border-0">

            {{ session('success') }}

        </div>

    @endif

    {{-- USERS TABLE --}}

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="bg-light">

                    <tr>

                        <th class="ps-4 py-3">

                            Employee

                        </th>

                        <th>

                            Role

                        </th>

                        <th>

                            Departments

                        </th>

                        <th>

                            Reporting To

                        </th>

                        <th>

                            Joining Date

                        </th>

                        <th>

                            Status

                        </th>

                        <th class="text-end pe-4">

                            Actions

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr>

                            {{-- USER --}}

                            <td class="ps-4">

                                <div class="d-flex align-items-center gap-3">

                                    <div class="user-avatar">

                                        {{ strtoupper(substr($user->name,0,1)) }}

                                    </div>

                                    <div>

                                        <div class="fw-semibold">

                                            {{ $user->name }}

                                        </div>

                                        <small class="text-muted">

                                            {{ $user->email }}

                                        </small>

                                    </div>

                                </div>

                            </td>

                            {{-- ROLE --}}

                            <td>

                                <span class="badge-soft">

                                    {{ $user->role->name ?? '-' }}

                                </span>

                            </td>

                            {{-- DEPARTMENTS --}}

                            <td>

                                @forelse($user->departments as $department)

                                    <span class="badge bg-light text-dark border mb-1">

                                        {{ $department->name }}

                                    </span>

                                @empty

                                    -

                                @endforelse

                            </td>

                            {{-- REPORTING TO --}}

                            <td>

                                @forelse($user->reportingManagers as $manager)

                                    <span class="badge bg-primary mb-1">

                                        {{ $manager->name }}

                                    </span>

                                @empty

                                    -

                                @endforelse

                            </td>

                            {{-- JOINING DATE --}}

                            <td>

                                {{ $user->joining_date
                                    ? date('d M Y', strtotime($user->joining_date))
                                    : '-' }}

                            </td>

                            {{-- STATUS --}}

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

                            {{-- ACTIONS --}}

                            <td class="text-end pe-4">

                            <div class="d-flex justify-content-end gap-2">

                                {{-- VIEW DOCUMENTS --}}

                                <a href="{{ route('users.documents', $user->id) }}"
                                class="btn btn-info btn-sm rounded-pill px-3 text-white">

                                    <i class="bi bi-folder2-open"></i>

                                    Documents

                                </a>

                                {{-- EDIT USER --}}

                                <a href="{{ route('users.edit', $user->id) }}"
                                class="btn btn-warning btn-sm rounded-pill px-3">

                                    <i class="bi bi-pencil-square"></i>

                                    Edit

                                </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center py-5">

                                <div class="text-muted">

                                    No users found

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}

        @if(method_exists($users, 'links'))

            <div class="p-4 border-top">

                {{ $users->links() }}

            </div>

        @endif

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

$('.select2').select2({

    width:'100%'

});

</script>

@endsection