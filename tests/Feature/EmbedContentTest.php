<?php

namespace Tests\Feature;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\Document;
use App\Transformers\EmbedContent;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use Tests\TestCase;

class EmbedContentTest extends TestCase
{
    public function test_calls_embed()
    {
        $data = get_fixture('embedding_response.json');

        $dto = new EmbeddingsResponseDto(
            data_get($data, 'data.0.embedding'),
            1000,
        );

        ClientWrapper::shouldReceive('getEmbedding')->once()->andReturn($dto);

        $document = Document::factory()->create();
        $this->assertEmpty($document->refresh()->embedding);
        $embedder = new EmbedContent();
        $documentUpdate = $embedder->handle($document);
        $this->assertNotEmpty($documentUpdate->embedding);

    }
}
