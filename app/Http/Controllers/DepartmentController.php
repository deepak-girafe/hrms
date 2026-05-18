<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Department list
     */
    public function index()
    {
        $departments = Department::latest()->get();

        return view('departments.index', compact('departments'));
    }

    /**
     * Create page
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store department
     */
    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required|unique:departments,name'

        ]);

        Department::create([

            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status

        ]);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department added successfully');
    }

    /**
     * Edit page
     */
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update department
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([

            'name' => 'required|unique:departments,name,' . $department->id

        ]);

        $department->update([

            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status

        ]);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department updated successfully');
    }

    /**
     * Status update
     */
    public function status(Department $department)
    {
        $department->update([

            'status' => $department->status == 'Active'
                ? 'Inactive'
                : 'Active'

        ]);

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department status updated successfully');
    }
}