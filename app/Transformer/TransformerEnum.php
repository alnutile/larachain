<?php

namespace App\Transformer;

use App\Helpers\TypeTrait;

enum TransformerEnum: string
{
    use TypeTrait;

    //case TemplateType = 'template_type'
    case JsonTransformer = 'json_transformer';
    case CsvTransformer = 'csv_transformer';
    case Html2Text = 'html2text';
    case EmbedTransformer = 'embed_transformer';
    case PdfTransformer = 'pdf_transformer';

}
