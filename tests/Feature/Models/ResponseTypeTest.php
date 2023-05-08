<?php

namespace Tests\Feature\Models;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\Document;
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
        $request = 'Foo bar';

        $embeddings = get_fixture('embedding_response.json');

        /** @var ResponseType $responseType */
        $responseType = ResponseType::factory()->create([
            'type' => ResponseTypeEnum::EmbedQuestion,
        ]);

        $dto = new EmbeddingsResponseDto(
            data_get($embeddings, 'data.0.embedding'),
            1000
        );

        ClientWrapper::shouldReceive('getEmbedding')
            ->once()
            ->andReturn($dto);

        $this->assertDatabaseCount('messages', 0);
        /** @var ResponseDto $results */
        $responseType->run($user, $request);
        $this->assertDatabaseCount('messages', 1);
    }

    public function test_runs_embed_then_search()
    {
        $user = User::factory()->create();
        $request = 'History';

        $embeddings = get_fixture('embedding_response.json');

        Document::factory()->withEmbedData()->create();

        $project = Project::factory()->create();

        $responseType1 = ResponseType::factory()->create([
            'type' => ResponseTypeEnum::EmbedQuestion,
            'project_id' => $project->id,
            'order' => 1,
        ]);

        $responseType2 = ResponseType::factory()->create([
            'type' => ResponseTypeEnum::VectorSearch,
            'project_id' => $project->id,
            'order' => 2,
        ]);

        $responseType3 = ResponseType::factory()->create([
            'type' => ResponseTypeEnum::CombineContent,
            'project_id' => $project->id,
            'order' => 4,
        ]);


        $dto = new EmbeddingsResponseDto(
            data_get($embeddings, 'data.0.embedding'),
            1000
        );

        ClientWrapper::shouldReceive('getEmbedding')
            ->once()
            ->andReturn($dto);
        /** @var ResponseDto $results */
        $results = $responseType1->run($user, $request);
        $this->assertNotNull($results->response);
    }
}
