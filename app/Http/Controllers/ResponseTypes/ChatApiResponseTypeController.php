<?php

namespace App\Http\Controllers\ResponseTypes;

use App\Models\Outbound;
use App\Models\Project;
use App\Models\ResponseType;
use App\ResponseType\ResponseTypeEnum;

class ChatApiResponseTypeController extends ChatUiResponseTypeController
{
    public function create(Outbound $outbound)
    {
        $response = ResponseType::create([
            'type' => ResponseTypeEnum::ChatApi,
            'order' => $outbound->response_types->count() + 1,
            'outbound_id' => $outbound->id,
            'prompt_token' => [],
            'meta_data' => [],
        ]);

        request()->session()->flash('flash.banner', 'Response Type created, update settings 👉');

        return to_route('response_types.chatapi.edit', [
            'outbound' => $outbound->id,
            'response_type' => $response->id,
        ]);
    }

    public function edit(Outbound $outbound, ResponseType $response_type)
    {
        return inertia('ResponseTypes/ChatApi/Edit', [
            'response_type' => $response_type,
            'outbound' => $outbound,
            'details' => config('larachain.response_types.chatapi'),
        ]);
    }

    public function api(
        Outbound $outbound,
        ResponseType $responseType
    ) {
        $validated = request()->validate([
            'question' => ['required', 'max:5000'],
        ]);

        try {
            $response = $outbound->runResponseType(
                $responseType,
                auth()->user(),
                $validated['question']
            );

            return response()->json([
                'data' => $response->message->content,
            ], 200);
        } catch (\Exception $e) {
            logger('Error with request', [$e->getMessage()]);

            return response()->json([], 500);
        }

    }
}
