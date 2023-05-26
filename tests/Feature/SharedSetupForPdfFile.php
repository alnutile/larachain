<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Source;
use Illuminate\Support\Facades\File;

trait SharedSetupForPdfFile
{
    public Document $document;

    public Source $source;


    protected function webPageToText() {
        $source = Source::factory()
            ->webDocumentMetaData()
            ->create();

        $document = Document::factory()->create([
            'source_id' => $source->id,
            'guid' => 'example.html',
        ]);

        $from = base_path('tests/fixtures/example.html');

        if (! File::exists($document->directoryForFile())) {
            File::makeDirectory(
                $document->directoryForFile(),
                0755,
                true
            );
            File::copy(
                $from,
                $document->pathToFile()
            );
        }

        $this->document = $document;
        $this->source = $source;
    }

    protected function webFileDownloadSetup() {
        $source = Source::factory()
            ->webFileMetaData()
            ->create();

        $document = Document::factory()->create([
            'source_id' => $source->id,
            'guid' => 'example.pdf',
        ]);

        $from = base_path('tests/fixtures/example.pdf');

        if (! File::exists($document->pathToFile())) {
            File::makeDirectory(
                sprintf(storage_path('app/projects/%d/sources/%d'),
                    $source->project_id,
                    $source->id),
                0755,
                true
            );
            File::copy(
                $from,
                $document->pathToFile()
            );
        }

        $this->document = $document;
        $this->source = $source;
    }
}
