<?php

namespace Tests\Feature;

use App\Data\Filters;
use App\Models\Message;
use App\ResponseType\Content;
use App\ResponseType\ContentCollection;
use App\ResponseType\ResponseDto;
use Tests\TestCase;

class ResponseDtoTest extends TestCase
{
    public function test_dto()
    {
        $dto = ResponseDto::from([
            'message' => Message::factory()->create(),
            'response' => ContentCollection::from([
                'contents' => [
                    Content::from(['content' => 'Foobar']),
                ],
            ]),
        ]);

        $this->assertNotEmpty($dto->message);
    }

    public function test_dto_with_filter()
    {
        $dto = ResponseDto::from([
            'message' => Message::factory()->create(),
            'response' => ContentCollection::from([
                'contents' => [
                    Content::from(['content' => 'Foobar']),
                ],
            ]),
            'filters' => Filters::from(['sources' => [1, 2]]),
        ]);

        $this->assertNotEmpty($dto->filters);
    }
}
