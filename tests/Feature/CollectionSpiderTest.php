<?php

namespace Tests\Feature;

use App\Models\Source;
use App\Spiders\CollectionSpider;
use Illuminate\Support\Facades\Queue;
use RoachPHP\Roach;
use Tests\TestCase;

class CollectionSpiderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->runner = Roach::fake();
    }

    public function test_running()
    {
        Queue::fake();

        $source = Source::factory()->create();
        $this->artisan('larachain:source', [
            'source_id' => $source->id,
        ]);
        $this->runner->assertRunWasStarted(CollectionSpider::class);
    }

    protected function tearDown(): void
    {
        Roach::restore();
        parent::tearDown();
    }
}
