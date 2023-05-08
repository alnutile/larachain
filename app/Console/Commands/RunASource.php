<?php

namespace App\Console\Commands;

use App\Models\Source;
use Illuminate\Console\Command;

class RunASource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larachain:run-source {source_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run a source on the system';

    public function handle()
    {
        $source = Source::find($this->argument('source_id'));
        $this->info('Running');
        $source->run();
        $this->info('Complete');
    }
}
