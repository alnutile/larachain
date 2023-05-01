<?php

namespace App\Tools;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\Document;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Pgvector\Laravel\Vector;
use Sundance\LarachainPromptTemplates\Prompts\PromptToken;
use Sundance\LarachainPromptTemplates\PromptTemplate;

class ChatRepository
{

    protected Project $project;
    protected User $user;


    public function handle(Project $project, User $user, string $question) {

        $this->user = $user;
        $this->project = $project;

        /**
         * @TODO
         * this stuff should be extracted out or this
         * Repo made into a pluggable "Resource" or "Tool"
         */
        $documents = $this->makeEmbeddingAndGetRelatedDocuments($question);

        $combinedContent = $this->combineContent($documents);

        /**
         * @TODO is this the first one???
         */
        if(!Message::query()
            ->select(['role', 'content'])
            ->where("user_id", $user->id)
            ->where("project_id", $project->id)->exists()) {

            $content = $this->getFirstQuestionPrompt($combinedContent);
            $this->makeSystemMessage($content->format());
            $this->makeUserMessage($question);
        } else {
            $content = $this->makeFollowUpQuestionPrompt($combinedContent, $question);
            $this->makeAssistentMessage($content->format());
        }

        $messages = Message::query()
            ->select(['role', 'content'])
            ->where("user_id", $user->id)
            ->where("project_id", $project->id)
            ->get();

        $fullResponse = ClientWrapper::chat($messages->toArray());

        $this->makeAssistentMessage($fullResponse);

        return true;

    }

    protected function combineContent(Collection $documents) : string
    {
        $combinedContent = '';

        foreach ($documents as $document) {
            $combinedContent .= $document->content;
            if (strlen($combinedContent) >= 750) {
                break;
            }
        }

        return $combinedContent;
    }

    protected function getFirstQuestionPrompt(string $combinedContent) : PromptTemplate
    {
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

        return new PromptTemplate($input_variables, $template);
    }

    protected function makeFollowUpQuestionPrompt(string $combinedContent, string $question): PromptTemplate
    {
        $template = <<<'EOL'
As a helpful historian, I have been asked the follow up question below. I will provide some context found in a local historical art
collection database using a vector query. Please help me reply with a well-formatted answer and offer to get more information
if needed. The users question is included as well.
Context: {context}
Question: {question}
###


EOL;

        $input_variables = [
            new PromptToken('context', $combinedContent),
            new PromptToken('question', $question),
        ];

        return new PromptTemplate($input_variables, $template);
    }

    protected function makeEmbeddingAndGetRelatedDocuments(string $question) : Collection
    {
        /** @var EmbeddingsResponseDto $questionEmbedded */
        $questionEmbedded = ClientWrapper::getEmbedding($question);
        $query = new Vector($questionEmbedded->embedding);

        return Document::query()
            ->where("project_id", $this->project->id)
            ->selectRaw('embedding <-> ? as distance, content', [$query])
            ->orderByRaw('distance')
            ->get();

    }

    protected function makeSystemMessage(string $content) : void
    {
        Message::create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            "content" => $content,
            'role' => 'system'
        ]);
    }

    protected function makeAssistentMessage(string $content) : void
    {
        Message::create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            "content" => $content,
            'role' => 'assistant'
        ]);
    }

    protected function makeUserMessage(string $question)
    {
        Message::create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            "content" => $question,
            'role' => 'user'
        ]);
    }


}
