<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Outbound;
use App\Models\Project;
use Tests\TestCase;

class SharedControllerTest extends TestCase
{
    public function test_show()
    {
        $project = Project::factory()->webShared()->create();

        $this->get(route('shared.show', [
            'slug' => $project->slug,
        ]))->assertStatus(200);

        $this->assertAuthenticated();
    }

    public function test_chat()
    {
        $project = Project::factory()->webShared()
            ->has(Outbound::factory()->chatUi())->create();

        $this->post(route('shared.chat', [
            'project' => $project->id,
        ]), [
            'question' => 'foobar',
        ])->assertStatus(200);

        $this->assertAuthenticated();

    }
}
