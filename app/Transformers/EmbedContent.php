<?php

namespace App\Transformers;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\Document;
use Facades\App\LLMModels\OpenAi\ClientWrapper;

class EmbedContent
{
    public function handle(Document $document)
    {
        /** @var EmbeddingsResponseDto $embeddings */
        $embeddings = ClientWrapper::getEmbedding($document->content);

        $document->embedding = $embeddings->embedding;
        $document->token_count = $embeddings->token_count;
        $document->save();

        return $document;
    }
}
