<?php

namespace App\Http\Controllers\Sources;

use App\Models\Project;
use App\Models\Source;
use App\Source\SourceEnum;

class FileUploadSourceSourceController extends BaseSourceController
{
    public function create(Project $project)
    {
        return inertia('Sources/FileUploadSource/Create', [
            'details' => config('larachain.sources.file_upload_source'),
            'project' => $project,
            'source' => [],
        ]);
    }

    public function edit(Project $project, Source $source)
    {
        return inertia('Sources/FileUploadSource/Edit', [
            'details' => config('larachain.sources.file_upload_source'),
            'project' => $project,
            'source' => $source,
        ]);
    }

    public function store(Project $project)
    {
        $validated = request()->validate([
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        $fileName = request()->file('file')->getClientOriginalName();

        $source = Source::create([
            'project_id' => $project->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'meta_data' => [
                'file_name' => $fileName,
            ],
            'type' => SourceEnum::FileUploadSource,
            'order' => 1,
        ]);

        $path = $this->getPath($source, $fileName);

        request()->file('file')->store($path, 'projects');

        request()->session()->flash('flash.banner', 'Source Created 🤘');

        return to_route('projects.show', [
            'project' => $project->id,
        ]);
    }

    public function update(Project $project, Source $source)
    {
        $validated = request()->validate([
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        $fileName = request()->file('file')->getClientOriginalName();

        $validated['project_id'] = $project->id;

        $source->update([
            'project_id' => $validated['project_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => SourceEnum::FileUploadSource,
            'order' => 1,
            'meta_data' => [
                'file_name' => $fileName,
            ],
        ]);

        $path = $this->getPath($source, $fileName);

        request()->file('file')->store($path, 'projects');

        request()->session()->flash('flash.banner', 'Source Updated ✅');

        return to_route('projects.show', [
            'project' => $project->id,
        ]);
    }
}
