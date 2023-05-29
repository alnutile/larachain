<?php

namespace App\Http\Controllers;

use App\Models\ResponseType;

class DeleteResponseTypesController extends Controller
{
    public function delete(ResponseType $responseType)
    {
        $outbound = $responseType->outbound;

        $responseType->delete();

        request()->session()->flash('flash.banner', 'ResponseType deleted...');

        return to_route('outbounds.'.$outbound->type->value.'.show', [
            'outbound' => $outbound->id,
            'project' => $outbound->project_id,
        ]);
    }
}
