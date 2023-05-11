<?php

namespace App\Transformers;

enum TransformerTypeEnum: string
{
    /**
     * _ will just dispable the type until ready to show in the UI
     *
     * @TODO Ideally do not have Transformer in the name
     */
    case EmbedTransformer = 'embed_transformer';
    case PdfTransformer = 'pdf_transformer';

    public function label(): string
    {
        return match ($this) {
            static::EmbedTransformer => 'EmbedTransformer',
            static::PdfTransformer => 'PdfTransformer',
        };
    }

    public static function toArray(): array
    {
        $result = [];
        foreach (static::cases() as $case) {
            if (! str($case->value)->startsWith('_')) {
                $result[] = [
                    'id' => $case->value,
                    'name' => str($case->label())->headline()->toString(),
                    'route' => 'transformers.'.$case->value.'.create',
                    'description' => config("larachain.transformers.{$case->value}.description"),
                    'icon' => config("larachain.transformers.{$case->value}.icon"),
                    'background' => config("larachain.transformers.{$case->value}.background"),
                ];
            }

        }

        return $result;
    }
}
