<?php

namespace App\Transformers\Types;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\Document;
use App\Transformers\BaseTransformer;
use Facades\App\LLMModels\OpenAi\ClientWrapper;

class PdfTransformer extends BaseTransformer
{

    public function handle(): Document
    {
        //find the source
        //get the file
        //get the content out of the file
        //create the document chunks

        return $this->document;
    }
}
