<?php

namespace App\Outbound;

enum OutboundEnum: string
{
    case ChatUi = 'chat_ui';
    case Api = 'api';
    case Pdf = '_pdf';
    case Csv = '_csv';

    public function label(): string
    {
        return match ($this) {
            static::ChatUi => 'ChatUi',
            static::Api => 'Api',
            static::Pdf => 'Pdf',
            static::Csv => 'Csv',
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
                    'route' => 'outbounds.'.$case->value.'.create',
                    'description' => config("larachain.outbounds.{$case->value}.description"),
                    'icon' => config("larachain.outbounds.{$case->value}.icon"),
                    'background' => config("larachain.outbounds.{$case->value}.background"),
                ];
            }
        }

        return $result;
    }
}
