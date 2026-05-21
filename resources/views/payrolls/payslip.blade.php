<!DOCTYPE html>

<html>

<head>

    <title>

        Salary Payslip

    </title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:13px;
            color:#222;
        }

        .header{
            text-align:center;
            margin-bottom:20px;
        }

        .header h2{
            margin:0;
            font-size:28px;
        }

        table{
            width:100%;
            border-collapse: collapse;
            margin-bottom:18px;
        }

        table td,
        table th{
            border:1px solid #dcdcdc;
            padding:10px;
        }

        table th{
            background:#f5f5f5;
        }

        .net{
            font-size:18px;
            font-weight:bold;
            color:#118c4f;
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

                Employee Name

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

    {{-- ATTENDANCE SUMMARY --}}

    <table>

        <tr>

            <th>Total Month Days</th>
            <td>{{ $payroll->working_days }}</td>

            <th>Present Days</th>
            <td>{{ number_format($payroll->present_days,1) }}</td>

        </tr>

        <tr>

            <th>Unpaid Leaves</th>
            <td>{{ number_format($payroll->leave_days,1) }}</td>

            <th>Deductible Days</th>
            <td>{{ number_format($payroll->absent_days,1) }}</td>

        </tr>

        <tr>

            <th>Salary Status</th>
            <td>{{ $payroll->payment_status }}</td>

            <th>Salary Date</th>
            <td>

                {{ date('d M Y', strtotime($payroll->salary_date)) }}

            </td>

        </tr>

    </table>

    {{-- EARNINGS --}}

    <table>

        <tr>

            <th>Earnings</th>
            <th>Amount</th>

        </tr>

        <tr>
            <td>Basic Salary</td>
            <td>₹ {{ number_format($payroll->basic_salary,2) }}</td>
        </tr>

        <tr>
            <td>HRA</td>
            <td>₹ {{ number_format($payroll->hra,2) }}</td>
        </tr>

        <tr>
            <td>DA</td>
            <td>₹ {{ number_format($payroll->da,2) }}</td>
        </tr>

        <tr>
            <td>TA</td>
            <td>₹ {{ number_format($payroll->ta,2) }}</td>
        </tr>

        <tr>
            <td>Bonus</td>
            <td>₹ {{ number_format($payroll->bonus,2) }}</td>
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

            <td class="net">

                ₹ {{ number_format($payroll->net_salary,2) }}

            </td>

        </tr>

    </table>

</body>

</html>