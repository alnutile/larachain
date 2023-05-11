<?php

namespace App\Http\Controllers\Outbounds;

use App\Models\Outbound;
use App\Models\Project;
use App\Outbound\OutboundEnum;

class ApiiOutboundController extends BaseOutboundController
{
    public function create(Project $project)
    {
        Outbound::create([
            'type' => OutboundEnum::Api,
            'active' => 1,
            'project_id' => $project->id,
        ]);

        request()->session()->flash('flash.banner', 'Created API Outbound now to add Response Types Transformers');

        return to_route('projects.show', ['project' => $project->id]);
    }

    public function show(Project $project, Outbound $outbound)
    {
        // TODO: Implement show() method.
    }

    public function edit(Project $project, Outbound $outbound)
    {
        // TODO: Implement edit() method.
    }

    public function store(Project $project)
    {
        // TODO: Implement store() method.
    }

    public function update(Project $project, Outbound $outbound)
    {
        // TODO: Implement update() method.
    }
}
