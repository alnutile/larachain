<?php

namespace App\Http\Controllers\Transformers;

use App\Models\Project;
use App\Models\Transformer;
use App\Transformer\TransformerEnum;

class JsonTransformerTransformerController extends BaseTransformerController
{
    public function create(Project $project)
    {
        $transformer = Transformer::create([
            'type' => TransformerEnum::JsonTransformer,
            'order' => $project->transformers->count() + 1,
            'project_id' => $project->id,
            'meta_data' => [
                'mappings' => [
                    'optional.path.to.store_one',
                    'optional.path.to.store_two',
                ]
            ]
        ]);

        request()->session()->flash('flash.banner', 'Created, you can sort the order using drag and drop');

        return to_route('transformers.json_transformer.edit',
            [
                'project' => $project->id,
                'transformer' => $transformer->id
            ]
        );
    }

    public function edit(Project $project, Transformer $transformer)
    {
        request()->session()->flash('flash.banner', 'There is no edit for this');

        return to_route('projects.show', ['project' => $project->id]);
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
