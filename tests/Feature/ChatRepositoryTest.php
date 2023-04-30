<?php

namespace Tests\Feature;

use Facades\App\Chat\ChatRepository;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChatRepositoryTest extends TestCase
{

    public function test_first_question_makes_message() {
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $question = "Foo bar";

        $this->assertDatabaseCount("messages", 0);
        $results = ChatRepository::handle($project, $user, $question);
        $this->assertDatabaseCount("messages", 1);

    }
}
