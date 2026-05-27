<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\DailyEod;
use Illuminate\Http\Request;
use App\Models\DailyEodItem;
use Illuminate\Support\Facades\Auth;

class DailyEodController extends Controller
{
    /**
     * EOD Listing
     */
   public function index()
    {
        $user = auth()->user();

        $roleName = strtolower(

            optional($user->role)->name ?? ''

        );

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

            $eods = DailyEod::with([

                    'user',

                    'items',

                    'items.project'

                ])

                ->latest()

                ->paginate(10);
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

            /*
            |--------------------------------------------------------------------------
            | Reporting Employees + Self
            |--------------------------------------------------------------------------
            */

            $reportingUserIds = \DB::table(

                    'user_reporting'

                )

                ->where(

                    'reporting_user_id',

                    $user->id

                )

                ->pluck(

                    'user_id'

                )

                ->push($user->id);

            $eods = DailyEod::with([

                    'user',

                    'items',

                    'items.project'

                ])

                ->whereIn(

                    'user_id',

                    $reportingUserIds

                )

                ->latest()

                ->paginate(10);
        }

        /*
        |--------------------------------------------------------------------------
        | EMPLOYEE
        |--------------------------------------------------------------------------
        */

        else {

            $eods = DailyEod::with([

                    'user',

                    'items',

                    'items.project'

                ])

                ->where(

                    'user_id',

                    $user->id

                )

                ->latest()

                ->paginate(10);
        }

        return view(

            'daily-eod.index',

            compact('eods')

        );
    }

    /**
     * Create EOD
     */
    public function create()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Admin Cannot Submit
        |--------------------------------------------------------------------------
        */

        if(

            strtolower($user->role->name)

            == 'admin'

        ) {

            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Assigned Projects
        |--------------------------------------------------------------------------
        */

        $projects = Project::whereHas(

            'users',

            function($q) use ($user){

                $q->where(

                    'users.id',

                    $user->id

                );
            }

        )->get();

        return view(

            'daily-eod.create',

            compact('projects')

        );
    }

    /**
     * Store EOD
     */
    public function store(Request $request)
    {
        $request->validate([

            'project_id.*' => 'required',

            'work_done.*' => 'required|min:5'

        ]);

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate
        |--------------------------------------------------------------------------
        */

        $exists = DailyEod::where(

            'user_id',

            Auth::id()

        )

        ->whereDate(

            'eod_date',

            today()

        )

        ->exists();

        if($exists) {

            return back()->with(

                'error',

                'Today EOD already submitted'

            );
        }

        /*
        |--------------------------------------------------------------------------
        | Main EOD
        |--------------------------------------------------------------------------
        */

        $eod = DailyEod::create([

            'user_id' => Auth::id(),

            'eod_date' => today(),

            'status' => 'Submitted'

        ]);

        /*
        |--------------------------------------------------------------------------
        | Multiple Project Updates
        |--------------------------------------------------------------------------
        */

        foreach($request->project_id as $key => $projectId) {

            DailyEodItem::create([

                'daily_eod_id' => $eod->id,

                'project_id' => $projectId,

                'work_done' =>

                    $request->work_done[$key],

                'blockers' =>

                    $request->blockers[$key] ?? null,

                'tomorrow_plan' =>

                    $request->tomorrow_plan[$key] ?? null

            ]);
        }

        return redirect()

            ->route('daily-eod.index')

            ->with(

                'success',

                'Daily EOD submitted successfully'

            );
    }

    /**
     * View EOD
     */
    public function show($id)
    {
        $eod = DailyEod::with([

                'user',
                'items.project'

            ])

            ->findOrFail($id);

        return view(

            'daily-eod.show',

            compact('eod')

        );
    }

    /**
     * Mark Reviewed
     */
    public function review($id)
    {
        $eod = DailyEod::findOrFail($id);

        $eod->update([

            'status' => 'Reviewed'

        ]);

        return back()->with(

            'success',

            'EOD marked as reviewed'

        );
    }
}