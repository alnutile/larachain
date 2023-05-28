<?php

namespace App\Transformers;

use App\Helpers\TypeTrait;

enum TransformerTypeEnum: string
{
    use TypeTrait;

    //case TemplateType = 'template_type'
    case EmbedTransformer = 'embed_transformer';
    case PdfTransformer = 'pdf_transformer';

}
