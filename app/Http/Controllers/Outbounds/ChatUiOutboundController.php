<?php

namespace App\Http\Controllers\Outbounds;

use App\Models\Outbound;
use App\Models\Project;
use App\Outbound\OutboundEnum;
use App\ResponseType\ResponseTypeEnum;

class ChatUiOutboundController extends BaseOutboundController
{
    public function create(Project $project)
    {
        $outbound = Outbound::create([
            'type' => OutboundEnum::ChatUi,
            'active' => 1,
            'project_id' => $project->id,
        ]);

        request()->session()->flash('flash.banner', 'Created Outbound now to add Response Types Transformers');

        return to_route('outbounds.chat_ui.show',
            [
                'project' => $project->id,
                'outbound' => $outbound->id,
            ]);
    }

    public function show(Project $project, Outbound $outbound)
    {
        return inertia('Outbounds/ChatUi/Show', [
            'details' => config('larachain.outbounds.chat_ui'),
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
