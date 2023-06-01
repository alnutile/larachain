<?php

namespace App\Http\Controllers\Outbounds;

use App\Models\Outbound;
use App\Models\Project;
use App\Outbound\OutboundEnum;
use App\ResponseType\ResponseTypeEnum;

class ChatGptRetrievalOutboundController extends BaseOutboundController
{
    public function create(Project $project)
    {
        $outbound = Outbound::create([
            'type' => OutboundEnum::ChatGptRetrieval,
            'active' => 1,
            'project_id' => $project->id,
        ]);

        request()->session()->flash('flash.banner', 'Created Outbound! Now to add Response Types');

        return to_route('outbounds.chat_gpt_retrieval.show',
            [
                'project' => $project->id,
                'outbound' => $outbound->id,
            ]);
    }

    public function show(Project $project, Outbound $outbound)
    {
        return inertia('Outbounds/ChatGptRetrieval/Show', [
            'details' => config('larachain.outbounds.chat_gpt_retrieval'),
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
