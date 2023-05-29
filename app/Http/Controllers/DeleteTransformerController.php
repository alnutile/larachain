<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Source;
use App\Models\Transformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
