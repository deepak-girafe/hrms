<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\LeaveApplication;
use App\Models\Payroll;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\DailyEod;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Reports Dashboard
     */
    public function dashboard()
    {
        $data = [

            /*
            |--------------------------------------------------------------------------
            | Employees
            |--------------------------------------------------------------------------
            */

            'totalEmployees' => User::count(),

            'activeEmployees' => User::where(
                'status',
                'Active'
            )->count(),

            /*
            |--------------------------------------------------------------------------
            | Attendance
            |--------------------------------------------------------------------------
            */

            'todayPresent' => Attendance::whereDate(

                    'attendance_date',

                    today()

                )

                ->distinct('user_id')

                ->count(),

            /*
            |--------------------------------------------------------------------------
            | Payroll
            |--------------------------------------------------------------------------
            */

            'totalPayroll' => Payroll::sum(

                'net_salary'

            ),

            /*
            |--------------------------------------------------------------------------
            | Leaves
            |--------------------------------------------------------------------------
            */

            'pendingLeaves' => LeaveApplication::where(

                    'status',

                    'Pending'

                )

                ->count(),

            /*
            |--------------------------------------------------------------------------
            | EOD
            |--------------------------------------------------------------------------
            */

            'todayEods' => DailyEod::whereDate(

                    'eod_date',

                    today()

                )

                ->count()

        ];

        return view(

            'reports.dashboard',

            compact('data')

        );
    }

    /**
     * Attendance Report
     */
    public function attendance(Request $request)
    {
        $attendance = Attendance::with('user')

            ->when(

                $request->month,

                function($q) use ($request){

                    $q->whereMonth(

                        'attendance_date',

                        $request->month

                    );
                }

            )

            ->latest()

            ->paginate(20);

        return view(

            'reports.attendance',

            compact('attendance')

        );
    }

    /**
     * Payroll Report
     */
    public function payroll(Request $request)
    {
        $payrolls = Payroll::with('user')

            ->when(

                $request->month,

                function($q) use ($request){

                    $q->where(

                        'month',

                        $request->month

                    );
                }

            )

            ->latest()

            ->paginate(20);

        return view(

            'reports.payroll',

            compact('payrolls')

        );
    }

    /**
     * Leave Report
     */
    public function leaves()
    {
        $leaves = Leave::with('user')

            ->latest()

            ->paginate(20);

        return view(

            'reports.leaves',

            compact('leaves')

        );
    }

    /**
     * EOD Report
     */
    public function eod()
    {
        $eods = DailyEod::with([

                'user',
                'items.project'

            ])

            ->latest()

            ->paginate(20);

        return view(

            'reports.eod',

            compact('eods')

        );
    }

    /**
     * Department Report
     */
    public function department()
    {
        $departments = Department::withCount(

            'users'

        )->get();

        return view(

            'reports.department',

            compact('departments')

        );
    }
}