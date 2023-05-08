<?php

namespace Tests\Feature;

use App\Data\DataToDocumentDtoData;
use App\Ingress\IngressTypeEnum;
use App\Source\Dtos\SourceToDocumentDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class SourceToDocumentDtoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $dto = new SourceToDocumentDto(
            'foobar',
            IngressTypeEnum::WebScrape,
            'foobaz',
            'project_id_'.Str::random(),
            [
                'Maker',
                'Culture',
                'Title',
                'Date Made',
                'Materials',
                'Measurements',
                'Accession Number',
                'Museum Collection',
                'Label Text',
                'Tags',
            ]);
        $this->assertNotNull($dto->content);
    }
}
