<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Attendance;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Safe Role
        |--------------------------------------------------------------------------
        */

        $roleName = strtolower(
            optional($user->role)->name ?? ''
        );

        /*
        |--------------------------------------------------------------------------
        | Default Collections
        |--------------------------------------------------------------------------
        */

        $teamMembers = collect();

        /*
        |--------------------------------------------------------------------------
        | ADMIN / HR
        |--------------------------------------------------------------------------
        */

        if(
            in_array($roleName, [

                'admin',
                'hr'

            ])
        ) {

            $teamMembers = User::where(
                'status',
                'Active'
            )->latest()->get();
        }

        /*
        |--------------------------------------------------------------------------
        | DEPARTMENT HEAD
        |--------------------------------------------------------------------------
        */

        elseif($roleName == 'department head') {

            /*
            |--------------------------------------------------------------------------
            | Get Department IDs
            |--------------------------------------------------------------------------
            */

            $departmentIds = $user->departments
                ->pluck('id');

            /*
            |--------------------------------------------------------------------------
            | Team Members
            |--------------------------------------------------------------------------
            */

            $teamMembers = User::whereHas(

                'departments',

                function($q) use ($departmentIds) {

                    $q->whereIn(

                        'departments.id',

                        $departmentIds

                    );
                }

            )->where(

                'status',

                'Active'

            )->latest()->get();
        }

        /*
        |--------------------------------------------------------------------------
        | TEAM LEAD
        |--------------------------------------------------------------------------
        */

        elseif($roleName == 'team lead') {

            /*
            |--------------------------------------------------------------------------
            | Reporting Employees
            |--------------------------------------------------------------------------
            */

            if(method_exists($user, 'teamMembers')) {

                $teamMembers = $user->teamMembers()
                    ->where(
                        'status',
                        'Active'
                    )
                    ->latest()
                    ->get();
            }
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

        $employees = $teamMembers->count();

        /*
        |--------------------------------------------------------------------------
        | Projects Count
        |--------------------------------------------------------------------------
        */

        $projects = Project::whereHas(

            'users',

            function($q) use ($employeeIds) {

                $q->whereIn(

                    'users.id',

                    $employeeIds

                );
            }

        )->count();

        /*
        |--------------------------------------------------------------------------
        | Today's Attendance
        |--------------------------------------------------------------------------
        */

        $todayAttendance = Attendance::whereIn(

            'user_id',

            $employeeIds

        )->whereDate(

            'attendance_date',

            today()

        )->count();

        /*
        |--------------------------------------------------------------------------
        | Pending Leaves
        |--------------------------------------------------------------------------
        */

        $pendingLeaves = 0;

        if(class_exists(\App\Models\LeaveRequest::class)) {

            $pendingLeaves = LeaveRequest::whereIn(

                'user_id',

                $employeeIds

            )->where(

                'status',

                'Pending'

            )->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Attendance Widget
        |--------------------------------------------------------------------------
        */

        $todayUserAttendance = Attendance::where(

            'user_id',

            $user->id

        )->whereDate(

            'attendance_date',

            today()

        )->first();

        /*
        |--------------------------------------------------------------------------
        | Weekly Off / Holiday
        |--------------------------------------------------------------------------
        */

        $dayName = now()->format('l');

        $isWeeklyOff = in_array($dayName, [

            'Saturday',
            'Sunday'

        ]);

        $isHoliday = false;

        if(class_exists(\App\Models\Holiday::class)) {

            $isHoliday = \App\Models\Holiday::where(

                'holiday_date',

                today()

            )->where(

                'status',

                'Active'

            )->exists();
        }

        /*
        |--------------------------------------------------------------------------
        | Latest Members
        |--------------------------------------------------------------------------
        */

        $latestMembers = $teamMembers
            ->take(10);

        return view('dashboard', compact(

            'roleName',

            'employees',

            'projects',

            'todayAttendance',

            'pendingLeaves',

            'teamMembers',

            'latestMembers',

            'todayUserAttendance',

            'isWeeklyOff',

            'isHoliday',

            'dayName'

        ));
    }
}