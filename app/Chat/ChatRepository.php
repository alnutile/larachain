<?php

namespace App\Chat;

use App\LLMModels\OpenAi\ClientWrapper;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;

class ChatRepository
{

    public function handle(Project $project, User $user, string $question) {

        /**
         * @TODO is this the first one???
         */

        $message = Message::create([
            'user_id' => $user->id,
            'project_id' => $project->id,
            "content" => $question,
            'role' => 'user'
        ]);

        $messages = Message::where("user_id", $user->id)
            ->where("project_id", $project->id)
            ->pluck([
                'role',
                'content'
            ]);

        //make prompt

        $fullResponse = ClientWrapper::chat($messages);

        Message::create([
            'role' => 'system',
            'user_id' => $user->id,
            'project_id' => $project->id,
            'content' => $fullResponse,
        ]);

        return true;


    }
}
