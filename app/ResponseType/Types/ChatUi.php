<?php

namespace App\ResponseType\Types;

use App\Models\Message;
use App\Models\ResponseType;
use App\Models\User;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use Sundance\LarachainPromptTemplates\Prompts\PromptToken;
use Sundance\LarachainPromptTemplates\PromptTemplate;

class ChatUi extends BaseResponseType
{
    protected User $user;

    protected Message $message;

    protected ResponseType $responseType;

    protected string $content;

    public function handle(ResponseType $responseType): ResponseDto
    {
        $this->user = $this->response_dto->message->user;

        $this->content = $this->response_dto->response;

        $this->responseType = $responseType;

        $this->message = $this->response_dto->message;

        if ($this->noSystemMessage()) {
            $content = $this->getFirstQuestionPrompt();
            $systemMessage = $this->makeSystemMessage($content->format());
            $messages = Message::query()
                ->select(['role', 'content'])
                ->where('user_id', $this->user->id)
                ->where('project_id', $this->project->id)
                ->whereRole('user')
                ->get();

            $messages->prepend($systemMessage);


        } else {
            $content = $this->makeFollowUpQuestionPrompt();
            $this->makeAssistantMessage($content->format());
            $systemMessage = Message::query()
                ->select(['role', 'content'])
                ->where('user_id', $this->user->id)
                ->where('project_id', $this->project->id)
                ->whereRole('system')
                ->first();
            $messages = Message::query()
                ->select(['role', 'content'])
                ->where('user_id', $this->user->id)
                ->where('project_id', $this->project->id)
                ->whereIn("role", ['user', 'assistant'])
                ->latest()
                ->take(4)
                ->get();
            $messages->prepend($systemMessage);
        }


        $fullResponse = ClientWrapper::projectChat(
            $this->project,
            $this->user,
            $messages->toArray());
        $this->makeAssistantMessage($fullResponse);

        return ResponseDto::from(
            [
                'message' => $this->response_dto->message->refresh(),
                'response' => null,
            ]
        );
    }

    protected function getFirstQuestionPrompt(): PromptTemplate
    {
        $template = $this->responseType->prompt_token['system'];

        $input_variables = [
            new PromptToken('context', $this->content),
        ];

        return new PromptTemplate($input_variables, $template);
    }

    protected function makeFollowUpQuestionPrompt(): PromptTemplate
    {
        $template = $this->responseType->prompt_token['assistant'];

        $input_variables = [
            new PromptToken('context', $this->content),
            new PromptToken('question', $this->message->content),
        ];

        return new PromptTemplate($input_variables, $template);
    }

    protected function makeSystemMessage(string $content): message
    {
        return Message::create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'content' => $content,
            'role' => 'system',
        ]);
    }

    protected function makeAssistantMessage(string $content): Message
    {
        return Message::create([
            'user_id' => $this->user->id,
            'project_id' => $this->project->id,
            'content' => $content,
            'role' => 'assistant',
        ]);
    }

    private function noSystemMessage(): bool
    {
        return ! Message::query()

             ->select(['role', 'content'])
            ->where('user_id', $this->user->id)
            ->where('project_id', $this->project->id)
            ->where('role', 'system')
            ->exists();
    }
}
