<?php

namespace Tests\Feature;

use App\Models\Source;
use App\Source\Types\FileUploadSource;
use Tests\TestCase;

class FileUploadSourceTest extends TestCase
{
    public function test_makes_document()
    {
        $source = Source::factory()->fileUpload()->create();

        $type = new FileUploadSource($source);

        $this->assertDatabaseCount('documents', 0);
        $type->handle();

        $this->assertDatabaseCount('documents', 1);
    }

    public function test_makes_document_once()
    {
        $source = Source::factory()->fileUpload()->create();
        $type = new FileUploadSource($source);
        $type->handle();
        $this->assertDatabaseCount('documents', 1);
        $type->handle();
        $this->assertDatabaseCount('documents', 1);
    }
}
