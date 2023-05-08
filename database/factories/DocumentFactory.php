<?php

namespace Database\Factories;

use App\Ingress\IngressTypeEnum;
use App\Ingress\StatusEnum;
use App\Models\Project;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
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

    public function withEmbedData()
    {

        return $this->state(function (array $attributes) {
            $embeddings = get_fixture('embedding_response.json');

            return [
                'embedding' => data_get($embeddings, 'data.0.embedding'),
            ];
        });
    }
}
