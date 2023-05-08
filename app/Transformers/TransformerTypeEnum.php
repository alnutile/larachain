<?php

namespace App\Transformers;

enum TransformerTypeEnum: string
{
    case EmbedTransformer = 'embed_transformer';
    case PdfTransformer = 'pdf_transformer';

    public function label(): string
    {
        return match ($this) {
            static::EmbedTransformer => 'EmbedTransformer',
            static::PdfTransformer => 'PdfTransformer',
        };
    }
}
