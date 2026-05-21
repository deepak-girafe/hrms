<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Attendance Page
     */
    public function index()
    {
        $today = now()->toDateString();

        $dayName = now()->format('l');

        /*
        |--------------------------------------------------------------------------
        | Weekly Off
        |--------------------------------------------------------------------------
        */

        $isWeeklyOff = in_array($dayName, [

            'Saturday',
            'Sunday'

        ]);

        /*
        |--------------------------------------------------------------------------
        | Holiday Check
        |--------------------------------------------------------------------------
        */

        $isHoliday = Holiday::where(
            'holiday_date',
            $today
        )->where(
            'status',
            'Active'
        )->exists();

        /*
        |--------------------------------------------------------------------------
        | Today's Attendance
        |--------------------------------------------------------------------------
        */

        $attendance = Attendance::where(
            'user_id',
            auth()->id()
        )->where(
            'attendance_date',
            $today
        )->first();

        /*
        |--------------------------------------------------------------------------
        | Monthly Attendance
        |--------------------------------------------------------------------------
        */

        $monthlyAttendance = Attendance::where(
            'user_id',
            auth()->id()
        )->whereMonth(
            'attendance_date',
            now()->month
        )->get();

        return view('attendance.index', compact(

            'attendance',
            'monthlyAttendance',
            'isWeeklyOff',
            'isHoliday',
            'dayName'

        ));
    }

    /**
     * Punch In
     */
    public function punchIn(Request $request)
    {
        $today = now()->toDateString();

        $existing = Attendance::where(
            'user_id',
            auth()->id()
        )->where(
            'attendance_date',
            $today
        )->first();

        if($existing) {

            return back()->with(
                'error',
                'Attendance already marked'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save Selfie
        |--------------------------------------------------------------------------
        */

        $imageName = null;

        if($request->image) {

            $image = $request->image;

            $image = str_replace(
                'data:image/png;base64,',
                '',
                $image
            );

            $image = str_replace(
                ' ',
                '+',
                $image
            );

            $imageData = base64_decode($image);

            $folderPath = public_path(
                'uploads/attendance'
            );

            if(!file_exists($folderPath)) {

                mkdir(
                    $folderPath,
                    0777,
                    true
                );
            }

            $imageName = 'attendance_in_' .
                time() .
                '.png';

            file_put_contents(

                public_path(
                    'uploads/attendance/' .
                    $imageName
                ),

                $imageData

            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save Attendance
        |--------------------------------------------------------------------------
        */

        Attendance::create([

            'user_id' => auth()->id(),

            'attendance_date' => $today,

            'punch_in' => now()->format('H:i:s'),

            'punch_in_image' => $imageName,

            'punch_in_latitude' => $request->latitude,

            'punch_in_longitude' => $request->longitude,

            'status' => 'Present'

        ]);

        return back()->with(
            'success',
            'Punch in successful'
        );
    }

    /**
     * Punch Out
     */
    public function punchOut(Request $request)
    {
        $attendance = Attendance::where(
            'user_id',
            auth()->id()
        )->where(
            'attendance_date',
            now()->toDateString()
        )->first();

        if(!$attendance) {

            return back()->with(
                'error',
                'Punch in first'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save Selfie
        |--------------------------------------------------------------------------
        */

        $imageName = null;

        if($request->image) {

            $image = $request->image;

            $image = str_replace(
                'data:image/png;base64,',
                '',
                $image
            );

            $image = str_replace(
                ' ',
                '+',
                $image
            );

            $imageData = base64_decode($image);

            $folderPath = public_path(
                'uploads/attendance'
            );

            if(!file_exists($folderPath)) {

                mkdir(
                    $folderPath,
                    0777,
                    true
                );
            }

            $imageName = 'attendance_out_' .
                time() .
                '.png';

            file_put_contents(

                public_path(
                    'uploads/attendance/' .
                    $imageName
                ),

                $imageData

            );
        }

        /*
        |--------------------------------------------------------------------------
        | Working Hours
        |--------------------------------------------------------------------------
        */

        $punchIn = Carbon::parse(
            $attendance->punch_in
        );

        $punchOut = now();

        $workingHours = $punchIn
            ->diffInMinutes($punchOut) / 60;

        /*
        |--------------------------------------------------------------------------
        | Update Attendance
        |--------------------------------------------------------------------------
        */

        $attendance->update([

            'punch_out' => now()->format('H:i:s'),

            'punch_out_image' => $imageName,

            'working_hours' => round(
                $workingHours,
                2
            ),

            'punch_out_latitude' => $request->latitude,

            'punch_out_longitude' => $request->longitude

        ]);

        return back()->with(
            'success',
            'Punch out successful'
        );
    }
    /**
     * Attendance Events
     */
    public function events(Request $request)
    {
        $attendances = Attendance::where(
            'user_id',
            auth()->id()
        )

        ->whereBetween(

            'attendance_date',

            [
                $request->start,
                $request->end
            ]

        )

        ->get();

        $events = [];

        foreach($attendances as $attendance) {

            $events[] = [

                'title' =>

                    Carbon::parse(
                        $attendance->punch_in
                    )->format('h:i A')

                    . ' IN | ' .

                    ($attendance->punch_out

                        ? Carbon::parse(
                            $attendance->punch_out
                        )->format('h:i A')

                        : '-'),

                'start' => $attendance->attendance_date,

                'color' =>

                    $attendance->status == 'Present'

                    ? '#198754'

                    : '#dc3545',

                'extendedProps' => [

                    'punchIn' =>

                        $attendance->punch_in

                        ? Carbon::parse(
                            $attendance->punch_in
                        )->format('h:i A')

                        : '-',

                    'punchOut' =>

                        $attendance->punch_out

                        ? Carbon::parse(
                            $attendance->punch_out
                        )->format('h:i A')

                        : '-',

                    'workingHours' =>

                        $attendance->working_hours,

                    'punchInImage' =>

                        $attendance->punch_in_image

                        ? asset(
                            'uploads/attendance/' .
                            $attendance->punch_in_image
                        )

                        : '',

                    'punchOutImage' =>

                        $attendance->punch_out_image

                        ? asset(
                            'uploads/attendance/' .
                            $attendance->punch_out_image
                        )

                        : ''

                ]

            ];
        }

        return response()->json($events);
    }

    /**
     * Attendance Summary
     */
    public function summary(Request $request)
    {
        $attendances = Attendance::where(
            'user_id',
            auth()->id()
        )

        ->whereBetween(

            'attendance_date',

            [
                $request->start,
                $request->end
            ]

        )

        ->get();

        /*
        |--------------------------------------------------------------------------
        | Present Days
        |--------------------------------------------------------------------------
        */

        $presentDays = $attendances
            ->where('status', 'Present')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Total Hours
        |--------------------------------------------------------------------------
        */

        $totalHours = round(

            $attendances->sum('working_hours'),

            2

        );

        /*
        |--------------------------------------------------------------------------
        | Average Hours
        |--------------------------------------------------------------------------
        */

        $avgHours = $presentDays > 0

            ? round(
                $totalHours / $presentDays,
                2
            )

            : 0;

        /*
        |--------------------------------------------------------------------------
        | Current Month Name
        |--------------------------------------------------------------------------
        */

        $month = date(
            'F',
            strtotime($request->start)
        );

        return response()->json([

            'presentDays' => $presentDays,

            'totalHours' => $totalHours,

            'avgHours' => $avgHours,

            'month' => $month

        ]);
    }
}