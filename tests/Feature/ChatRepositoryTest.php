<?php

namespace Tests\Feature;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\Document;
use Facades\App\Tools\ChatRepository;
use App\Models\Project;
use App\Models\User;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChatRepositoryTest extends TestCase
{

    public function test_first_question_makes_message() {
        $embeddings = get_fixture("embedding_response.json");
        $dto = new EmbeddingsResponseDto(
            data_get($embeddings, 'data.0.embedding'),
            1000
        );

        ClientWrapper::shouldReceive("getEmbedding")
            ->once()
            ->andReturn($dto);

        Document::factory()->withEmbedData()->create();


        $project = Project::factory()->create();
        $user = User::factory()->create();

        ClientWrapper::shouldReceive('chat')->once()->andReturn("foo bar");

        $question = "Foo bar";

        $this->assertDatabaseCount("messages", 0);
        $results = ChatRepository::handle($project, $user, $question);
        $this->assertDatabaseCount("messages", 3);
    }


}
