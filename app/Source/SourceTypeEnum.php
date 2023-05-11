<?php

namespace App\Source;

/**
 * @see settings in config/larachain.php:3
 */
enum SourceTypeEnum: string
{

    /**
     * _ will just dispable the type until ready to show in the UI
     */
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
                    'description' => config("larachain.sources.{$case->value}.description"),
                    'icon' => config("larachain.sources.{$case->value}.icon"),
                    'background' => config("larachain.sources.{$case->value}.background"),
                ];
            }

        }

        return $result;
    }
}
