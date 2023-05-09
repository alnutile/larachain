<?php

namespace App\Http\Controllers;

use App\Models\Outbound;
use App\Models\Project;
use Illuminate\Http\Request;

class OutboundController extends Controller
{
    public function __invoke(Project $project, Outbound $outbound)
    {
        /** @TODO find route binding for this */
        if($outbound->project_id !== $project->id) {
            abort(404);
        }

        /**
         * @TODO they all have to be the same response type
         * either a DTO or string
         * maybe I need the status too?
         * some might put a job on a queue
         * some might need to be waited for
         * some might use pusher so a queue etc
         */
        //$response = outbound run
        return response("", 200);
    }
}
