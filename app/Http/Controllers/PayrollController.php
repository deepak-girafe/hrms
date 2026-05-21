<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Payroll;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PayrollExport;
use Barryvdh\DomPDF\Facade\Pdf;

class PayrollController extends Controller
{
    /**
     * Payroll List
     */
    public function index(Request $request)
    {
        $query = Payroll::with('user');

        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        if($request->month) {

            $query->where(
                'month',
                $request->month
            );
        }

        if($request->year) {

            $query->where(
                'year',
                $request->year
            );
        }

        if($request->status) {

            $query->where(
                'status',
                $request->status
            );
        }

        $payrolls = $query
            ->latest()
            ->paginate(20);

        return view(

            'payrolls.index',

            compact('payrolls')

        );
    }

    /**
     * Generate Payroll
     */
    public function generate(Request $request)
    {
        $request->validate([
    
            'month' => 'required',
    
            'year' => 'required'
    
        ]);
    
        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */
    
        $users = User::where(
            'status',
            'Active'
        )->get();
    
        foreach($users as $user) {
    
            /*
            |--------------------------------------------------------------------------
            | Attendance
            |--------------------------------------------------------------------------
            */
    
            $presentDays = Attendance::where(
    
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
    
            ->where(
                'status',
                'Present'
            )
    
            ->count();
    
            /*
            |--------------------------------------------------------------------------
            | Month Days
            |--------------------------------------------------------------------------
            */
    
            $totalMonthDays = cal_days_in_month(
    
                CAL_GREGORIAN,
    
                $request->month,
    
                $request->year
    
            );
    
            /*
            |--------------------------------------------------------------------------
            | Leave Days
            |--------------------------------------------------------------------------
            */
    
            $leaveDays = 0;
    
            /*
            |--------------------------------------------------------------------------
            | Absent Days
            |--------------------------------------------------------------------------
            */
    
            $absentDays =
    
                $totalMonthDays -
    
                ($presentDays + $leaveDays);
    
            /*
            |--------------------------------------------------------------------------
            | Gross Base Salary
            |--------------------------------------------------------------------------
            */
    
            $grossBaseSalary =
    
                ($user->basic_salary ?? 0) +
    
                ($user->hra ?? 0) +
    
                ($user->da ?? 0) +
    
                ($user->ta ?? 0) +
    
                ($user->bonus ?? 0) +
    
                ($user->incentive ?? 0) +
    
                ($user->other_allowance ?? 0);
    
            /*
            |--------------------------------------------------------------------------
            | Per Day Salary
            |--------------------------------------------------------------------------
            */
    
            $perDaySalary =
    
                $totalMonthDays > 0
    
                ? ($grossBaseSalary / $totalMonthDays)
    
                : 0;
    
            /*
            |--------------------------------------------------------------------------
            | Salary According Attendance
            |--------------------------------------------------------------------------
            */
    
            $grossSalary = round(
    
                $perDaySalary *
    
                ($presentDays + $leaveDays),
    
                2
    
            );
    
            /*
            |--------------------------------------------------------------------------
            | Deductions
            |--------------------------------------------------------------------------
            */
    
            $pf = $user->pf ?? 0;
    
            $esi = $user->esi ?? 0;
    
            $tds = $user->tds ?? 0;
    
            $professionalTax =
                $user->professional_tax ?? 0;
    
            $otherDeduction =
                $user->other_deduction ?? 0;
    
            $totalDeduction =
    
                $pf +
    
                $esi +
    
                $tds +
    
                $professionalTax +
    
                $otherDeduction;
    
            /*
            |--------------------------------------------------------------------------
            | Net Salary
            |--------------------------------------------------------------------------
            */
    
            $netSalary =
    
                $grossSalary - $totalDeduction;
    
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
    
                    'salary_month' => date(
    
                        'F',
    
                        mktime(
                            0,
                            0,
                            0,
                            $request->month,
                            1
                        )
    
                    ),
    
                    'working_days' =>
                        $totalMonthDays,
    
                    'present_days' =>
                        $presentDays,
    
                    'leave_days' =>
                        $leaveDays,
    
                    'absent_days' =>
                        $absentDays,
    
                    'basic_salary' =>
                        $user->basic_salary ?? 0,
    
                    'hra' =>
                        $user->hra ?? 0,
    
                    'da' =>
                        $user->da ?? 0,
    
                    'ta' =>
                        $user->ta ?? 0,
    
                    'bonus' =>
                        $user->bonus ?? 0,
    
                    'incentive' =>
                        $user->incentive ?? 0,
    
                    'other_allowance' =>
                        $user->other_allowance ?? 0,
    
                    'pf' => $pf,
    
                    'esi' => $esi,
    
                    'tds' => $tds,
    
                    'professional_tax' =>
                        $professionalTax,
    
                    'other_deduction' =>
                        $otherDeduction,
    
                    'gross_salary' =>
                        $grossSalary,
    
                    'total_deduction' =>
                        $totalDeduction,
    
                    'net_salary' =>
                        $netSalary,
    
                    'salary_date' => now(),
    
                    'payment_status' =>
                        'Pending'
    
                ]
    
            );
        }
    
        return redirect()
    
            ->route('payrolls.index')
    
            ->with(
    
                'success',
    
                'Payroll generated successfully'
    
            );
    }

    /**
     * Mark Paid
     */
    public function markPaid($id)
    {
        $payroll = Payroll::findOrFail($id);

        $payroll->update([

            'payment_status' => 'Paid'

        ]);

        return back()->with(

            'success',

            'Payroll marked as paid'

        );
    }

    /**
     * Export Excel
     */
    public function exportExcel()
    {
        return Excel::download(

            new PayrollExport,

            'payroll.xlsx'

        );
    }

    /**
     * Payslip PDF
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
     * Delete Payroll
     */
    public function destroy($id)
    {
        $payroll = Payroll::findOrFail($id);

        $payroll->delete();

        return back()->with(

            'success',

            'Payroll deleted successfully'

        );
    }
}