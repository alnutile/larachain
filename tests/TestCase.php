<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, LazilyRefreshDatabase;

    public function createTeam(User $user): User
    {
        $team = $user->ownedTeams()->create([
            'name' => 'Test',
            'personal_team' => true,
        ]);
        $user->current_team_id = $team->id;
        $user->save();

        return $user->refresh();
    }
}
