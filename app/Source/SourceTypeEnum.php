<?php

namespace App\Source;

enum SourceTypeEnum: string
{
    case WebFile = 'web_file';
    case Web = 'web';
    case S3Dir = 's3_directory';

    public function label(): string
    {
        return match($this) {
            static::WebFile => 'WebFile',
            static::Web => 'Web',
            static::S3Dir => 'S3Dir',
        };
    }
}
