<?php

namespace Tests\Feature;

use App\Ingress\IngressTypeEnum;
use App\Models\Source;
use App\Source\Dtos\SourceToDocumentDto;
use Illuminate\Support\Str;
use Tests\TestCase;

class SourceToDocumentDtoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_source_to_doc(): void
    {
        $dto = new SourceToDocumentDto(
            'foobar',
            'foobaz',
            Source::factory()->create()->id);
        $this->assertNotNull($dto->content);
    }
}
