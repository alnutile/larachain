<?php

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\Document;
use App\Models\Outbound;
use App\Models\Project;
use App\Models\ResponseType;
use App\Models\User;
use App\Outbound\OutboundEnum;
use App\ResponseType\ResponseDto;
use App\ResponseType\ResponseTypeEnum;
use Facades\App\LLMModels\OpenAi\ClientWrapper;

it('should have factory', function () {

    $model = Outbound::factory()->create();
    expect($model->type)->toBeInstanceOf(OutboundEnum::class);
});

it('has relations to project', function () {

    $model = Outbound::factory()->has(ResponseType::factory(), 'response_types')->create();

    expect($model->project->id)->not->toBeNull();
    expect($model->project->outbounds->first()->id)->not->toBeNull();
    expect($model->response_types->first()->id)->not->toBeNull();
});

it('should ru the related response types', function () {
    $user = User::factory()->create();
    $request = 'Foo bar';

    $embeddings = get_fixture('embedding_response.json');

    $project = Project::factory()->create();
    $outbound = Outbound::factory()->create([
        'project_id' => $project->id,
    ]);

    /** @var ResponseType $responseType */
    ResponseType::factory()->create([
        'outbound_id' => $outbound->id,
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
    $outbound->run($user, $request);
    $this->assertDatabaseCount('messages', 1);

});

//public function test_runs_embed_then_search()
//{
//    $user = User::factory()->create();
//    $request = 'History';
//
//    $embeddings = get_fixture('embedding_response.json');
//
//    Document::factory()->withEmbedData()->create();
//
//    $project = Project::factory()->create();
//
//    $responseType1 = ResponseType::factory()->create([
//        'type' => ResponseTypeEnum::EmbedQuestion,
//        'project_id' => $project->id,
//        'order' => 1,
//    ]);
//
//    $responseType2 = ResponseType::factory()->create([
//        'type' => ResponseTypeEnum::VectorSearch,
//        'project_id' => $project->id,
//        'order' => 2,
//    ]);
//
//    $responseType3 = ResponseType::factory()->create([
//        'type' => ResponseTypeEnum::CombineContent,
//        'project_id' => $project->id,
//        'order' => 4,
//    ]);
//
//    $dto = new EmbeddingsResponseDto(
//        data_get($embeddings, 'data.0.embedding'),
//        1000
//    );
//
//    ClientWrapper::shouldReceive('getEmbedding')
//        ->once()
//        ->andReturn($dto);
//    /** @var ResponseDto $results */
//    $results = $responseType1->run($user, $request);
//    $this->assertNotNull($results->response);
//}
