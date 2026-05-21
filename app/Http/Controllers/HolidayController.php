<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Holiday list
     */
    public function index()
    {
        $holidays = Holiday::latest()->get();

        return view('holidays.index', compact('holidays'));
    }

    /**
     * Create page
     */
    public function create()
    {
        return view('holidays.create');
    }

    /**
     * Store holiday
     */
    public function store(Request $request)
    {
        $request->validate([

            'title' => 'required',
            'holiday_date' => 'required'

        ]);

        Holiday::create($request->all());

        return redirect()
            ->route('holidays.index')
            ->with('success', 'Holiday added successfully');
    }

    /**
     * Edit page
     */
    public function edit(Holiday $holiday)
    {
        return view('holidays.edit', compact('holiday'));
    }

    /**
     * Update holiday
     */
    public function update(Request $request, Holiday $holiday)
    {
        $request->validate([

            'title' => 'required',
            'holiday_date' => 'required'

        ]);

        $holiday->update($request->all());

        return redirect()
            ->route('holidays.index')
            ->with('success', 'Holiday updated successfully');
    }

    /**
     * Toggle status
     */
    public function status(Holiday $holiday)
    {
        $holiday->update([

            'status' => $holiday->status == 'Active'
                ? 'Inactive'
                : 'Active'

        ]);

        return redirect()
            ->route('holidays.index')
            ->with('success', 'Holiday status updated');
    }
}