<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Transformer;
use App\Transformer\TransformerEnum;
use App\Transformer\Types\CsvTransformer;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class CsvTransformerTest extends TestCase
{
    use SharedSetupForPdfFile;

    public function test_parses()
    {
        $document = Document::factory()->csv()->create();

        $transformerModel = Transformer::factory()->create([
            'type' => TransformerEnum::CsvTransformer,
        ]);

        $destination = storage_path(
            sprintf('app/projects/%d/sources/%d',
                $transformerModel->project_id,
                $document->source_id)
        );

        if (! File::exists($destination)) {
            File::makeDirectory($destination, 0755, true, true);
        }

        File::copy(
            base_path('tests/fixtures/recipes_small.csv'),
            $destination.'/recipes.csv'
        );

        $transformer = new CsvTransformer($document);
        $this->assertDatabaseCount('document_chunks', 0);
        $transformer->handle($transformerModel);
        $this->assertDatabaseCount('document_chunks', 7);

        $content = $document->refresh()->document_chunks->first()->content;

        $this->assertNotNull($content);

    }
}
