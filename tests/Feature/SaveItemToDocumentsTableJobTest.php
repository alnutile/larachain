<?php

namespace Tests\Feature;

use App\Data\DataToDocumentDtoData;
use App\Ingress\IngressTypeEnum;
use App\Jobs\SaveItemToDocumentsTableJob;
use App\Models\Project;
use Tests\TestCase;

class SaveItemToDocumentsTableJobTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_job_adds_to_db(): void
    {
        $project = Project::factory()->create();
        $dto = new DataToDocumentDtoData(
            'foobar',
            IngressTypeEnum::WebScrape,
            'foobaz',
            $project->id,
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
        $this->assertDatabaseCount('documents', 0);
        $job = new SaveItemToDocumentsTableJob($dto);
        $job->handle();
        $this->assertDatabaseCount('documents', 1);

    }
}
