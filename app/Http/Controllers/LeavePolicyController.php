<?php

namespace App\Http\Controllers;

use App\Models\LeavePolicy;
use App\Models\LeaveType;
use App\Models\Role;
use Illuminate\Http\Request;

class LeavePolicyController extends Controller
{
    public function index()
    {
        $leavePolicies = LeavePolicy::with([
                'role',
                'leaveType'
            ])
            ->latest()
            ->get();

        return view('leave-policies.index', compact('leavePolicies'));
    }

    public function create()
    {
        $roles = Role::where('status', 'Active')->get();

        $leaveTypes = LeaveType::where('status', 'Active')->get();

        return view('leave-policies.create', compact(
            'roles',
            'leaveTypes'
        ));
    }

    public function store(Request $request)
    {
        LeavePolicy::create($request->all());

        return redirect()
            ->route('leave-policies.index')
            ->with('success', 'Leave policy created successfully');
    }

    public function edit(LeavePolicy $leavePolicy)
    {
        $roles = Role::where('status', 'Active')->get();

        $leaveTypes = LeaveType::where('status', 'Active')->get();

        return view('leave-policies.edit', compact(
            'leavePolicy',
            'roles',
            'leaveTypes'
        ));
    }

    public function update(Request $request, LeavePolicy $leavePolicy)
    {
        $leavePolicy->update($request->all());

        return redirect()
            ->route('leave-policies.index')
            ->with('success', 'Leave policy updated successfully');
    }

    public function status(LeavePolicy $leavePolicy)
    {
        $leavePolicy->update([

            'status' => $leavePolicy->status == 'Active'
                ? 'Inactive'
                : 'Active'

        ]);

        return redirect()
            ->back()
            ->with('success', 'Status updated');
    }
}