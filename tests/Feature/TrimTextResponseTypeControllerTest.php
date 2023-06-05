<?php

use App\Models\Outbound;
use App\Models\Project;
use App\Models\ResponseType;
use App\Models\User;
use App\ResponseType\ResponseTypeEnum;

it('creates trim text', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $outbound = Outbound::factory()->create(
        ['project_id' => $project->id]
    );

    $this->assertDatabaseCount('response_types', 0);

    $this->actingAs($user)
        ->get(route('response_types.trim_text.create', [
            'outbound' => $outbound->id,
        ]));
    $this->assertDatabaseCount('response_types', 1);
    $this->assertNotNull(ResponseType::whereType(ResponseTypeEnum::TrimText->value)->first());
});
