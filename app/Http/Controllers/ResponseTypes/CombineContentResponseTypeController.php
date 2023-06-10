<?php

namespace App\Http\Controllers\ResponseTypes;

use App\Models\Outbound;
use App\Models\ResponseType;
use App\ResponseType\ResponseTypeEnum;

class CombineContentResponseTypeController extends BaseResponseTypeController
{
    //
    public function create(Outbound $outbound)
    {
        ResponseType::create([
            'type' => ResponseTypeEnum::CombineContent,
            'order' => $outbound->response_types->count() + 1,
            'outbound_id' => $outbound->id,
            'meta_data' => [
                'token_limit' => 1000,
            ],
            'prompt_token' => [],
        ]);

        request()->session()->flash('flash.banner', 'Response Type created, this one has no settings 👉');

        return back();
    }

    public function edit(Outbound $outbound, ResponseType $response_type)
    {
        return inertia('ResponseTypes/CombineContent/Edit', [
            'response_type' => $response_type,
            'outbound' => $outbound,
            'details' => config('larachain.response_types.combine_content'),
        ]);
    }

    public function update(Outbound $outbound, ResponseType $response_type)
    {
        $validated = request()->validate(
            [
                'meta_data.token_limit' => ['required'],
            ]
        );

        $response_type->meta_data = $validated['meta_data'];
        $response_type->save();

        request()->session()->flash('flash.banner', 'Updated 📀📀📀📀');

        return to_route('outbounds.'.$outbound->type->value.'.show', [
            'outbound' => $outbound->id,
            'project' => $outbound->project->id,
        ]);
    }

    public function store(Outbound $outbound)
    {
        // TODO: Implement store() method.
    }
}
