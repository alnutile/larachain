<?php

namespace App\Http\Controllers\Tranformers;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTransformerJob;
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
            'project_id' => $project->id
        ]);
        return to_route("projects.show", ['project' => $project->id]);
    }

    public function edit(Project $project, Transformer $transformer)
    {
        request()->session()->flash('flash.banner', 'You can sort the order by dragging and dropping');
        return to_route("projects.show", ['project' => $project->id]);
    }

    public function store(Project $project)
    {
        // Empty method
    }

    public function update(Project $project, Transformer $transformer)
    {
        // Empty method
    }

    public function run(Project $project, Transformer $transformer)
    {
        ProcessTransformerJob::dispatch($transformer);

        request()->session()->flash('flash.banner', 'Transformer running hold tight 🏃');

        return to_route('projects.show', [
            'project' => $project->id,
        ]);
    }

}
