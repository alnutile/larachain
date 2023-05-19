<?php

namespace App\ResponseType;

use App\Helpers\TypeTrait;

enum ResponseTypeEnum: string
{
    use TypeTrait;

    //case TemplateType = 'template_type'
    case PregReplace = 'preg_replace';
    case StringRemove = 'string_remove';
    case StringReplace = 'string_replace';
    case EmbedQuestion = 'embed_question';
    case VectorSearch = 'vector_search';
    case CombineContent = 'combine_content';
    case TrimText = 'trim_text';
    case ChatUi = 'chat_ui';
    case Api = 'api';

}
