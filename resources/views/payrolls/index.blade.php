@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                Payroll Management

            </h3>

            <p class="text-muted mb-0">

                Generate payroll, export and download payslips

            </p>

        </div>

        <div class="d-flex gap-2">

            <a href="{{ route('payrolls.export.excel') }}"
               class="btn btn-success rounded-pill">

                <i class="bi bi-file-earmark-excel me-2"></i>

                Export Excel

            </a>

            <button class="btn btn-primary rounded-pill"
                    data-bs-toggle="modal"
                    data-bs-target="#generatePayrollModal">

                <i class="bi bi-cash-stack me-2"></i>

                Generate Payroll

            </button>

        </div>

    </div>

    {{-- Alerts --}}

    @if(session('success'))

        <div class="alert alert-success rounded-4">

            {{ session('success') }}

        </div>

    @endif

    {{-- Payroll Table --}}

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Employee</th>

                            <th>Month</th>

                            <th>Present</th>

                            <th>Gross</th>

                            <th>Deduction</th>

                            <th>Net Salary</th>

                            <th>Status</th>

                            <th width="250">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($payrolls as $payroll)

                            <tr>

                                <td>

                                    <div class="fw-semibold">

                                        {{ $payroll->user->name ?? '' }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $payroll->user->designation ?? '' }}

                                    </small>

                                </td>

                                <td>

                                    {{ date('F', mktime(0,0,0,$payroll->month,1)) }}

                                    {{ $payroll->year }}

                                </td>

                                <td>

                                    {{ $payroll->present_days }}

                                </td>

                                <td>

                                    ₹ {{ number_format($payroll->gross_salary,2) }}

                                </td>

                                <td>

                                    ₹ {{ number_format($payroll->total_deduction,2) }}

                                </td>

                                <td>

                                    <strong class="text-success">

                                        ₹ {{ number_format($payroll->net_salary,2) }}

                                    </strong>

                                </td>

                                <td>

                                    @if($payroll->status == 'Paid')

                                        <span class="badge bg-success">

                                            Paid

                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark">

                                            {{ $payroll->status }}

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <div class="d-flex gap-2 flex-wrap">

                                        <a href="{{ route('payrolls.payslip',$payroll->id) }}"
                                           class="btn btn-sm btn-primary rounded-pill">

                                            <i class="bi bi-file-pdf"></i>

                                            Payslip

                                        </a>

                                        @if($payroll->status != 'Paid')

                                            <form method="POST"
                                                  action="{{ route('payrolls.markPaid',$payroll->id) }}">

                                                @csrf

                                                <button class="btn btn-sm btn-success rounded-pill">

                                                    Mark Paid

                                                </button>

                                            </form>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="8"
                                    class="text-center py-5">

                                    No payroll generated

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">

                {{ $payrolls->links() }}

            </div>

        </div>

    </div>

</div>

{{-- Generate Payroll Modal --}}

<div class="modal fade"
     id="generatePayrollModal"
     tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">

                    Generate Payroll

                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

            </div>

            <form method="POST"
                  action="{{ route('payrolls.generate') }}">

                @csrf

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">

                            Month

                        </label>

                        <select name="month"
                                class="form-select"
                                required>

                            @for($i=1;$i<=12;$i++)

                                <option value="{{ $i }}">

                                    {{ date('F', mktime(0,0,0,$i,1)) }}

                                </option>

                            @endfor

                        </select>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Year

                        </label>

                        <input type="number"
                               name="year"
                               value="{{ date('Y') }}"
                               class="form-control"
                               required>

                    </div>

                </div>

                <div class="modal-footer border-0">

                    <button type="submit"
                            class="btn btn-primary rounded-pill px-4">

                        Generate Payroll

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection