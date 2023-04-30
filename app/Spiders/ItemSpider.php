<?php

namespace App\Spiders;

use Generator;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;

class ItemSpider extends BasicSpider
{
    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        ProcessPage::class,
    ];

    public array $extensions = [
        LoggerExtension::class,
        StatsCollectorExtension::class,
    ];

    public int $concurrency = 2;

    public int $requestDelay = 1;

    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        $content = $response->filterXPath('//html/body/div[1]/div[3]/table[2]')->html();

        $data = [
            'content' => $content,
            'uri' => $response->getUri(),
        ];

        yield $this->item($data);
    }
}
