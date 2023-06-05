<?php

namespace App\Console\Commands\Archive;

use App\Models\Project;
use Facades\App\Transformer\EmbedContent;
use Illuminate\Console\Command;

class LarachainTransformEmbed extends Command
{
    protected $signature = 'larachain:transform:embed {project_id}';

    protected $description = 'This would be on a chain but for demo purposes I will run it here';

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
        $this->info('Starting Embed Process');

        $documents = $project->documents;

        $bar = $this->output->createProgressBar(count($documents));

        $bar->start();

        foreach ($documents as $document) {
            try {
                EmbedContent::handle($document);
                $bar->advance();
            } catch (\Exception $e) {
                logger('Error with embedding');
                logger($e->getMessage());
                $bar->advance();
            }
        }

        $bar->finish();
    }
}
