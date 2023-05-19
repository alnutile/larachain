<?php

namespace Tests\Feature;

use App\Generators\ResponseType\EnumTransformer;
use App\Generators\ResponseType\GeneratorRepository;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class EnumTransformerTest extends TestCase
{
    public function test_handles_enum()
    {
        $enum = <<<EOD
<?php

namespace App\ResponseType;

enum ResponseTypeEnum: string
{
    //case TemplateType = 'template_type'
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
                $this->assertStringNotContainsString("case FooBar = 'foo_bar';/", $content);
                $this->assertStringContainsString("case EmbedQuestion = 'embed_question'", $content);
                $this->assertStringContainsString('enum ResponseTypeEnum: string', $content);
                $this->assertEquals(1, substr_count($content, 'case FooBar'));

                return true;
            });

        $generator = new GeneratorRepository();
        $generator->setup('Foo Bar', 'Some Response Type', 'Some Description', false);

        $transformer = new EnumTransformer();
        $transformer->handle($generator);
    }
}
