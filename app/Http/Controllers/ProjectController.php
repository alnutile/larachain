<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    public function index()
    {
        return Inertia::render('Projects/Index', [
            'projects' => Project::query()
                ->where('team_id',
                auth()->user()->current_team_id)
                ->orderBy('updated_at', 'DESC')
                ->simplePaginate(10)
                ->withQueryString(),
        ]);
    }

    public function create()
    {
        return Inertia::render('Projects/Create', [
            'project' => new Project(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = request()->validate(
            [
                'name' => 'required',
                'active' => 'nullable',
            ]
        );

        $validated['team_id'] = auth()->user()->current_team_id;

        $model = Project::create($validated);

        return redirect()->route('projects.edit', ['project' => $model->id]);
    }

    public function show(Project $project)
    {
    return Inertia::render('Projects/Show', [
        'project' => $project,
    ]);
}

    public function edit(Project $project)
    {
        if (request()->user()->cannot('edit', $project)) {
            abort(403);
        }

        return Inertia::render('Projects/Edit', [
            'project' => $project,
        ]);
    }

    public function update(Request $request, Project $project)
    {
        if ($request->user()->cannot('update', $project)) {
            abort(403);
        }

        $validated = request()->validate(
            [
                'name' => 'required',
                'active' => 'nullable',
                'team_id' => 'required',
            ]
        );

        $project->update($validated);

        return redirect()->route('projects.edit', ['project' => $project->id]);
    }

    public function destroy($id)
    {
        //
    }
}
