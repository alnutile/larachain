<?php

namespace Tests\Feature;

use App\Generators\ResponseType\EnumTransformer;
use App\Generators\ResponseType\GeneratorRepository;
use App\Generators\ResponseType\RoutesTransformer;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class EnumTransformerTest extends TestCase
{
    public function test_handles_routes()
    {
        $enum = <<<EOD
<?php

namespace App\ResponseType;

enum ResponseTypeEnum: string
{
    case EmbedQuestion = 'embed_question';
    case VectorSearch = 'vector_search';
    case CombineContent = 'combine_content';
    case TrimText = 'trim_text';
    case ChatUi = 'chat_ui';
    case Api = 'api';
EOD;

        File::shouldReceive('get')
            ->andReturn($enum);

        File::shouldReceive('put')
            ->withArgs(function ($filePath, $content) {
                $this->assertStringContainsString("case FooBar = 'foo_bar'", $content);

                return true;
            });

        $generator = new GeneratorRepository();
        $generator->setup('Foo Bar', 'Some Response Type', 'Some Description', false);

        $transformer = new EnumTransformer();
        $transformer->handle($generator);
    }
}
