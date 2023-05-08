<?php

namespace App\ResponseType;

enum ResponseTypeEnum: string
{
    case ChatUi = 'chat_ui';
    case Api = 'api';

    public function label(): string
    {
        return match ($this) {
            static::ChatUi => 'ChatUi',
            static::Api => 'Api',
        };
    }
}
