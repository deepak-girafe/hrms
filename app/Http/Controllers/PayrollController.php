<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payroll;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PayrollExport;
use Maatwebsite\Excel\Facades\Excel;

class PayrollController extends Controller
{
    /**
     * Payroll List
     */
    public function index()
    {
        $payrolls = Payroll::with('user')

            ->latest()

            ->paginate(10);

        return view(

            'payrolls.index',

            compact('payrolls')

        );
    }

    /**
     * Generate Payroll
     */
    public function generatePayroll(Request $request)
    {
        $request->validate([

            'month' => 'required',

            'year' => 'required'

        ]);

        /*
        |--------------------------------------------------------------------------
        | Employees Except Admin
        |--------------------------------------------------------------------------
        */

        $users = User::with([

                'salaryStructure',
                'role'

            ])

            ->whereHas('role', function($q){

                $q->whereRaw(

                    'LOWER(name) != ?',

                    ['admin']

                );

            })

            ->where('status', 'Active')

            ->get();

        /*
        |--------------------------------------------------------------------------
        | Loop Employees
        |--------------------------------------------------------------------------
        */

        foreach($users as $user) {

            /*
            |--------------------------------------------------------------------------
            | Salary Structure
            |--------------------------------------------------------------------------
            */

            $salary = $user->salaryStructure;

            if(!$salary) {

                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Total Month Days
            |--------------------------------------------------------------------------
            */

            $totalMonthDays = Carbon::create(

                $request->year,
                $request->month,
                1

            )->daysInMonth;

            /*
            |--------------------------------------------------------------------------
            | Attendance Records
            |--------------------------------------------------------------------------
            */

            $attendanceRecords = Attendance::where(

                'user_id',
                $user->id

            )

            ->whereMonth(
                'attendance_date',
                $request->month
            )

            ->whereYear(
                'attendance_date',
                $request->year
            )

            ->get();

            /*
            |--------------------------------------------------------------------------
            | Attendance Calculations
            |--------------------------------------------------------------------------
            */

            $presentDays = 0;

            $halfDays = 0;

            $unpaidLeaves = 0;

            foreach($attendanceRecords as $attendance) {

                /*
                |--------------------------------------------------------------------------
                | Punch In / Out Required
                |--------------------------------------------------------------------------
                */

                if(

                    !$attendance->punch_in

                    ||

                    !$attendance->punch_out

                ) {

                    $unpaidLeaves++;

                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | Full Datetime
                |--------------------------------------------------------------------------
                */

                $punchIn = Carbon::parse(

                    $attendance->attendance_date .

                    ' ' .

                    $attendance->punch_in

                );

                $punchOut = Carbon::parse(

                    $attendance->attendance_date .

                    ' ' .

                    $attendance->punch_out

                );

                /*
                |--------------------------------------------------------------------------
                | Working Hours
                |--------------------------------------------------------------------------
                */

                $workingHours = round(

                    abs(

                        $punchOut
                            ->diffInMinutes($punchIn)

                    ) / 60,

                    2

                );

                /*
                |--------------------------------------------------------------------------
                | Attendance Rules
                |--------------------------------------------------------------------------
                */

                /*
                |--------------------------------------------------------------------------
                | Less Than 4.5 Hours
                |--------------------------------------------------------------------------
                */

                if($workingHours < 4.5) {

                    $unpaidLeaves++;
                }

                /*
                |--------------------------------------------------------------------------
                | Half Day
                |--------------------------------------------------------------------------
                */

                elseif(

                    $workingHours >= 4.5

                    &&

                    $workingHours < 7

                ) {

                    $halfDays += 1;
                }

                /*
                |--------------------------------------------------------------------------
                | Full Day
                |--------------------------------------------------------------------------
                */

                else {

                    $presentDays += 1;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Deductible Days
            |--------------------------------------------------------------------------
            */

            $deductibleDays =

                $unpaidLeaves +

                ($halfDays * 0.5);

            /*
            |--------------------------------------------------------------------------
            | Gross Salary
            |--------------------------------------------------------------------------
            */

            $grossSalary =

                ($salary->basic_salary ?? 0) +

                ($salary->hra ?? 0) +

                ($salary->da ?? 0) +

                ($salary->ta ?? 0) +

                ($salary->medical_allowance ?? 0) +

                ($salary->bonus ?? 0) +

                ($salary->special_allowance ?? 0);

            /*
            |--------------------------------------------------------------------------
            | Salary Deductions
            |--------------------------------------------------------------------------
            */

            $salaryDeductions =

                ($salary->pf_deduction ?? 0) +

                ($salary->esi_deduction ?? 0) +

                ($salary->tds_deduction ?? 0) +

                ($salary->loan_deduction ?? 0) +

                ($salary->other_deduction ?? 0);

            /*
            |--------------------------------------------------------------------------
            | Per Day Salary
            |--------------------------------------------------------------------------
            */

            $perDaySalary =

                $grossSalary / $totalMonthDays;

            /*
            |--------------------------------------------------------------------------
            | Attendance Deduction
            |--------------------------------------------------------------------------
            */

            $attendanceDeduction =

                $perDaySalary *

                $deductibleDays;

            /*
            |--------------------------------------------------------------------------
            | Total Deduction
            |--------------------------------------------------------------------------
            */

            $totalDeduction =

                $salaryDeductions +

                $attendanceDeduction;

            /*
            |--------------------------------------------------------------------------
            | Net Salary
            |--------------------------------------------------------------------------
            */

            $netSalary =

                max(

                    0,

                    $grossSalary -

                    $totalDeduction

                );

            /*
            |--------------------------------------------------------------------------
            | Save Payroll
            |--------------------------------------------------------------------------
            */

            Payroll::updateOrCreate(

                [

                    'user_id' => $user->id,

                    'month' => $request->month,

                    'year' => $request->year

                ],

                [

                    /*
                    |--------------------------------------------------------------------------
                    | Month
                    |--------------------------------------------------------------------------
                    */

                    'salary_month' =>

                        date(

                            'F',

                            mktime(
                                0,
                                0,
                                0,
                                $request->month,
                                1
                            )

                        ),

                    /*
                    |--------------------------------------------------------------------------
                    | Attendance
                    |--------------------------------------------------------------------------
                    */

                    'working_days' =>
                        $totalMonthDays,

                    'present_days' =>
                        $presentDays,

                    'half_days' =>
                        $halfDays,

                    'leave_days' =>
                        $unpaidLeaves,

                    'absent_days' =>
                        $deductibleDays,

                    /*
                    |--------------------------------------------------------------------------
                    | Earnings
                    |--------------------------------------------------------------------------
                    */

                    'basic_salary' =>
                        $salary->basic_salary ?? 0,

                    'hra' =>
                        $salary->hra ?? 0,

                    'da' =>
                        $salary->da ?? 0,

                    'ta' =>
                        $salary->ta ?? 0,

                    'bonus' =>
                        $salary->bonus ?? 0,

                    'incentive' =>
                        $salary->special_allowance ?? 0,

                    'other_allowance' =>
                        $salary->medical_allowance ?? 0,

                    /*
                    |--------------------------------------------------------------------------
                    | Deductions
                    |--------------------------------------------------------------------------
                    */

                    'pf' =>
                        $salary->pf_deduction ?? 0,

                    'esi' =>
                        $salary->esi_deduction ?? 0,

                    'tds' =>
                        $salary->tds_deduction ?? 0,

                    'professional_tax' =>
                        0,

                    'other_deduction' =>
                        $salary->other_deduction ?? 0,

                    /*
                    |--------------------------------------------------------------------------
                    | Final Salary
                    |--------------------------------------------------------------------------
                    */

                    'gross_salary' =>
                        round($grossSalary, 2),

                    'total_deduction' =>
                        round($totalDeduction, 2),

                    'net_salary' =>
                        round($netSalary, 2),

                    /*
                    |--------------------------------------------------------------------------
                    | Payment
                    |--------------------------------------------------------------------------
                    */

                    'salary_date' =>
                        now(),

                    'payment_status' =>
                        'Pending'

                ]

            );
        }

        return back()->with(

            'success',

            'Payroll generated successfully'

        );
    }

    /**
     * Mark Salary Paid
     */
    public function markPaid($id)
    {
        $payroll = Payroll::findOrFail($id);

        $payroll->update([

            'payment_status' => 'Paid'

        ]);

        return back()->with(

            'success',

            'Salary marked as paid'

        );
    }

    /**
     * Download Payslip
     */
    public function payslip($id)
    {
        $payroll = Payroll::with('user')
            ->findOrFail($id);

        $pdf = Pdf::loadView(

            'payrolls.payslip',

            compact('payroll')

        );

        return $pdf->download(

            'Payslip-' .

            $payroll->user->name .

            '.pdf'

        );
    }

    /**
     * Export Excel
     */
    public function export()
    {
        return Excel::download(

            new PayrollExport,

            'payrolls.xlsx'

        );
    }
}