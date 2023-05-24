<?php

namespace App\Http\Controllers;

use App\Http\Resources\SharedProject;
use App\Models\Outbound;
use App\Models\Project;
use App\Outbound\OutboundEnum;

class SharedController extends Controller
{
    public function show(string $slug)
    {

        $project = Project::whereSlug($slug)->first();

        if (! $project) {
            abort(404);
        }

        return inertia('Shared/Show', [
            'project' => new SharedProject($project),
        ]);
    }

    public function chat(Project $project)
    {
        $validated = request()->validate([
            'question' => ['required', 'max:5000'],
        ]);

        try {
            $outbound = $project->outbounds()
                ->whereType(OutboundEnum::ChatUi->value)
                ->first();
            if ($outbound) {
                /** @var Outbound $outbound */
                $outbound->run(
                    auth()->user(),
                    $validated['question']
                );
            }

            return response()->json([], 200);
        } catch (\Exception $e) {
            logger($e->getMessage());
            logger($e);

            return response()->json('Please try again later', 429);
        }
    }
}
