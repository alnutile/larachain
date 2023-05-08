<?php

namespace Tests\Feature\Models;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\Document;
use App\Models\Message;
use App\Models\Project;
use App\Models\ResponseType;
use App\Models\User;
use App\ResponseType\ResponseDto;
use App\ResponseType\ResponseTypeEnum;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResponseTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_rt()
    {
        $model = ResponseType::factory()->create();
        $this->assertEquals(ResponseTypeEnum::ChatUi, $model->type);

        $this->assertNotNull($model->project->id);
        $this->assertNotNull($model->project->response_types->first()->id);
    }

    public function test_rt_run()
    {
        $user = User::factory()->create();
        $request = "Foo bar";

        $embeddings = get_fixture('embedding_response.json');

        /** @var ResponseType $responseType */
        $responseType = ResponseType::factory()->create([
            'type' => ResponseTypeEnum::EmbedQuestion
        ]);

        $dto = new EmbeddingsResponseDto(
            data_get($embeddings, 'data.0.embedding'),
            1000
        );

        ClientWrapper::shouldReceive('getEmbedding')
            ->once()
            ->andReturn($dto);

        $this->assertDatabaseCount("messages", 0);
        /** @var ResponseDto $results */
        $responseType->run($user, $request);
        $this->assertDatabaseCount("messages", 1);
    }

    public function test_runs_embed_then_search()
    {
        $user = User::factory()->create();
        $request = "Foo bar";

        $embeddings = get_fixture('embedding_response.json');

        Document::factory()->withEmbedData()->create();

        /** @var ResponseType $responseType */
        $responseType = ResponseType::factory()->create([
            'type' => ResponseTypeEnum::EmbedQuestion,
            'order' => 1
        ]);

        /** @var ResponseType $responseType */
        $responseType = ResponseType::factory()->create([
            'type' => ResponseTypeEnum::VectorSearch,
            'order' => 2
        ]);

        $dto = new EmbeddingsResponseDto(
            data_get($embeddings, 'data.0.embedding'),
            1000
        );

        ClientWrapper::shouldReceive('getEmbedding')
            ->once()
            ->andReturn($dto);
        $this->assertDatabaseCount("messages", 0);
        /** @var ResponseDto $results */
        $results = $responseType->run($user, $request);
        $this->assertDatabaseCount("messages", 2);
        $this->assertNotNull($results->response);
        $this->assertEquals(1, Message::whereRole('system')->count());
        $this->assertEquals(1, Message::whereRole('user')->count());
    }
}
