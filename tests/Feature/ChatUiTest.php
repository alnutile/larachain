<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\Outbound;
use App\Models\Project;
use App\Models\ResponseType;
use App\ResponseType\ResponseDto;
use App\ResponseType\Types\ChatUi;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use Tests\TestCase;

class ChatUiTest extends TestCase
{
    public function test_can_make_messages()
    {
        ClientWrapper::shouldReceive('projectChat')
            ->once()
            ->andReturn('Foo bar');

        $template = <<<'EOL'
As a helpful historian, I have been asked the question below. I will provide some context found in a local historical art
collection database using a vector query. Please help me reply with a well-formatted answer and offer to get more information
if needed.
Context: {context}
###


EOL;
        $message = Message::factory()->create();

        $responseDto = ResponseDto::from([
            'message' => $message,
            'role' => 'user',
            'response' => 'Foobar',
        ]);

        $rt = ResponseType::factory()
            ->chatUi()
            ->create([
                'prompt_token' => [
                    'system' => $template,
                ],
            ]);

        $this->assertDatabaseCount('messages', 1);
        $chatUi = new ChatUi($rt->outbound->project, $responseDto);
        $chatUi->handle($rt);
        $this->assertDatabaseCount('messages', 3);
        $this->assertNotNull(Message::whereRole('system')->first());
        $this->assertNotNull(Message::whereRole('assistant')->first());
    }

    public function test_makes_assistant_message()
    {

        ClientWrapper::shouldReceive('projectChat')
            ->once()
            ->andReturn('Foo bar');

        $project = Project::factory()->create();
        $outbound = Outbound::factory()->create([
            'project_id' => $project->id,
        ]);
        $message = Message::factory()->create([
            'project_id' => $project->id,
        ]);

        $message = Message::factory()->systemMessage()->create([
            'project_id' => $project->id,
        ]);

        $responseDto = ResponseDto::from([
            'message' => $message,
            'role' => 'user',
            'response' => 'Foobar',
        ]);

        $rt = ResponseType::factory()
            ->chatUi()
            ->create([
                'outbound_id' => $outbound->id,
            ]);

        $this->assertDatabaseCount('messages', 2);
        $chatUi = new ChatUi($project, $responseDto);
        $chatUi->handle($rt);
        $this->assertDatabaseCount('messages', 3);
        $this->assertNotNull(Message::whereRole('assistant')->first());
    }
}
