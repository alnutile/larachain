<?php

namespace Tests\Feature\Models;

use App\Models\Source;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_source_factory()
    {
        $model = Source::factory()->create();
        $this->assertNotNull($model->meta_data);
    }
}
