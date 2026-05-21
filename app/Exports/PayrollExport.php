<?php

namespace App\Exports;

use App\Models\Payroll;
use Maatwebsite\Excel\Concerns\FromCollection;

class PayrollExport implements FromCollection
{
    public function collection()
    {
        return Payroll::with('user')->get()->map(function($payroll) {

            return [

                'Employee' => $payroll->user->name ?? '',

                'Month' => $payroll->month,

                'Year' => $payroll->year,

                'Present Days' => $payroll->present_days,

                'Gross Salary' => $payroll->gross_salary,

                'Deduction' => $payroll->total_deduction,

                'Net Salary' => $payroll->net_salary,

                'Status' => $payroll->status

            ];
        });
    }
}