<?php

namespace App\Http\Controllers;

use App\Models\Transformer;

class DeleteTransformerController extends Controller
{
    public function delete(Transformer $transformer)
    {
        $projectId = $transformer->project_id;

        $transformer->delete();

        request()->session()->flash('flash.banner', 'Transformer deleted...');

        return to_route('projects.show', [
            'project' => $projectId,
        ]);
    }
}
