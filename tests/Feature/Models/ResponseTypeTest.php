<?php

namespace Tests\Feature\Models;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\Document;
use App\Models\Project;
use App\Models\ResponseType;
use App\Models\User;
use App\ResponseType\ResponseDto;
use App\ResponseType\ResponseTypeEnum;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResponseTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory_rt()
    {
        $model = ResponseType::factory()->create();
        $this->assertEquals(ResponseTypeEnum::ChatUi, $model->type);

        $this->assertNotNull($model->project->id);
        $this->assertNotNull($model->project->response_types->first()->id);
    }

}
