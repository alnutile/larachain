<?php

namespace Database\Factories;

use App\Models\Source;
use App\Ingress\StatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'guid' => fake()->uuid(),
            'content' => fake()->sentence(10),
            'source_id' => Source::factory(),
            'meta_data' => [],
        ];
    }

    public function html()
{
    return $this->state(function (array $attributes) {
        return [
            'content' => fake()->randomHtml(),
            'guid' => "foo.html"
        ];
    });
}
}
