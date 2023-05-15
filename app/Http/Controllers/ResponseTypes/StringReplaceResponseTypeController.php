<?php

namespace App\Http\Controllers\ResponseTypes;

use App\Models\Outbound;
use App\Models\ResponseType;
use App\ResponseType\ResponseTypeEnum;

class StringReplaceResponseTypeController extends BaseResponseTypeController
{
    public function create(Outbound $outbound)
    {
        $responseType = ResponseType::create([
            'type' => ResponseTypeEnum::StringReplace,
            'order' => $outbound->response_types->count() + 1,
            'outbound_id' => $outbound->id,
            'prompt_token' => [],
            'meta_data' => [
                'search' => [],
                'replace' => [],
            ],
        ]);

        request()->session()->flash('flash.banner', 'Response Type created, now to add Search and Replace 💪');

        return to_route('response_types.string_replace.edit', [
            'outbound' => $outbound->id,
            'response_type' => $responseType->id,
        ]);
    }

    public function edit(Outbound $outbound, ResponseType $response_type)
    {
        return inertia('ResponseTypes/StringReplace/Edit', [
            'response_type' => $response_type,
            'outbound' => $outbound,
            'details' => config('larachain.response_types.string_replace'),
        ]);
    }

    public function update(Outbound $outbound, ResponseType $response_type)
    {
        $validated = request()->validate(
            [
                'meta_data.search' => ['required'],
                'meta_data.replace' => ['required'],
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
