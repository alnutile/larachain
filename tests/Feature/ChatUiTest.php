<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\ResponseType;
use App\ResponseType\ResponseDto;
use App\ResponseType\Types\ChatUi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ChatUiTest extends TestCase
{

    public function test_can_makes_messages() {
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
            'response' => "Foobar",
        ]);

        $rt = ResponseType::factory()
            ->chatUi()
            ->create([
                'prompt_token' => [
                    'system' => $template
                ]
            ]);

        $this->assertDatabaseCount("messages", 1);
        $chatUi  = new ChatUi($rt->project, $responseDto);
        $chatUi->handle($rt);
        $this->assertDatabaseCount("messages", 2);
        $this->assertNotNull(Message::whereRole("system")->first());
    }
}
