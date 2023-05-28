<?php

namespace App\Http\Controllers\Transformers;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTransformerJob;
use App\Models\Project;
use App\Models\Transformer;

abstract class BaseTransformerController extends Controller
{
    abstract public function create(Project $project);

    public function edit(Project $project, Transformer $transformer)
    {
        request()->session()->flash('flash.banner', 'There is no edit for this');

        return to_route('projects.show', ['project' => $project->id]);
    }

    abstract public function store(Project $project);

    abstract public function update(Project $project, Transformer $transformer);

    public function run(Project $project, Transformer $transformer)
    {
        ProcessTransformerJob::dispatch($transformer);

        request()->session()->flash('flash.banner', 'Transformer running hold tight 🏃');

        return to_route('projects.show', [
            'project' => $project->id,
        ]);
    }
}
