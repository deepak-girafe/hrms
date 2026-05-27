<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Role
        |--------------------------------------------------------------------------
        */

        $roleName = strtolower(

            optional($user->role)->name ?? ''

        );

        /*
        |--------------------------------------------------------------------------
        | Default
        |--------------------------------------------------------------------------
        */

        $teamMembers = collect();

        /*
        |--------------------------------------------------------------------------
        | ADMIN / HR
        |--------------------------------------------------------------------------
        */

        if(

            in_array(

                $roleName,

                [

                    'admin',

                    'hr'

                ]

            )

        ) {

            $teamMembers = User::where(

                    'status',

                    'Active'

                )

                ->latest()

                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | DEPARTMENT HEAD / TEAM LEAD
        |--------------------------------------------------------------------------
        */

        elseif(

            in_array(

                $roleName,

                [

                    'department head',

                    'team lead'

                ]

            )

        ) {

            $teamMembers = User::whereIn(

                    'id',

                    DB::table('user_reporting')

                        ->where(

                            'reporting_user_id',

                            $user->id

                        )

                        ->pluck('user_id')

                )

                ->where(

                    'status',

                    'Active'

                )

                ->latest()

                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | EMPLOYEE
        |--------------------------------------------------------------------------
        */

        else {

            $teamMembers = collect([
                $user
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Employee IDs
        |--------------------------------------------------------------------------
        */

        $employeeIds = $teamMembers
            ->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | Employees Count
        |--------------------------------------------------------------------------
        */

        $employees = $teamMembers
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Projects Count
        |--------------------------------------------------------------------------
        */

        $projects = Project::whereHas(

                'users',

                function($q) use ($employeeIds){

                    $q->whereIn(

                        'users.id',

                        $employeeIds

                    );
                }

            )

            ->count();

        /*
        |--------------------------------------------------------------------------
        | Employees On Leave Today
        |--------------------------------------------------------------------------
        */

        $onLeaveToday = 0;

        if(class_exists(\App\Models\LeaveApplication::class)) {

            $onLeaveToday = \App\Models\LeaveApplication::whereIn(

                    'user_id',

                    $employeeIds

                )

                ->where(

                    'status',

                    'Approved'

                )

                ->whereDate(

                    'from_date',

                    '<=',

                    today()

                )

                ->whereDate(

                    'to_date',

                    '>=',

                    today()

                )

                ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Today's Attendance
        |--------------------------------------------------------------------------
        */

        $todayAttendance = Attendance::whereIn(

                'user_id',

                $employeeIds

            )

            ->whereDate(

                'attendance_date',

                today()

            )

            ->count();

        /*
        |--------------------------------------------------------------------------
        | Current User Attendance
        |--------------------------------------------------------------------------
        */

        $todayUserAttendance = Attendance::where(

                'user_id',

                $user->id

            )

            ->whereDate(

                'attendance_date',

                today()

            )

            ->first();

        /*
        |--------------------------------------------------------------------------
        | Weekly Off
        |--------------------------------------------------------------------------
        */

        $dayName = now()->format('l');

        $isWeeklyOff = in_array(

            $dayName,

            [

                'Saturday',

                'Sunday'

            ]

        );

        /*
        |--------------------------------------------------------------------------
        | Holiday
        |--------------------------------------------------------------------------
        */

        $isHoliday = false;

        if(class_exists(\App\Models\Holiday::class)) {

            $isHoliday = \App\Models\Holiday::where(

                    'holiday_date',

                    today()

                )

                ->where(

                    'status',

                    'Active'

                )

                ->exists();
        }

        /*
        |--------------------------------------------------------------------------
        | Latest Members
        |--------------------------------------------------------------------------
        */

        

        $latestMembers = $teamMembers
            ->take(10);



        /*
        |--------------------------------------------------------------------------
        | Pending Leave Requests
        |--------------------------------------------------------------------------
        */

        $pendingLeaveRequests = 0;

        if(class_exists(\App\Models\LeaveApplication::class)) {

            // HR
            if($roleName == 'hr') {

                $pendingLeaveRequests = \App\Models\LeaveApplication::whereNotIn(
                        'status',
                        ['Approved', 'Rejected']
                    )
                    ->count();

            }

            // Department Head & Team Lead
            elseif(

                in_array(

                    $roleName,

                    [

                        'department head',

                        'team lead'

                    ]

                )

            ) {

                $reportingUserIds = DB::table('user_reporting')

                    ->where(
                        'reporting_user_id',
                        $user->id
                    )

                    ->pluck('user_id');

                $pendingLeaveRequests = \App\Models\LeaveApplication::whereIn(
                        'user_id',
                        $reportingUserIds
                    )

                    ->whereNotIn(
                        'status',
                        ['Approved', 'Rejected']
                    )

                    ->count();
            }
        }

        return view(

            'dashboard',

            compact(

                'roleName',

                'employees',

                'projects',

                'onLeaveToday',

                'todayAttendance',

                'teamMembers',

                'latestMembers',

                'todayUserAttendance',

                'isWeeklyOff',

                'isHoliday',

                'dayName',

                'pendingLeaveRequests'

            )

        );
    }
}