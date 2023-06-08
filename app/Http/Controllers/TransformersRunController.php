<?php

namespace App\Http\Controllers;

use App\Jobs\RunTransformerJob;
use App\Models\Project;
use Illuminate\Support\Facades\Bus;

class TransformersRunController extends Controller
{
    public function run(Project $project)
    {
        $jobs = [];

        foreach ($project->transformers->sortBy('order') as $transformer) {
            $jobs[] = new RunTransformerJob($transformer);
        }

        $batch = Bus::chain($jobs)->dispatch();

        request()->session()->flash('flash.banner', 'Running transformers');

        return back();
    }
}
