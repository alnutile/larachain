<?php

namespace Database\Factories;

use App\Ingress\StatusEnum;
use App\Models\Source;
use App\Source\SourceEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    use HasEmbedDataTrait;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'token_count' => fake()->randomDigitNotZero(),
            'status' => StatusEnum::Pending,
            'type' => SourceEnum::WebHook,
            'guid' => fake()->uuid(),
            'content' => fake()->sentence(10),
            'source_id' => Source::factory(),
            'meta_data' => [],
        ];
    }

    public function csv()
    {
        return $this->state(function (array $attributes) {
            return [
                'content' => File::get(base_path('tests/fixtures/recipes_small.csv')),
                'guid' => 'recipes.csv',
            ];
        });
    }

    public function html()
    {
        return $this->state(function (array $attributes) {
            return [
                'content' => fake()->randomHtml(),
                'guid' => 'foo.html',
            ];
        });
    }
}
