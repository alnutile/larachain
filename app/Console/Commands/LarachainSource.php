<?php

namespace App\Console\Commands;

use App\Spiders\CollectionSpider;
use Illuminate\Console\Command;
use RoachPHP\Roach;

class LarachainSource extends Command
{
    protected $signature = 'larachain:source {source_id}';

    protected $description = 'Using the project it will know how to get the source data';

    public function handle()
    {
        /**
         * @TODO
         * Next using Project Source Ingress::Type
         * we can understand what action to run
         * In this POC I will manually run the action for Ingress::WebScrape
         */
        Roach::startSpider(
            CollectionSpider::class,
            context: ['source_id' => $this->argument('source_id')]
        );
    }
}
