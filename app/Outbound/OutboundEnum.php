<?php

namespace App\Outbound;

use App\Helpers\TypeTrait;

enum OutboundEnum: string
{
    use TypeTrait;

    case ChatUi = 'chat_ui';


}
