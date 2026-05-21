<!DOCTYPE html>

<html>

<head>

    <title>

        Salary Payslip

    </title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size: 13px;
            color:#222;
        }

        .header{
            text-align:center;
            margin-bottom:25px;
        }

        .header h2{
            margin:0;
            font-size:28px;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-bottom:20px;
        }

        table td,
        table th{
            border:1px solid #dcdcdc;
            padding:10px;
        }

        table th{
            background:#f5f5f5;
        }

        .text-center{
            text-align:center;
        }

        .fw-bold{
            font-weight:bold;
        }

        .net-salary{
            font-size:18px;
            font-weight:bold;
            color:#0f8b4c;
        }

    </style>

</head>

<body>

    <div class="header">

        <h2>

            Salary Payslip

        </h2>

        <p>

            {{ $payroll->salary_month }}
            {{ $payroll->year }}

        </p>

    </div>

    {{-- EMPLOYEE DETAILS --}}

    <table>

        <tr>

            <th width="30%">

                Employee

            </th>

            <td>

                {{ $payroll->user->name }}

            </td>

        </tr>

        <tr>

            <th>

                Employee Code

            </th>

            <td>

                {{ $payroll->user->employee_code }}

            </td>

        </tr>

        <tr>

            <th>

                Designation

            </th>

            <td>

                {{ $payroll->user->designation }}

            </td>

        </tr>

    </table>

    {{-- EARNINGS / DEDUCTIONS --}}

    <table>

        <tr>

            <th>

                Earnings

            </th>

            <th>

                Amount

            </th>

            <th>

                Deductions

            </th>

            <th>

                Amount

            </th>

        </tr>

        <tr>

            <td>Basic Salary</td>
            <td>₹ {{ number_format($payroll->basic_salary,2) }}</td>

            <td>PF</td>
            <td>₹ {{ number_format($payroll->pf,2) }}</td>

        </tr>

        <tr>

            <td>HRA</td>
            <td>₹ {{ number_format($payroll->hra,2) }}</td>

            <td>ESI</td>
            <td>₹ {{ number_format($payroll->esi,2) }}</td>

        </tr>

        <tr>

            <td>DA</td>
            <td>₹ {{ number_format($payroll->da,2) }}</td>

            <td>TDS</td>
            <td>₹ {{ number_format($payroll->tds,2) }}</td>

        </tr>

        <tr>

            <td>TA</td>
            <td>₹ {{ number_format($payroll->ta,2) }}</td>

            <td>Other Deduction</td>
            <td>₹ {{ number_format($payroll->other_deduction,2) }}</td>

        </tr>

        <tr>

            <td>Bonus</td>
            <td>₹ {{ number_format($payroll->bonus,2) }}</td>

            <td></td>
            <td></td>

        </tr>

    </table>

    {{-- ATTENDANCE SUMMARY --}}

    <table>

        <tr>

            <th>Total Month Days</th>
            <td>{{ $payroll->working_days }}</td>

            <th>Present Days</th>
            <td>{{ $payroll->present_days }}</td>

        </tr>

        <tr>

            <th>Half Days</th>
            <td>{{ $payroll->half_days }}</td>

            <th>Unpaid Leaves</th>
            <td>{{ $payroll->leave_days }}</td>

        </tr>

        <tr>

            <th>Deductible Days</th>
            <td>{{ $payroll->absent_days }}</td>

            <th>Salary Status</th>
            <td>{{ $payroll->payment_status }}</td>

        </tr>

    </table>

    {{-- FINAL SALARY --}}

    <table>

        <tr>

            <th width="50%">

                Gross Salary

            </th>

            <td>

                ₹ {{ number_format($payroll->gross_salary,2) }}

            </td>

        </tr>

        <tr>

            <th>

                Total Deduction

            </th>

            <td>

                ₹ {{ number_format($payroll->total_deduction,2) }}

            </td>

        </tr>

        <tr>

            <th>

                Net Salary

            </th>

            <td class="net-salary">

                ₹ {{ number_format($payroll->net_salary,2) }}

            </td>

        </tr>

    </table>

</body>

</html>