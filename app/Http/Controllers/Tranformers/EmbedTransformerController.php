<?php

namespace App\Http\Controllers\Tranformers;

use App\Models\Project;
use App\Models\Transformer;
use App\Transformers\TransformerTypeEnum;

class EmbedTransformerController extends BaseTransformerController
{
    public function create(Project $project)
    {
        Transformer::create([
            'type' => TransformerTypeEnum::EmbedTransformer,
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
