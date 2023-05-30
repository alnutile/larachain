<?php

namespace App\ResponseType\Types;

use App\Models\Project;
use App\Models\ResponseType;
use App\Models\User;
use App\ResponseType\BaseResponseType;
use App\ResponseType\Content;
use App\ResponseType\ContentCollection;
use App\ResponseType\ResponseDto;
use Facades\App\LLMModels\OpenAi\ClientWrapper;

class ChatApi extends ChatUi
{

    protected function chat(Project $project, User $user, array $messages) : string {
        return ClientWrapper::nonStreamProjectChat(
            $this->project,
            $this->user,
            $messages);
    }

}
