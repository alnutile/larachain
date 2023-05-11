<?php

namespace App\Http\Controllers\Tranformers;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTransformerJob;
use App\Models\Project;
use App\Models\Transformer;
use App\Transformers\TransformerTypeEnum;

class PdfTransformerController extends BaseTransformerController
{
    //
    public function create(Project $project)
    {
        Transformer::create([
            'type' => TransformerTypeEnum::PdfTransformer,
            'order' => $project->transformers->count() + 1,
            'project_id' => $project->id,
        ]);

        request()->session()->flash('flash.banner', 'Created, you can sort the order using drag and drop');

        return to_route('projects.show', ['project' => $project->id]);
    }

    public function edit(Project $project, Transformer $transformer)
    {
        // TODO: Implement edit() method.
    }

    public function store(Project $project)
    {
        // TODO: Implement store() method.
    }

    public function update(Project $project, Transformer $transformer)
    {
        // TODO: Implement update() method.
    }


}
