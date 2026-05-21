<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Project list
     */
    public function index()
    {
        $projects = Project::with('users')
            ->latest()
            ->get();

        return view('projects.index', compact('projects'));
    }

    /**
     * Create page
     */
    public function create()
    {
        $users = User::where('status', 'Active')
            ->get();

        return view('projects.create', compact('users'));
    }

    /**
     * Store project
     */
    public function store(Request $request)
    {
        $request->validate([

            'project_name' => 'required'

        ]);

        $project = Project::create([

            'project_name' => $request->project_name,

            'project_code' => $request->project_code,

            'start_date' => $request->start_date,

            'end_date' => $request->end_date,

            'project_cost' => $request->project_cost,

            'priority' => $request->priority,

            'status' => $request->status,

            'description' => $request->description

        ]);

        $project->users()
            ->sync($request->team_members ?? []);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project created successfully');
    }

    /**
     * Edit page
     */
    public function edit(Project $project)
    {
        $users = User::where('status', 'Active')
            ->get();

        $project->load('users');

        return view('projects.edit', compact(
            'project',
            'users'
        ));
    }

    /**
     * Update project
     */
    public function update(Request $request, Project $project)
    {
        $project->update([

            'project_name' => $request->project_name,

            'project_code' => $request->project_code,

            'start_date' => $request->start_date,

            'end_date' => $request->end_date,

            'project_cost' => $request->project_cost,

            'priority' => $request->priority,

            'status' => $request->status,

            'description' => $request->description

        ]);

        $project->users()
            ->sync($request->team_members ?? []);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project updated successfully');
    }
}