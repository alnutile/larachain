<?php

namespace App\Source;

/**
 * @see settings in config/larachain.php:3
 */
enum SourceTypeEnum: string
{
    case WebFile = 'web_file';
    case Web = '_web';
    case S3Dir = '_s3_directory';

    public function label(): string
    {
        return match ($this) {
            static::WebFile => 'WebFile',
            static::Web => 'Web',
            static::S3Dir => 'S3Dir',
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
                    'route' => 'sources.'.$case->value.'.create',
                    'description' => config('larachain.sources.web_file.description'),
                    'icon' => config('larachain.sources.web_file.icon'),
                    'background' => config('larachain.sources.web_file.background'),
                ];
            }

        }

        return $result;
    }
}
