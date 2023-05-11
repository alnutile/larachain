<?php

namespace App\Http\Controllers\Tranformers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Transformer;

abstract  class BaseTransformerController extends Controller
{
    abstract public function create(Project $project);

    abstract public function edit(Project $project, Transformer $transformer);

    abstract public function store(Project $project);

    abstract public function update(Project $project, Transformer $transformer);

    abstract public function run(Project $project, Transformer $transformer);
}
