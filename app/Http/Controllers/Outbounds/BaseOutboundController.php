<?php

namespace App\Http\Controllers\Outbounds;

use App\Http\Controllers\Controller;
use App\Models\Outbound;
use App\Models\Project;
use App\Models\User;
use App\ResponseType\ResponseDto;

abstract class BaseOutboundController extends Controller
{
    abstract public function create(Project $project);

    abstract public function edit(Project $project, Outbound $outbound);

    abstract public function store(Project $project);

    abstract public function update(Project $project, Outbound $outbound);

    public function run(Project $project, Outbound $outbound)
    {
        $validate = request()->validate([
            'question' => ['required'],
        ]);

        /** @var User $user */
        $user = auth()->user();

        /**
         * @var ResponseDto $response
         */
        $response = $outbound->run($user, $validate['question']);

        /**
         * @TODO return as API when ready
         */
        return to_route('projects.show', [
            'project' => $project->id,
        ]);
    }
}
