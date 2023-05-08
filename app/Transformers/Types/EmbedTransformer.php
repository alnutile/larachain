<?php

namespace App\Transformers\Types;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\Document;
use App\Models\Transformer;
use App\Transformers\BaseTransformer;
use Facades\App\LLMModels\OpenAi\ClientWrapper;

class EmbedTransformer extends BaseTransformer
{
    public function handle(Transformer $transformer): Document
    {
        foreach ($this->document->document_chunks as $chunk) {
            /** @var EmbeddingsResponseDto $embeddings */
            $embeddings = ClientWrapper::getEmbedding($chunk->content);

            $chunk->embedding = $embeddings->embedding;
            $chunk->token_count = $embeddings->token_count;
            $chunk->save();
        }

        return $this->document;
    }
}
