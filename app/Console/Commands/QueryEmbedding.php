<?php

namespace App\Console\Commands;

use Facades\App\LLMModels\OpenAi\ClientWrapper;
use App\Models\Document;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
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
        $path = storage_path("questions/" . $this->argument("question_file_name"));
        $query = json_decode(File::get($path));
        $query = new Vector($query);

        $documents = Document::query()
            ->selectRaw("embedding <-> ? as distance, content", [$query])
            ->orderByRaw('distance')
            ->get();

        $combinedContent = "";

        foreach ($documents as $document) {
            // Append the document content
            var_dump(strlen($document->content));
            $combinedContent .= $document->content;

            if (strlen($combinedContent) >= 750) {
                break;
            }
        }

        $template = <<<EOL
As a helpful historian, I have been asked the question below. I will provide some context found in a local historical art
collection database using a vector query. Please help me reply with a well-formatted answer and offer to get more information
if needed.

Question: {question}
Context: {context}

###


EOL;


        $input_variables = [
            new PromptToken('question', $question),
            new PromptToken('context', $combinedContent)
        ];

        $prompt = new PromptTemplate($input_variables, $template);

        $results = ClientWrapper::setTemperature(0.7)
            ->setTokens(1000)
            ->completions($prompt->format());


        $this->info($results);


    }


}
