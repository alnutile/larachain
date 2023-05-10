<?php

namespace Tests\Feature\Models;

use App\Models\ResponseType;
use App\ResponseType\ResponseTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResponseTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_rt()
    {
        $model = ResponseType::factory()->create();
        $this->assertEquals(ResponseTypeEnum::ChatUi, $model->type);

        $this->assertNotNull($model->outbound->id);
        $this->assertNotNull($model->outbound->response_types->first()->id);
    }
}
