<?php

namespace App\Http\Controllers;

use App\Models\Outbound;
use App\Models\Project;
use App\ResponseType\ResponseDto;

class OutboundController extends Controller
{
    public function __invoke(Project $project, Outbound $outbound)
    {
        /** @TODO find route binding for this */
        if ($outbound->project_id !== $project->id) {
            abort(404);
        }
        $validated = request()->validate([
            'question' => ['required', 'max:5000'],
        ]);

        $user = auth()->user();
        $request = $validated['question'];

        /** @var ResponseDto $response */
        $response = $outbound->run($user, $request);

        return response($response->response->contents->toArray(), $response->status);
    }
}
