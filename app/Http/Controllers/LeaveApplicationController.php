<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\LeaveType;
use App\Models\LeavePolicy;
use App\Models\LeaveApplication;

class LeaveApplicationController extends Controller
{
    /**
     * My Leaves
     */
    public function index()
    {
        $leaves = LeaveApplication::with(

            'leaveType',
            'approver'

        )

        ->where(
            'user_id',
            auth()->id()
        )

        ->latest()

        ->get();

        /*
|--------------------------------------------------------------------------
| Leave Summary
|--------------------------------------------------------------------------
*/

        $leaveSummary = LeavePolicy::with('leaveType')

        ->where('role_id', auth()->user()->role_id)

        ->where(

            'employment_type',

            now()->diffInMonths(
                auth()->user()->joining_date
            ) < auth()->user()->probation_period

            ? 'Probation'

            : 'Permanent'
        )

        ->where('status', 'Active')

        ->get()

        ->map(function ($policy) {

            $used = LeaveApplication::where(

                'user_id',
                auth()->id()

            )

            ->where(
                'leave_type_id',
                $policy->leave_type_id
            )

            ->where(
                'status',
                'Approved'
            )

            ->where(
                'is_paid',
                'Paid'
            )

            ->whereMonth(
                'from_date',
                now()->month
            )

            ->whereYear(
                'from_date',
                now()->year
            )

            ->sum('total_days');

            return [

                'leave_type' =>

                    $policy->leaveType->name ?? '-',

                'allowed' =>

                    $policy->allowed_leaves,

                'used' =>

                    $used,

                'pending' =>

                    max(
                        0,
                        $policy->allowed_leaves - $used
                    )

            ];
        });

        return view(

            'leave-applications.index',

            compact(

                'leaves',

                'leaveSummary'

            )

        );  
    }

    /**
     * Create Page
     */
    public function create()
    {
        $leaveTypes = LeaveType::where(
            'status',
            'Active'
        )->get();

        return view(

            'leave-applications.create',

            compact('leaveTypes')

        );
    }

    /**
     * Store Leave
     */
    public function store(Request $request)
    {
        $request->validate([

            'leave_type_id' =>

                'required|exists:leave_types,id',

            'from_date' =>

                'required|date',

            'to_date' =>

                'required|date|after_or_equal:from_date',

            'reason' =>

                'required|string|min:5'

        ]);

        $user = auth()->user();

        /*
        |--------------------------------------------------------------------------
        | Dates
        |--------------------------------------------------------------------------
        */

        $from = Carbon::parse(
            $request->from_date
        );

        $to = Carbon::parse(
            $request->to_date
        );

        /*
        |--------------------------------------------------------------------------
        | Total Days
        |--------------------------------------------------------------------------
        */

        $totalDays =

            $from->diffInDays($to) + 1;

        /*
        |--------------------------------------------------------------------------
        | Employment Type
        |--------------------------------------------------------------------------
        */

        $joiningDate = Carbon::parse(
            $user->joining_date
        );

        $monthsCompleted =

            $joiningDate
                ->diffInMonths(now());

        $employmentType =

            $monthsCompleted <
            $user->probation_period

            ? 'Probation'

            : 'Permanent';

        /*
        |--------------------------------------------------------------------------
        | Leave Policy
        |--------------------------------------------------------------------------
        */

        $policy = LeavePolicy::where(

            'role_id',
            $user->role_id

        )

        ->where(

            'leave_type_id',
            $request->leave_type_id

        )

        ->where(

            'employment_type',
            $employmentType

        )

        ->where(

            'status',
            'Active'

        )

        ->first();

        /*
        |--------------------------------------------------------------------------
        | Allowed Leaves
        |--------------------------------------------------------------------------
        */

        $allowedLeaves =
            $policy->allowed_leaves ?? 0;

        /*
        |--------------------------------------------------------------------------
        | Current Month Leaves
        |--------------------------------------------------------------------------
        */

        $usedLeaves = LeaveApplication::where(

            'user_id',
            $user->id

        )

        ->where(

            'leave_type_id',
            $request->leave_type_id

        )

        ->where(

            'status',
            'Approved'

        )

        ->where(

            'is_paid',
            'Paid'

        )

        ->whereMonth(
            'from_date',
            now()->month
        )

        ->whereYear(
            'from_date',
            now()->year
        )

        ->sum('total_days');

        /*
        |--------------------------------------------------------------------------
        | Paid / Unpaid Logic
        |--------------------------------------------------------------------------
        */

        $leaveNature = 'Paid';

        if(

            ($usedLeaves + $totalDays)
            > $allowedLeaves

        ) {

            $leaveNature = 'Unpaid';
        }

        /*
        |--------------------------------------------------------------------------
        | Apply Leave
        |--------------------------------------------------------------------------
        */

        LeaveApplication::create([

            'user_id' =>
                auth()->id(),

            'leave_type_id' =>
                $request->leave_type_id,

            'from_date' =>
                $request->from_date,

            'to_date' =>
                $request->to_date,

            'total_days' =>
                $totalDays,

            'reason' =>
                $request->reason,

            'is_paid' =>
                $leaveNature

        ]);

        return redirect()

            ->route(
                'leave-applications.index'
            )

            ->with(

                'success',

                'Leave applied successfully as '

                . $leaveNature .

                ' Leave'

            );
    }

    /**
     * Approvals
     */
    public function approvals()
    {
        $leaves = LeaveApplication::with(

            'user',
            'leaveType'

        )

        ->where(
            'status',
            'Pending'
        )

        ->latest()

        ->get();

        return view(

            'leave-applications.approvals',

            compact('leaves')

        );
    }

    /**
     * Approve
     */
    public function approve($id)
    {
        $leave = LeaveApplication::findOrFail($id);

        $leave->update([

            'status' => 'Approved',

            'approved_by' => auth()->id(),

            'approved_at' => now()

        ]);

        return back()->with(

            'success',

            'Leave approved successfully'

        );
    }

    /**
     * Reject
     */
    public function reject(Request $request, $id)
    {
        $leave = LeaveApplication::findOrFail($id);

        $leave->update([

            'status' => 'Rejected',

            'approved_by' => auth()->id(),

            'approved_at' => now(),

            'remarks' => $request->remarks

        ]);

        return back()->with(

            'success',

            'Leave rejected successfully'

        );
    }
}