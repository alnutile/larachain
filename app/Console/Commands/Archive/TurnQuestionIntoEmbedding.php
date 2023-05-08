<?php

namespace App\Console\Commands\Archive;

use Facades\App\LLMModels\OpenAi\ClientWrapper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class TurnQuestionIntoEmbedding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larachain:turn_question_into_embedding {question}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Just to help me kick off some ideas';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Getting embedding');
        $results = ClientWrapper::getEmbedding($this->argument('question'));
        $path = storage_path('questions/embedding_'.md5($this->argument('question').'.json'));
        File::put($path, json_encode($results->embedding, 128));
        $this->info('Results in file '.$path);
    }
}
