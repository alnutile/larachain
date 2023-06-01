<?php

namespace App\Outbound;

use App\Helpers\TypeTrait;

enum OutboundEnum: string
{
    use TypeTrait;

    //case TemplateType = 'template_type'
    case ChatUi = 'chat_ui';
    case Api = 'api';
    case ChatGptRetrieval = 'chat_gpt_retrieval';

}
