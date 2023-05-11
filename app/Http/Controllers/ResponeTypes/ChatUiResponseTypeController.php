<?php

namespace App\Http\Controllers\ResponeTypes;

use App\Models\Outbound;
use App\Models\ResponseType;
use App\ResponseType\ResponseTypeEnum;

class ChatUiResponseTypeController extends BaseResponseTypeController
{
    public function create(Outbound $outbound)
    {
        $template = <<<'EOL'
As a helpful historian, I have been asked the question below. I will provide some context found in a local historical art
collection database using a vector query. Please help me reply with a well-formatted answer and offer to get more information
if needed.
Context: {context}
###


EOL;

        $responseType = ResponseType::create([
            'type' => ResponseTypeEnum::ChatUi,
            'order' => $outbound->response_types->count() + 1,
            'outbound_id' => $outbound->id,
            'prompt_token' => [
                'system' => $template,
            ],

        ]);

        request()->session()->flash('flash.banner', 'Response Type created, now to give it a Prompt 👉');

        return to_route('response_types.chat_ui.edit', [
            'response_type' => $responseType->id,
            'outbound' => $outbound->id,
        ]);
    }

    public function edit(Outbound $outbound, ResponseType $response_type)
    {
        return inertia('ResponseTypes/ChatUi/Show', [
            'response_type' => $response_type,
            'outbound' => $outbound,
            'details' => config('larachain.response_types.chat_ui'),
        ]);
    }

    public function store(Outbound $outbound)
    {
        // TODO: Implement store() method.
    }

    public function update(Outbound $outbound, ResponseType $response_type)
    {
        $validated = request()->validate([
            'prompt_text' => ['required', 'string'],
        ]);

        $prompt_token = $response_type->prompt_token;
        $prompt_token['system'] = $validated['prompt_text'];
        $response_type->prompt_token = $prompt_token;
        $response_type->save();

        request()->session()->flash('flash.banner', 'Prompt Updated 📀');

        return to_route('outbounds.'.$outbound->type->value.'.show', [
            'outbound' => $outbound->id,
            'project' => $outbound->project->id,
        ]
        );
    }
}
