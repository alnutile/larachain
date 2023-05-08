<?php

namespace Tests\Feature\Models;

use App\Models\Project;
use App\Models\ResponseType;
use App\ResponseType\ResponseTypeEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_rt() {
        $model = ResponseType::factory()->create();
        $this->assertEquals(ResponseTypeEnum::ChatUi, $model->type);

        $this->assertNotNull($model->project->id);
        $this->assertNotNull($model->project->response_types->first()->id);
    }

    public function test_rt_run() {
        $project = Project::factory()->create();

        $model = ResponseType::factory()->create([
            "project_id" => $project->id,
            "order" => 1
        ]);


    }
}
