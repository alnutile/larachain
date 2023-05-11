<?php

namespace App\Http\Controllers\Outbounds;

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
        $responseTypes = config('larachain.response_types');

        $responseTypes = collect($responseTypes)->filter(
            function ($item, $response_type) {
                return $item['active'];
            }
        )->map(function ($item, $response_type) use ($outbound) {
            if (data_get($item, 'route')) {
                $item['route'] = route('response_types.'.$response_type.'.create', [
                    'outbound' => $outbound->id,
                ]);
            }

            return $item;
        })->toArray();

        return inertia('Outbounds/ChatUi/Show', [
            'details' => config('larachain.outbounds.chat_ui'),
            'project' => $project,
            'outbound' => $outbound->load('response_types'),
            'response_types' => $responseTypes,
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
