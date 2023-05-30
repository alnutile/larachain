<?php

namespace App\Http\Controllers;

use App\Models\Outbound;

class CloneResponseTypesController extends Controller
{
    public function __invoke()
    {
        request()->validate([
            'from' => ['required'],
            'to' => ['required'],
        ]);

        $to = Outbound::findOrFail(request()->get('to'));
        $from = Outbound::findOrFail(request()->get('from'));

        foreach ($from->response_types as $responseType) {
            $new = $responseType->replicate();
            $new->outbound_id = $to->id;
            $new->save();
        }

        request()->session()->flash('flash.banner', 'Cloned 👯‍');

        return to_route('outbounds.'.$to->type->value.'.show', [
            'outbound' => $to->id,
            'project' => $to->project_id,
        ]);
    }
}
