<?php

namespace App\Http\Controllers;

use App\Jobs\RunTransformerJob;
use App\Models\Project;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;

class TransformersRunController extends Controller
{
    public function run(Project $project)
    {
        $jobs = [];

        foreach ($project->transformers->sortBy('order') as $transformer) {
            $jobs[] = new RunTransformerJob($transformer);
        }

        $batch = Bus::batch($jobs)->then(function (Batch $batch) {
            // Execute when batch is finished
        })->catch(function (Batch $batch, Throwable $e) use ($project) {
            logger('Errors with project '.$project->id);
        })->finally(function (Batch $batch) {

        })->dispatch();

        request()->session()->flash('flash.banner', 'Running transformers');

        return back();
    }
}
