<?php

namespace App\Transformers;

use App\Models\Document;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use Sundance\LarachainPromptTemplates\Prompts\PromptToken;
use Sundance\LarachainPromptTemplates\PromptTemplate;

class HtmlToTextTransformer
{
    public function handle(Document $document): Document
    {
        if ($document->meta_data) {
            $template = <<<'EOL'
The is content in HTML that I would like you to grab the following
info for me:
Content: {content}
Labels:
{labels}

###


EOL;
            $input_variables = [
                new PromptToken('labels',
                    implode("\n", $document->meta_data)),
                new PromptToken('content', $document->content),
            ];
            $prompt = new PromptTemplate($input_variables, $template);

        } else {

            $template = <<<'EOL'
This is HTML can you please convert it to markdown text
Content: {content}

###


EOL;
            $input_variables = [
                new PromptToken('content', $document->content),
            ];
            $prompt = new PromptTemplate($input_variables, $template);

        }

        $results = ClientWrapper::setTemperature(0.7)
            ->setTokens(2047)
            ->completions($prompt->format());
        $document->content = $results;
        $document->save();

        return $document;
    }
}
