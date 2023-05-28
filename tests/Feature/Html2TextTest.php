<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Transformer;
use App\Transformers\TransformerTypeEnum;
use App\Transformers\Types\Html2Text;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Html2TextTest extends TestCase
{
    use SharedSetupForPdfFile;

    public function test_parses()
    {
        $document = Document::factory()->html()->create();

        $transformerModel = Transformer::factory()->create([
            'type' => TransformerTypeEnum::Html2Text,
        ]);

        Storage::fake('projects');

        $transformer = new Html2Text($document);
        $this->assertDatabaseCount('document_chunks', 0);
        $transformer->handle($transformerModel);
        $this->assertDatabaseCount('document_chunks', 1);

        $document = Document::first();
        $content = $document->content;

        $this->assertNotNull($content);

    }
}
