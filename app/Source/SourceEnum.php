<?php

namespace App\Source;

use App\Helpers\TypeTrait;

/**
 * @see settings in config/larachain.php:3
 */
enum SourceEnum: string
{
    use TypeTrait;

    //case TemplateType = 'template_type'
    case ScrapeWebPage = 'scrape_web_page';
    case WebFile = 'web_file';
}
