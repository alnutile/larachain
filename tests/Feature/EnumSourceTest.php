<?php

namespace Tests\Feature;

use App\Generators\Source\EnumSource;
use App\Generators\Source\GeneratorRepository;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class EnumSourceTest extends TestCase
{
    public function test_handles_enum()
    {
        $enum = <<<EOD
<?php

namespace App\Source;

enum SourceEnum: string
{
    //case TemplateType = 'template_type'
    case WebFile = 'web_file';
EOD;

        File::shouldReceive('get')
            ->andReturn($enum);

        File::shouldReceive('put')
            ->withArgs(function ($filePath, $content) {
                $this->assertStringContainsString("case FooBar = 'foo_bar'", $content);
                $this->assertStringNotContainsString("case FooBar = 'foo_bar';/", $content);
                $this->assertStringContainsString("case WebFile = 'web_file'", $content);
                $this->assertEquals(1, substr_count($content, 'case FooBar'));

                return true;
            });

        $generator = new GeneratorRepository();
        $generator->setup('Foo Bar', 'Some Response Type', 'Some Description', false);

        $transformer = new EnumSource();
        $transformer->handle($generator);
    }
}
