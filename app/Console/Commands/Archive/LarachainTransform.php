<?php

namespace App\Console\Commands\Archive;

use App\Models\Project;
use Facades\App\Transformers\HtmlToTextTransformer;
use Illuminate\Console\Command;

class LarachainTransform extends Command
{
    protected $signature = 'larachain:transform {project_id}';

    protected $description = 'Using the project and related Transformers, it will know how to tranform it';

    public function handle()
    {
        /**
         * @TODO
         * Next using Project Source Documents
         * And the related Transformers and order of
         * we can just run those.
         * In this POC I will manually choose the transformers
         */
        $project = Project::findOrFail($this->argument('project_id'));
        $this->info('Starting the Html to Text Process');

        $documents = $project->documents;

        $bar = $this->output->createProgressBar(count($documents));

        $bar->start();

        foreach ($documents as $document) {
            try {
                HtmlToTextTransformer::handle($document);
                $bar->advance();
            } catch (\Exception $e) {
                logger('Error with transformation');
                logger($e);
                $bar->advance();
            }
        }

        $bar->finish();
    }
}
