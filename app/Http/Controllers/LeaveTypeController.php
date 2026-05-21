<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{
    public function index()
    {
        $leaveTypes = LeaveType::latest()->get();

        return view('leave-types.index', compact('leaveTypes'));
    }

    public function create()
    {
        return view('leave-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required'

        ]);

        LeaveType::create($request->all());

        return redirect()
            ->route('leave-types.index')
            ->with('success', 'Leave type added successfully');
    }

    public function edit(LeaveType $leaveType)
    {
        return view('leave-types.edit', compact('leaveType'));
    }

    public function update(Request $request, LeaveType $leaveType)
    {
        $request->validate([

            'name' => 'required'

        ]);

        $leaveType->update($request->all());

        return redirect()
            ->route('leave-types.index')
            ->with('success', 'Leave type updated successfully');
    }

    public function status(LeaveType $leaveType)
    {
        $leaveType->update([

            'status' => $leaveType->status == 'Active'
                ? 'Inactive'
                : 'Active'

        ]);

        return redirect()
            ->back()
            ->with('success', 'Status updated');
    }
}