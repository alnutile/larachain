<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }


    public function edit(User $user, Project $project): Response
    {
        return $user->current_team_id === $project->team_id
            ? Response::allow()
            : Response::deny('You need to be on this team');
    }

    public function view(User $user, Project $project): Response
    {

        return $user->current_team_id === $project->team_id
                ? Response::allow()
                : Response::deny('You need to be on this team');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Project $project): Response
    {

        return $user->current_team_id === $project->team_id
            ? Response::allow()
            : Response::deny('You need to be on this team');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Project $project): bool
    {
        return $user->current_team_id === $project->team_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Project $project): bool
    {
        return $user->current_team_id === $project->team_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Project $project): bool
    {
        return $user->current_team_id === $project->team_id;
    }
}
