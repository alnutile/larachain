<?php

namespace App\ResponseType;

enum ResponseTypeEnum: string
{
    //case TemplateType = 'template_type'
    case EmbedQuestion = 'embed_question';
    case VectorSearch = 'vector_search';
    case CombineContent = 'combine_content';
    case TrimText = 'trim_text';
    case ChatUi = 'chat_ui';
    case Api = 'api';

    public function label(): string
    {
        return match ($this) {
            static::EmbedQuestion => 'EmbedQuestion',
            static::TrimText => 'TrimText',
            static::VectorSearch => 'VectorSearch',
            static::CombineContent => 'CombineContent',
            static::ChatUi => 'ChatUi',
            static::Api => 'Api',
        };
    }
}
