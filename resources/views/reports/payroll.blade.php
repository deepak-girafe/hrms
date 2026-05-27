@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white p-4">

            <h4 class="fw-bold">

                Payroll Report

            </h4>

        </div>

        <div class="table-responsive">

            <table class="table align-middle">

                <thead>

                    <tr>

                        <th>Employee</th>

                        <th>Month</th>

                        <th>Gross</th>

                        <th>Deduction</th>

                        <th>Net Salary</th>

                        <th>Status</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($payrolls as $payroll)

                        <tr>

                            <td>

                                {{ $payroll->user->name ?? '-' }}

                            </td>

                            <td>

                                {{ $payroll->salary_month }}

                            </td>

                            <td>

                                ₹ {{ number_format($payroll->gross_salary,2) }}

                            </td>

                            <td>

                                ₹ {{ number_format($payroll->total_deduction,2) }}

                            </td>

                            <td>

                                ₹ {{ number_format($payroll->net_salary,2) }}

                            </td>

                            <td>

                                {{ $payroll->payment_status }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        <div class="p-4">

            {{ $payrolls->links() }}

        </div>

    </div>

</div>

@endsection