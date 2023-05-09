<?php

namespace App\Outbound;

enum OutboundEnum: string
{
    case ChatUi = 'chat_ui';
    case Api = 'api';
    case Pdf = 'pdf';
    case Csv = 'csv';

    public function label(): string
    {
        return match ($this) {
            static::ChatUi => 'ChatUi',
            static::Api => 'Api',
            static::Pdf => 'Pdf',
            static::Csv => 'Csv',
        };
    }
}
