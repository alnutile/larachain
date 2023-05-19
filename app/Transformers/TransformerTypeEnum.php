<?php

namespace App\Transformers;

use App\Helpers\TypeTrait;

enum TransformerTypeEnum: string
{
    use TypeTrait;

    case EmbedTransformer = 'embed_transformer';
    case PdfTransformer = 'pdf_transformer';

}
