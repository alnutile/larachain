<?php

namespace App\Console\Commands;

use App\Models\Project;
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
    protected $description = 'Command description';

    public function handle()
    {
        $transformations = Transformer::where("project_id", $this->argument("project_id"))->get();

        $this->info("Going to run " . count($transformations) . " transformations");

        foreach($transformations as $transformation) {

        }
    }
}
