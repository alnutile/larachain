<?php

namespace Tests\Feature;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\Document;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use Facades\App\Tools\ChatRepository;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ChatRepositoryTest extends TestCase
{
    public function test_first_question_makes_message()
    {
        Event::fake();
        $embeddings = get_fixture('embedding_response.json');
        $dto = new EmbeddingsResponseDto(
            data_get($embeddings, 'data.0.embedding'),
            1000
        );

        ClientWrapper::shouldReceive('getEmbedding')
            ->once()
            ->andReturn($dto);

        Document::factory()->withEmbedData()->create();

        $project = Project::factory()->create();
        $user = User::factory()->create();

        ClientWrapper::shouldReceive('projectChat')->once()->andReturn('foo bar');

        $question = 'Foo bar';

        $this->assertDatabaseCount('messages', 0);
        $results = ChatRepository::handle($project, $user, $question);
        $this->assertDatabaseCount('messages', 3);
        $this->assertEquals(1, Message::whereRole('system')->count());
        $this->assertEquals(1, Message::whereRole('user')->count());
    }

    public function test_followup_questions()
    {
        Event::fake();

        $project = Project::factory()->create();
        $user = User::factory()->create();
        $embeddings = get_fixture('embedding_response.json');
        $dto = new EmbeddingsResponseDto(
            data_get($embeddings, 'data.0.embedding'),
            1000
        );

        Message::factory()->create(
            [
                'role' => 'system',
                'content' => 'foobar',
                'project_id' => $project->id,
                'user_id' => $user->id,
            ]
        );

        Message::factory()->create(
            [
                'role' => 'user',
                'content' => 'foobar',
                'project_id' => $project->id,
                'user_id' => $user->id,
            ]
        );

        ClientWrapper::shouldReceive('getEmbedding')
            ->once()
            ->andReturn($dto);

        Document::factory()->withEmbedData()->create();

        ClientWrapper::shouldReceive('projectChat')->once()->andReturn('foo bar');

        $question = 'Foo bar';

        $results = ChatRepository::handle($project, $user, $question);
        $this->assertDatabaseCount('messages', 5);
        $this->assertEquals(1, Message::whereRole('system')->count());
        $this->assertEquals(2, Message::whereRole('user')->count());
        $this->assertEquals(2, Message::whereRole('assistant')->count());
    }
}
