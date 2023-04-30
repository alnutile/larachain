<?php

namespace App\Ingress;

enum IngressTypeEnum: string
{
    case WebScrape = 'web_scrape';
    case PdfScrape = 'pdf_scrape';
}
