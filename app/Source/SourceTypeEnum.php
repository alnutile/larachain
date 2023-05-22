<?php

namespace App\Source;

use App\Helpers\TypeTrait;

/**
 * @see settings in config/larachain.php:3
 */
enum SourceTypeEnum: string
{
    use TypeTrait;

    //case TemplateType = 'template_type'
    case WebFile = 'web_file';
}
