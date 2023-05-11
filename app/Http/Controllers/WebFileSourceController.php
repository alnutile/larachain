<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Source;
use App\Source\SourceTypeEnum;

class WebFileSourceController extends Controller
{
    public function create(Project $project)
    {
        return inertia('Sources/WebFile/Create', [
            'details' => config('larachain.sources.web_file'),
            'project' => $project,
        ]);
    }

    public function edit(Project $project, Source $source)
    {
        return inertia('Sources/WebFile/Edit', [
            'details' => config('larachain.sources.web_file'),
            'project' => $project,
            'source' => $source,
        ]);
    }

    public function store(Project $project)
    {
        $validated = request()->validate([
            'url' => ['required', 'url'],
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        Source::create([
            'project_id' => $project->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => SourceTypeEnum::WebFile,
            'order' => 1,
            'meta_data' => [
                'url' => $validated['url'],
            ],
        ]);

        request()->session()->flash('flash.banner', 'Source Created 🤘');

        return to_route('projects.show', [
            'project' => $project->id,
        ]);
    }
}
