<?php

namespace App\Http\Controllers;

use App\Models\Outbound;

class DeleteOutboundController extends Controller
{
    public function delete(Outbound $outbound)
    {
        $projectId = $outbound->project_id;

        $outbound->response_types()->delete();

        $outbound->delete();

        request()->session()->flash('flash.banner', 'Outbound deleted...');

        return to_route('projects.show', [
            'project' => $projectId,
        ]);
    }
}
