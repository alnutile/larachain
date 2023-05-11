<?php

namespace App\Http\Controllers\ResponeTypes;

use App\Models\Outbound;
use App\Models\ResponseType;
use App\ResponseType\ResponseTypeEnum;

class EmbedQuestionResponseTypeController extends BaseResponseTypeController
{
    //
    public function create(Outbound $outbound)
    {
        ResponseType::create([
            'type' => ResponseTypeEnum::EmbedQuestion,
            'order' => $outbound->response_types->count() + 1,
            'outbound_id' => $outbound->id,
            'prompt_token' => [],

        ]);

        request()->session()->flash('flash.banner', 'Response Type created, this one has no settings 👉');

        return back();
    }

    public function store(Outbound $outbound)
    {
        // TODO: Implement store() method.
    }

    public function update(Outbound $outbound, ResponseType $response_type)
    {
        // TODO: Implement update() method.
    }
}
