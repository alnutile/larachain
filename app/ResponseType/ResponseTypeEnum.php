<?php

namespace App\ResponseType;

enum ResponseTypeEnum: string
{
    case EmbedQuestion = 'embed_question';
    case VectorSearch = 'vector_search';
    case CombineContent = 'combine_content';
    case ChatUi = 'chat_ui';
    case Api = 'api';

    public function label(): string
    {
        return match ($this) {
            static::EmbedQuestion => 'EmbedQuestion',
            static::VectorSearch => 'VectorSearch',
            static::CombineContent => 'CombineContent',
            static::ChatUi => 'ChatUi',
            static::Api => 'Api',
        };
    }
}
