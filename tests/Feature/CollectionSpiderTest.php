<?php

namespace Tests\Feature;

use App\Models\Project;
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

        $project = Project::factory()->create();
        $this->artisan('larachain:run_collection', [
            'project_id' => $project->id,
        ]);
        $this->runner->assertRunWasStarted(CollectionSpider::class);
    }

    protected function tearDown(): void
    {
        Roach::restore();
        parent::tearDown();
    }
}
