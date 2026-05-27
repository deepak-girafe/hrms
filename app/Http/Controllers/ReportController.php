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

            /*
            |--------------------------------------------------------------------------
            | Employee Search
            |--------------------------------------------------------------------------
            */

            ->when(

                $request->employee,

                function($q) use ($request){

                    $q->whereHas(

                        'user',

                        function($subQ) use ($request){

                            $subQ->where(

                                'name',

                                'like',

                                '%' . $request->employee . '%'

                            )

                            ->orWhere(

                                'employee_code',

                                'like',

                                '%' . $request->employee . '%'

                            );
                        }

                    );
                }

            )

            /*
            |--------------------------------------------------------------------------
            | From Date
            |--------------------------------------------------------------------------
            */

            ->when(

                $request->from_date,

                function($q) use ($request){

                    $q->whereDate(

                        'attendance_date',

                        '>=',

                        $request->from_date

                    );
                }

            )

            /*
            |--------------------------------------------------------------------------
            | To Date
            |--------------------------------------------------------------------------
            */

            ->when(

                $request->to_date,

                function($q) use ($request){

                    $q->whereDate(

                        'attendance_date',

                        '<=',

                        $request->to_date

                    );
                }

            )

            ->latest('attendance_date')

            ->paginate(20)

            ->withQueryString();

        return view(

            'reports.attendance',

            compact(

                'attendance'

            )

        );
    }

    /**
     * Payroll Report
     */
    public function payroll(Request $request)
        {
            $payrolls = Payroll::with('user')

                /*
                |--------------------------------------------------------------------------
                | Employee Search
                |--------------------------------------------------------------------------
                */

                ->when(

                    $request->employee,

                    function($q) use ($request){

                        $q->whereHas(

                            'user',

                            function($subQ) use ($request){

                                $subQ->where(

                                    'name',

                                    'like',

                                    '%' . $request->employee . '%'

                                )

                                ->orWhere(

                                    'employee_code',

                                    'like',

                                    '%' . $request->employee . '%'

                                );
                            }

                        );
                    }

                )

                /*
                |--------------------------------------------------------------------------
                | Salary Month Filter
                |--------------------------------------------------------------------------
                */

                ->when(

                    $request->salary_month,
                
                    function($q) use ($request){
                
                        $date = explode(
                
                            '-',
                
                            $request->salary_month
                
                        );
                
                        $year = $date[0] ?? null;
                
                        $month = $date[1] ?? null;
                
                        $q->where(
                
                                'year',
                
                                $year
                
                            )
                
                            ->where(
                
                                'month',
                
                                (int)$month
                
                            );
                    }
                
                )

                /*
                |--------------------------------------------------------------------------
                | Payment Status Filter
                |--------------------------------------------------------------------------
                */

                ->when(

                    $request->payment_status,

                    function($q) use ($request){

                        $q->where(

                            'payment_status',

                            $request->payment_status

                        );
                    }

                )

                ->latest()

                ->paginate(20)

                ->withQueryString();

            return view(

                'reports.payroll',

                compact(

                    'payrolls'

                )

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