<?php

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\Outbound;
use App\Models\Project;
use App\Models\ResponseType;
use App\Models\Source;
use App\Models\User;
use App\Outbound\OutboundEnum;
use App\ResponseType\ResponseDto;
use App\ResponseType\ResponseTypeEnum;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use Tests\TestCase;

class OutboundTest extends TestCase
{
    public function test_should_have_factory()
    {

        $model = Outbound::factory()->create();
        $this->assertInstanceOf(OutboundEnum::class, $model->type);
    }

    public function test_has_relations_to_project()
    {

        $model = Outbound::factory()->has(ResponseType::factory(), 'response_types')->create();

        $this->assertNotNull($model->project->id);
        $this->assertNotNull($model->project->outbounds->first()->id);
        $this->assertNotNull($model->response_types->first()->id);
    }

    public function test_should_runs_the_related_response_types()
    {
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

    }

    public function test_trims_and_combines()
    {
        $user = User::factory()->create();

        $project = Project::factory()->create();
        $outbound = Outbound::factory()->create([
            'project_id' => $project->id,
        ]);

        $example = 'But don’t humans also have genuinely original ideas?” Come on, read a fantasy book. It’s either a Tolkien clone, or it’s A Song Of Ice And Fire. Tolkien was a professor of Anglo-Saxon language and culture; no secret where he got his inspiration. A Song Of Ice And Fire is just War Of The Roses with dragons. Lannister and Stark are just Lancaster and York, the map of Westeros is just Britain (minus Scotland) with an upside down-Ireland stuck to the bottom of it – wake up, sheeple! Dullards blend Tolkien into a slurry and shape it into another Tolkien-clone. Tolkien-level artistic geniuses blend human experience, history, and the artistic corpus into a slurry and form it into an entirely new genre. Again, the difference is how finely you blend and what spices you add to the slurry.';
        $source = Source::factory()->create([
            'project_id' => $project->id,
        ]);

        $trim = ResponseType::factory()
            ->trimText()
            ->create(['order' => 1, 'outbound_id' => $outbound->id]);

        $combine = ResponseType::factory()
            ->combineContent()
            ->create(['order' => 2, 'outbound_id' => $outbound->id]);

        $request = $example;

        /** @var ResponseDto $results */
        $results = $outbound->run($user, $request);

        $expected = 'But don’t humans also have genuinely original ideas?” Come on, read a fantasy book. It’s either a Tolkien clone,';
        $this->assertStringContainsString($expected, $results->response);
    }
}
