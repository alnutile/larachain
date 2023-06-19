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
                ],
            ],
        ]);

        request()->session()->flash('flash.banner', 'Created, you can sort the order using drag and drop');

        return to_route('transformers.json_transformer.edit',
            [
                'project' => $project->id,
                'transformer' => $transformer->id,
            ]
        );
    }

    public function edit(Project $project, Transformer $transformer)
    {
        return inertia('Transformers/JsonTransformer/Edit', [
            'details' => config('larachain.transformers.'.$transformer->type->value),
            'transformer' => $transformer,
        ]);
    }

    public function store(Project $project)
    {
        // TODO: Implement store() method.
    }

    public function update(Project $project, Transformer $transformer)
    {
        $validate = request()->validate([
            'mappings' => ['nullable'],
        ]);

        $meta_data = $transformer->meta_data;
        $meta_data['mappings'] = data_get($validate, 'mappings', []);
        $transformer->meta_data = $meta_data;
        $transformer->save();

        return to_route('projects.show', [
            'project' => $project->id,
        ]);
    }
}
