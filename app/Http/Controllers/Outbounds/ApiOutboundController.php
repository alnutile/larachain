<?php

namespace App\Http\Controllers\Outbounds;

use App\Models\Outbound;
use App\Models\Project;
use App\Outbound\OutboundEnum;
use App\ResponseType\ResponseTypeEnum;

class ApiOutboundController extends BaseOutboundController
{
    public function create(Project $project)
    {
        $outbound = Outbound::create([
            'type' => OutboundEnum::Api,
            'active' => 1,
            'project_id' => $project->id,
            'meta_data' => []
        ]);

        request()->session()->flash('flash.banner', 'Created Outbound now to add Response Types');

        return to_route('outbounds.api.show',
            [
                'project' => $project->id,
                'outbound' => $outbound->id,
            ]);
    }

    public function show(Project $project, Outbound $outbound)
    {
        return inertia('Outbounds/Api/Show', [
            'details' => config('larachain.outbounds.api'),
            'project' => $project,
            'outbound' => $outbound->load('response_types'),
            'response_types' => ResponseTypeEnum::toArray('response_types'),
        ]);
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
