<?php

namespace App\Http\Controllers\Sources;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessSourceJob;
use App\Models\Project;
use App\Models\Source;

abstract class BaseSourceController extends Controller
{
    abstract public function create(Project $project);

    abstract public function edit(Project $project, Source $source);

    abstract public function store(Project $project);

    abstract public function update(Project $project, Source $source);

    public function run(Project $project, Source $source)
    {
        ProcessSourceJob::dispatch($source);

        request()->session()->flash('flash.banner', 'Getting file will notify you when done 🗃️');

        return to_route('projects.show', [
            'project' => $project->id,
        ]);
    }
}
