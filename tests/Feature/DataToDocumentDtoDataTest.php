<?php

namespace Tests\Feature;

use App\Data\DataToDocumentDtoData;
use App\Source\SourceEnum;
use Illuminate\Support\Str;
use Tests\TestCase;

class DataToDocumentDtoDataTest extends TestCase
{
    public function test_dto()
    {
        $dto = new DataToDocumentDtoData(
            'foobar',
            SourceEnum::ScrapeWebPage,
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
