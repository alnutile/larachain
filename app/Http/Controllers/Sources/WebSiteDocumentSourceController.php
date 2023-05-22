<?php

namespace App\Http\Controllers\Sources;

use App\Models\Project;
use App\Models\Source;
use App\Source\SourceTypeEnum;

class WebSiteDocumentSourceController extends BaseSourceController
{
    public function create(Project $project)
    {
        return inertia('Sources/WebSiteDocument/Create', [
            'details' => config('larachain.sources.web_site_document'),
            'project' => $project,
            'source' => [
                'meta_data' => [
                    'url' => 'https://foo.com/some.pdf',
                ],
            ],
        ]);
    }

    public function edit(Project $project, Source $source)
    {
        return inertia('Sources/WebSiteDocument/Edit', [
            'details' => config('larachain.sources.web_site_document'),
            'project' => $project,
            'source' => $source,
        ]);
    }

    public function store(Project $project)
    {
        $validated = request()->validate([
            'meta_data.url' => ['required', 'url'],
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        Source::create([
            'project_id' => $project->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => SourceTypeEnum::WebSiteDocument,
            'order' => 1,
            'meta_data' => $validated['meta_data'],
        ]);

        request()->session()->flash('flash.banner', 'Source Created 🤘');

        return to_route('projects.show', [
            'project' => $project->id,
        ]);
    }

    public function update(Project $project, Source $source)
    {
        $validated = request()->validate([
            'meta_data.url' => ['required', 'url'],
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        $validated['project_id'] = $project->id;

        $source->update([
            'project_id' => $validated['project_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => SourceTypeEnum::WebSiteDocument,
            'order' => 1,
            'meta_data' => $validated['meta_data'],
        ]);

        request()->session()->flash('flash.banner', 'Source Updated ✅');

        return to_route('projects.show', [
            'project' => $project->id,
        ]);
    }
}
