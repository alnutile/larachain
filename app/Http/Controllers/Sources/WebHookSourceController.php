<?php

namespace App\Http\Controllers\Sources;

use App\Models\Project;
use App\Models\Source;
use App\Source\SourceEnum;

class WebHookSourceController extends BaseSourceController
{
    public function create(Project $project)
    {
        return inertia('Sources/WebHook/Create', [
            'details' => config('larachain.sources.web_hook'),
            'project' => $project,
            'source' => [
                'meta_data' => [],
            ],
        ]);
    }

    public function edit(Project $project, Source $source)
    {
        return inertia('Sources/WebHook/Edit', [
            'details' => config('larachain.sources.web_hook'),
            'project' => $project,
            'source' => $source,
        ]);
    }

    public function store(Project $project)
    {
        $validated = request()->validate([
            'name' => ['required'],
            'description' => ['nullable'],
            'meta_data' => ['nullable'],
        ]);

        Source::create([
            'project_id' => $project->id,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => SourceEnum::WebHook,
            'order' => 1,
            'meta_data' => data_get($validated, 'meta_data'),
        ]);

        request()->session()->flash('flash.banner', 'Source Created 🤘');

        return to_route('projects.show', [
            'project' => $project->id,
        ]);
    }

    public function update(Project $project, Source $source)
    {
        $validated = request()->validate([
            'meta_data' => ['nullable'],
            'name' => ['required'],
            'description' => ['nullable'],
        ]);

        $validated['project_id'] = $project->id;

        $source->update([
            'project_id' => $validated['project_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => SourceEnum::WebHook,
            'order' => 1,
            'meta_data' => data_get($validated, 'meta_data'),
        ]);

        request()->session()->flash('flash.banner', 'Source Updated ✅');

        return to_route('projects.show', [
            'project' => $project->id,
        ]);
    }

    public function webhook(Project $project, Source $source) {
        /**
         * @TODO
         * Security
         * Allow to dump into queue
         * Allow to return any response
         */
        $payload = request()->all();
        logger("Webhook coming in", $payload);
        /**
         * Do something with the incoming data
         */
        $response = $source->run($payload);

        return response()->json("OK", 200);
    }
}
