<!DOCTYPE html>

<html>

<head>

    <title>

        Payslip

    </title>

    <style>

        body{
            font-family: sans-serif;
            font-size: 14px;
        }

        table{
            width:100%;
            border-collapse: collapse;
        }

        table td,
        table th{
            border:1px solid #ccc;
            padding:8px;
        }

        .text-center{
            text-align:center;
        }

    </style>

</head>

<body>

    <h2 class="text-center">

        Salary Payslip

    </h2>

    <table>

        <tr>

            <th>Employee</th>

            <td>

                {{ $payroll->user->name }}

            </td>

        </tr>

        <tr>

            <th>Designation</th>

            <td>

                {{ $payroll->user->designation }}

            </td>

        </tr>

        <tr>

            <th>Month</th>

            <td>

                {{ date('F', mktime(0,0,0,$payroll->month,1)) }}
                {{ $payroll->year }}

            </td>

        </tr>

    </table>

    <br>

    <table>

        <tr>

            <th>Earnings</th>

            <th>Amount</th>

            <th>Deductions</th>

            <th>Amount</th>

        </tr>

        <tr>

            <td>Basic Salary</td>

            <td>{{ $payroll->basic_salary }}</td>

            <td>PF</td>

            <td>{{ $payroll->pf }}</td>

        </tr>

        <tr>

            <td>HRA</td>

            <td>{{ $payroll->hra }}</td>

            <td>ESI</td>

            <td>{{ $payroll->esi }}</td>

        </tr>

        <tr>

            <td>DA</td>

            <td>{{ $payroll->da }}</td>

            <td>TDS</td>

            <td>{{ $payroll->tds }}</td>

        </tr>

        <tr>

            <td>TA</td>

            <td>{{ $payroll->ta }}</td>

            <td>Professional Tax</td>

            <td>{{ $payroll->professional_tax }}</td>

        </tr>

        <tr>

            <td>Bonus</td>

            <td>{{ $payroll->bonus }}</td>

            <td>Other Deduction</td>

            <td>{{ $payroll->other_deduction }}</td>

        </tr>

    </table>

    <br>

    <table>

        <tr>

            <th>Present Days</th>

            <td>{{ $payroll->present_days }}</td>

            <th>Absent Days</th>

            <td>{{ $payroll->absent_days }}</td>

        </tr>

        <tr>

            <th>Gross Salary</th>

            <td>{{ $payroll->gross_salary }}</td>

            <th>Total Deduction</th>

            <td>{{ $payroll->total_deduction }}</td>

        </tr>

        <tr>

            <th colspan="2">

                Net Salary

            </th>

            <th colspan="2">

                ₹ {{ number_format($payroll->net_salary,2) }}

            </th>

        </tr>

    </table>

</body>

</html>