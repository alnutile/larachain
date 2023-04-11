<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::whereEmail(env('ADMIN_EMAIL'))->first();
        if (! $user) {
            $user = new User();
            $user->name = 'Admin';
            $user->email = env('ADMIN_EMAIL');
            $user->password = bcrypt(env('ADMIN_PASSWORD'));
            $user->save();
        }

        $team = new Team();
        $team->personal_team = 1;
        $team->user_id = $user->id;
        $team->name = 'Admin Team';
        $team->save();

        $user->current_team_id = $team->id;
        $user->save();
    }
}
