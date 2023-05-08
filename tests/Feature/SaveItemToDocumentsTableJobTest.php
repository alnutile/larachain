<?php

namespace Tests\Feature;

use App\Data\DataToDocumentDtoData;
use App\Jobs\SaveItemToDocumentsTableJob;
use App\Models\Source;
use Tests\TestCase;

class SaveItemToDocumentsTableJobTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_job_adds_to_db(): void
    {
        $source = Source::factory()->create();
        $dto = new DataToDocumentDtoData(
            'foobar',
            'foobaz',
            $source->id);
        $this->assertDatabaseCount('documents', 0);
        $job = new SaveItemToDocumentsTableJob($dto);
        $job->handle();
        $this->assertDatabaseCount('documents', 1);

    }
}
