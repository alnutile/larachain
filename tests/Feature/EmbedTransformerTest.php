<?php

namespace Tests\Feature;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\DocumentChunk;
use App\Models\Transformer;
use App\Transformers\Types\EmbedTransformer;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use Tests\TestCase;

class EmbedTransformerTest extends TestCase
{
    public function test_embeds_data()
    {
        $data = get_fixture('embedding_response.json');

        $dto = new EmbeddingsResponseDto(
            data_get($data, 'data.0.embedding'),
            1000,
        );

        $transformer = Transformer::factory()->create();

        ClientWrapper::shouldReceive('getEmbedding')->once()->andReturn($dto);

        $documentChunk = DocumentChunk::factory()->create();
        $this->assertEmpty($documentChunk->refresh()->embedding);
        $tranformer = new EmbedTransformer($documentChunk->document);
        $tranformer->handle($transformer);
        $this->assertNotEmpty($documentChunk->refresh()->embedding);
        $this->assertNotEmpty($documentChunk->refresh()->token_count);

    }
}
