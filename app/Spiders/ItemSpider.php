<?php

namespace App\Spiders;

use Generator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use RoachPHP\Downloader\Middleware\RequestDeduplicationMiddleware;
use RoachPHP\Extensions\LoggerExtension;
use RoachPHP\Extensions\StatsCollectorExtension;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;
use Symfony\Component\DomCrawler\Crawler;

class ItemSpider extends BasicSpider
{

    public array $downloaderMiddleware = [
        RequestDeduplicationMiddleware::class,
    ];

    public array $spiderMiddleware = [
        //
    ];

    public array $itemProcessors = [
        //
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
        $content = $response->filterXPath("//html/body/div[1]/div[3]/table[2]")->html();

        $data = [
            'content' => $content,
            "uri" => $response->getUri()
        ];


        //When can I dispatch this job
        //  this will get list from openai
        //  this will make embed from that list
        //  this will then save to db as a component
        //    save the url as well
        //try catch so they do not fail
        //

        yield $this->item($data);
    }


}
