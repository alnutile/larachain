<?php

namespace App\Http\Controllers\Transformers;

use App\Models\Project;
use App\Models\Transformer;
use App\Transformer\TransformerEnum;

class EmbedTransformerController extends BaseTransformerController
{
    public function create(Project $project)
    {
        Transformer::create([
            'type' => TransformerEnum::EmbedTransformer,
            'order' => $project->transformers->count() + 1,
            'project_id' => $project->id,
        ]);

        return to_route('projects.show', ['project' => $project->id]);
    }

    public function store(Project $project)
    {
        // Empty method
    }

    public function update(Project $project, Transformer $transformer)
    {
        // Empty method
    }
}
