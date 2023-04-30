<?php

namespace Tests\Feature\Models;

use App\Models\Message;
use Tests\TestCase;

class MessageTest extends TestCase
{
    public function test_message_factory()
    {
        $model = Message::factory()->create();
        $this->assertNotNull($model->user->id);
        $this->assertNotNull($model->project->id);
        $this->assertNotNull($model->user->messages->first()->id);

    }
}
