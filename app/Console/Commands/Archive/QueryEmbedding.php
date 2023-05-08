<?php

namespace App\Console\Commands\Archive;

use App\Models\Document;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use OpenAI\Laravel\Facades\OpenAI;
use Pgvector\Laravel\Vector;
use Sundance\LarachainPromptTemplates\Prompts\PromptToken;
use Sundance\LarachainPromptTemplates\PromptTemplate;

class QueryEmbedding extends Command
{
    protected $signature = 'larachain:query {question_file_name}';

    protected $description = 'Another Cheat to see the query work';

    public function handle()
    {
        $question = "What other makers are around the time of O'Keeffe, Georgia";
        $path = storage_path('questions/'.$this->argument('question_file_name'));
        $query = json_decode(File::get($path));
        $query = new Vector($query);

        $documents = Document::query()
            ->selectRaw('embedding <-> ? as distance, content', [$query])
            ->orderByRaw('distance')
            ->get();

        $combinedContent = '';

        foreach ($documents as $document) {
            $combinedContent .= $document->content;
            if (strlen($combinedContent) >= 750) {
                break;
            }
        }

        $template = <<<'EOL'
As a helpful historian, I have been asked the question below. I will provide some context found in a local historical art
collection database using a vector query. Please help me reply with a well-formatted answer and offer to get more information
if needed.
Context: {context}
###


EOL;

        $input_variables = [
            new PromptToken('context', $combinedContent),
        ];

        $prompt = new PromptTemplate($input_variables, $template);

        $stream = OpenAI::chat()->createStreamed([
            'model' => 'gpt-3.5-turbo',
            'temperature' => 0.7,
            'messages' => [
                [
                    'role' => 'system',
                    'content' => $prompt->format(),
                ],
                [
                    'role' => 'user',
                    'content' => $question,
                ],
            ],
        ]);

        $count = 0;
        $reply = '';

        foreach ($stream as $response) {
                $step = $response->choices[0]->toArray();
                $reply = $reply.' '.data_get($step, 'delta.content');
                if ($count >= 20) {
                    $this->info($reply);
                    $count = 0;
                    $reply = '';
                } else {
                    $count = $count + 1;
                }
        }

    }
}
