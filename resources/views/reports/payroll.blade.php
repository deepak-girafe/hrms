@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow rounded-4">

        <!-- Header -->
        <div class="card-header bg-white border-0 p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h3 class="fw-bold mb-1">

                        Payroll Report

                    </h3>

                    <p class="text-muted mb-0">

                        View employee salary and payroll details

                    </p>

                </div>

            </div>

        </div>

        <!-- Filters -->
        <div class="px-4 pb-3">

            <form method="GET"
                  action="{{ route('reports.payroll') }}">

                <div class="row g-3">

                    <!-- Employee -->
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">

                            Employee

                        </label>

                        <input type="text"
                               name="employee"
                               value="{{ request('employee') }}"
                               class="form-control rounded-3"
                               placeholder="Search employee">

                    </div>

                    <!-- Month -->
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">

                            Salary Month

                        </label>

                        <input type="month"
                               name="salary_month"
                               value="{{ request('salary_month') }}"
                               class="form-control rounded-3">

                    </div>

                    <!-- Payment Status -->
                    <!-- <div class="col-md-3">

                        <label class="form-label fw-semibold">

                            Payment Status

                        </label>

                        <select name="payment_status"
                                class="form-select rounded-3">

                            <option value="">

                                All Status

                            </option>

                            <option value="Paid"
                                {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>

                                Paid

                            </option>

                            <option value="Pending"
                                {{ request('payment_status') == 'Pending' ? 'selected' : '' }}>

                                Pending

                            </option>

                        </select>

                    </div> -->

                    <!-- Buttons -->
                    <div class="col-md-3 d-flex align-items-end gap-2">

                        <button type="submit"
                                class="btn btn-primary rounded-3 px-4">

                            <i class="bi bi-search"></i>

                            Filter

                        </button>

                        <a href="{{ route('reports.payroll') }}"
                           class="btn btn-light border rounded-3 px-4">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

        <!-- Table -->
        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="bg-light">

                    <tr>

                        <th class="px-4 py-3">

                            Employee

                        </th>

                        <th class="py-3">

                            Salary Month

                        </th>

                        <th class="py-3">

                            Gross Salary

                        </th>

                        <th class="py-3">

                            Deduction

                        </th>

                        <th class="py-3">

                            Net Salary

                        </th>

                        <!-- <th class="py-3">

                            Status

                        </th> -->

                    </tr>

                </thead>

                <tbody>

                    @forelse($payrolls as $payroll)

                        <tr>

                            <td class="px-4">

                                <div class="fw-semibold">

                                    {{ $payroll->user->name ?? '-' }}

                                </div>

                                <small class="text-muted">

                                    {{ $payroll->user->employee_code ?? '' }}

                                </small>

                            </td>

                            <td>

                                {{ \Carbon\Carbon::parse($payroll->salary_month)->format('F Y') }}

                            </td>

                            <td>

                                <span class="fw-semibold text-success">

                                    ₹ {{ number_format($payroll->gross_salary, 2) }}

                                </span>

                            </td>

                            <td>

                                <span class="fw-semibold text-danger">

                                    ₹ {{ number_format($payroll->total_deduction, 2) }}

                                </span>

                            </td>

                            <td>

                                <span class="fw-bold text-primary">

                                    ₹ {{ number_format($payroll->net_salary, 2) }}

                                </span>

                            </td>

                            <!-- <td>

                                @if($payroll->payment_status == 'Paid')

                                    <span class="badge bg-success rounded-pill px-3 py-2">

                                        Paid

                                    </span>

                                @else

                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">

                                        Pending

                                    </span>

                                @endif

                            </td> -->

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-5 text-muted">

                                No payroll records found

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        <div class="p-4 border-top">

            {{ $payrolls->withQueryString()->links() }}

        </div>

    </div>

</div>

@endsection