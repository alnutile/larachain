<?php

namespace Tests\Feature;

use App\Jobs\ProcessSourceTransformers;
use App\Models\Source;
use App\Source\Types\WebHook;
use Illuminate\Support\Facades\Queue;
use Ramsey\Uuid\Uuid;
use Tests\TestCase;

class WebHookTest extends TestCase
{
    public function test_makes_document()
    {
        Queue::fake();
        $data = [
            'test' => Uuid::uuid4()->toString(),
        ];

        $source = Source::factory()
            ->webHook()
            ->create();

        $webFileSourceType = new WebHook($source);
        $webFileSourceType->setPayload($data);
        $this->assertDatabaseCount('documents', 0);
        $document = $webFileSourceType->handle();
        $this->assertDatabaseCount('documents', 1);

        $this->assertNotNull($document->content);

        $document = $webFileSourceType->handle();
        $this->assertDatabaseCount('documents', 1);
        $this->assertStringContainsString('.json', $document->guid);

        Queue::assertPushed(ProcessSourceTransformers::class);

    }
}
