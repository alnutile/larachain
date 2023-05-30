<?php

namespace App\ResponseType\Types;

use App\Models\Project;
use App\Models\User;
use Facades\App\LLMModels\OpenAi\ClientWrapper;

class ChatApi extends ChatUi
{
    protected function chat(Project $project, User $user, array $messages): string
    {
        return ClientWrapper::nonStreamProjectChat(
            $this->project,
            $this->user,
            $messages);
    }
}
