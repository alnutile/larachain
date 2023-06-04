<?php

use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Message;
use App\Models\Outbound;
use App\Models\Project;
use App\Models\ResponseType;
use App\Models\Source;
use App\Models\User;
use App\Outbound\OutboundEnum;
use App\ResponseType\ContentCollection;
use App\ResponseType\ResponseDto;
use App\ResponseType\Types\ChatGptRetrievalPlugin;
use App\ResponseType\Types\VectorSearch;
use Illuminate\Support\Facades\File;
use function Pest\Laravel\assertDatabaseCount;

it('test shows create page ChatGptRetrieval Outbound', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    assertDatabaseCount('outbounds', 0);

    $this->actingAs($user)
        ->get(route('outbounds.chat_gpt_retrieval.create', [
            'project' => $project->id,
        ]))
        ->assertRedirectToRoute('outbounds.chat_gpt_retrieval.show', [
            'project' => $project->id,
            'outbound' => Outbound::first()->id,
        ]);
    assertDatabaseCount('outbounds', 1);
});

it('test show ChatGptRetrieval Outbound', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $outbound = Outbound::factory()->create([
        'type' => OutboundEnum::ChatGptRetrieval,
        'project_id' => $project->id,
    ]);

    $this->actingAs($user)
        ->get(route('outbounds.chat_gpt_retrieval.show', [
            'project' => $project->id,
            'outbound' => $outbound->id,
        ]))
        ->assertOk();
});

it('test openapi yaml', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $outbound = Outbound::factory()->create([
        'type' => OutboundEnum::ChatGptRetrieval,
        'project_id' => $project->id,
    ]);
    $openaiApi = File::get(base_path('tests/fixtures/openapi.yaml'));
    $this->actingAs($user)
        ->get(route('api.outbounds.chat_gpt_retrieval.openapi', [
            'project' => $project->id,
            'outbound' => $outbound->id,
        ]))
        ->assertOk();
});


it('test query ChatGptRetrieval Outbound', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();
    $user = $this->createTeam($user);
    $source = Source::factory()->create();

    $outbound = Outbound::factory()->create([
        'type' => OutboundEnum::ChatGptRetrieval,
        'project_id' => $source->project_id,
    ]);

    $document = Document::factory()->create([
        'source_id' => $source->id,
    ]);

    DocumentChunk::factory()->withEmbedData()->create([
        'document_id' => $document->id,
    ]);

    $rt = ResponseType::factory()->vectorSearch()->create(
        [
            'outbound_id' => $outbound->id
        ]
    );
    $chatGtpRt = ResponseType::factory()->chatGtpRetrieval()->create(
        [
            'outbound_id' => $outbound->id
        ]
    );

    $this->actingAs($user)
        ->post(route('api.outbounds.chat_gpt_retrieval.query', [
            'outbound' => $outbound->id
        ]), [
            "queries" => [
                "What does WDR stand for?"
            ]
        ])
        ->assertOk()
        ->assertJson([
            [
                'query' => "What does WDR stand for?",
                "results" => []
            ]
        ]);
});
