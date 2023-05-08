<?php

namespace App\Console\Commands;

use App\Models\Transformer;
use Illuminate\Console\Command;

class RunTranformations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larachain:run_transformations {project_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all the transformations related to a project';

    public function handle()
    {
        $transformations = Transformer::where('project_id', $this->argument('project_id'))->get();

        $this->info('Going to run '.count($transformations).' transformations');

        foreach ($transformations as $transformation) {
            try {
                $this->info('Running '.$transformation->id);
                $transformation->run();
                $this->info('Done running '.$transformation->id);
            } catch (\Exception $e) {
                logger('Error running '.$transformation->id);
                logger($e->getMessage());
            }
        }

        $this->info('DONE');
    }
}
