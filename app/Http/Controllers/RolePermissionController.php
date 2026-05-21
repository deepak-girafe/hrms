<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Menu;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Roles listing
     */
    public function index()
    {
        $roles = Role::where('status', 'Active')
            ->latest()
            ->get();

        return view('role-permissions.index', compact('roles'));
    }

    /**
     * Edit permissions
     */
    public function edit(Role $role)
    {
        $menus = Menu::where('status', 'Active')
            ->orderBy('sort_order')
            ->get();

        $role->load('menus');

        return view('role-permissions.edit', compact(
            'role',
            'menus'
        ));
    }

    /**
     * Update permissions
     */
    public function update(Request $request, Role $role)
    {
        $role->menus()
            ->sync($request->menus ?? []);

        return redirect()
            ->route('role-permissions.index')
            ->with(
                'success',
                'Permissions updated successfully'
            );
    }
}