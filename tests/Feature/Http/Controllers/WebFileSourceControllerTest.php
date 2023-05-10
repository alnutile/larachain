<?php

use App\Models\Project;
use App\Models\User;

it("should show the form for URL Source type", function () {
    $user = User::factory()->withPersonalTeam()->create();

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id
    ]);

    $this->actingAs($user)
        ->get(route("sources.web_file.create", [
            'project' => $project->id
        ]))
        ->assertOk();

});
