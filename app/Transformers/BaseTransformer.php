<?php

namespace App\Transformers;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\Document;
use Facades\App\LLMModels\OpenAi\ClientWrapper;

abstract class BaseTransformer
{

    public function __construct(public Document $document)
    {
    }


    abstract  public function handle() : Document;

}
