<?php

namespace App\Http\Controllers\Outbounds;

use App\Http\Controllers\Controller;
use App\Models\Outbound;
use App\Models\Project;
use App\Outbound\OutboundEnum;

class ChatUiOutboundController extends BaseOutboundController
{

    public function create(Project $project)
    {
        $outbound = Outbound::create([
            'type' => OutboundEnum::ChatUi,
            'active' => 1,
            'project_id' => $project->id
        ]);

        request()->session()->flash('flash.banner', 'Created Outbound now to add Response Types Transformers');

        return to_route('outbounds.chat_ui.show',
            [
                'project' => $project->id,
                "outbound" => $outbound->id
            ]);
    }

    public function show(Project $project, Outbound $outbound)
    {
        return inertia('Outbounds/ChatUi/Show', [
            'details' => config('larachain.outbounds.chat_ui'),
            'project' => $project,
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
