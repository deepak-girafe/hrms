<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display listing
     */
    public function index()
    {
        $roles = Role::latest()->get();

        return view('roles.index', compact('roles'));
    }

    /**
     * Create page
     */
    public function create()
    {
        return view('roles.create');
    }
    /**
     * Store role
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        Role::create([
            'name' => $request->name,
            'description' => $request->description,
            'reporting_required' => $request->reporting_required,
            'status' => $request->status,
        ]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role added successfully');
    }

    /**
     * Edit role
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update role
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id
        ]);

        $role->update([
            'name' => $request->name,
            'description' => $request->description,
            'reporting_required' => $request->reporting_required,
            'status' => $request->status
        ]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Chnage Status    
     */
    public function status(Role $role)
    {
        $role->update([

            'status' => $role->status == 'Active'
                ? 'Inactive'
                : 'Active'

        ]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role status updated successfully');
    }
}