<?php

namespace App\Source;

enum SourceTypeEnum: string
{
    case WebFile = 'web_file';
    case Web = 'web';
    case S3Dir = 's3_directory';
}
