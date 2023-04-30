<?php

namespace App\Console\Commands;

use App\Spiders\CollectionSpider;
use Illuminate\Console\Command;
use RoachPHP\Roach;

class RunCollection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larachain:run_collection {project_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will run the Roach CollectionSpider and save to project';

    public function handle()
    {
        Roach::startSpider(
            CollectionSpider::class,
            context: ['project_id' => $this->argument('project_id')]
        );
    }
}
