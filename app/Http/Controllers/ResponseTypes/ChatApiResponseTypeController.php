<?php

namespace App\Http\Controllers\ResponseTypes;

use App\Data\Filters;
use App\Models\Outbound;
use App\Models\ResponseType;
use App\ResponseType\ResponseTypeEnum;

class ChatApiResponseTypeController extends ChatUiResponseTypeController
{
    public function create(Outbound $outbound)
    {
        $template = <<<'EOL'
As a helpful historian, I have been asked the question below. I will provide some context found in a local historical art
collection database using a vector query. Please help me reply with a well-formatted answer and offer to get more information
if needed.
Context: {context}
\n
\n
###
\n
\n
EOL;

        $response = ResponseType::create([
            'type' => ResponseTypeEnum::ChatApi,
            'order' => $outbound->response_types->count() + 1,
            'outbound_id' => $outbound->id,
            'prompt_token' => [
                'system' => $template,
            ],
        ]);

        request()->session()->flash('flash.banner', 'Response Type created, update settings 👉');

        return to_route('response_types.chatapi.edit', [
            'outbound' => $outbound->id,
            'response_type' => $response->id,
        ]);
    }

    public function edit(Outbound $outbound, ResponseType $response_type)
    {
        return inertia('ResponseTypes/ChatApi/Show', [
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
            'filters' => ['nullable'],
        ]);

        try {

            $response = $outbound->run(
                auth()->user(),
                $validated['question'],
                Filters::from(data_get($validated, 'filters', []))
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
