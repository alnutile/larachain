<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class SortingController extends Controller
{
    public function __invoke(Project $project) {
        if (request()->user()->cannot('update', $project)) {
            abort(403);
        }

        $validated = request()->validate([
            'items' => ['required', 'array'],
            'model' => ['required', 'string']
        ]);

        foreach($validated['items'] as $item) {
            $model = $validated['model']::find($item['id']);
            $model->order = $item['order'];
            $model->save();
        }

        return response()->json([], 200);
    }
}
