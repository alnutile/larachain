<?php

namespace App\Http\Controllers\ResponeTypes;

use App\Http\Controllers\Controller;
use App\Models\Outbound;
use App\Models\ResponseType;
use App\ResponseType\ResponseTypeEnum;

class ChatUiResponseTypeController extends BaseResponseTypeController
{
    //
    public function create(Outbound $outbound)
    {
        ResponseType::create([
            'type' => ResponseTypeEnum::ChatUi,
            'order' => $outbound->response_types->count() + 1,
            'outbound_id' => $outbound->id,
            'prompt_token' => [
                'system' => [
                    "Example:"
                ]
            ],

        ]);

        request()->session()->flash('flash.banner', 'Response Type created, this one has no settings 👉');

        return back();
    }

    public function show(Outbound $outbound)
    {
        // TODO: Implement show() method.
    }

    public function edit(Outbound $outbound, ResponseType $response_type)
    {
        // TODO: Implement edit() method.
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
