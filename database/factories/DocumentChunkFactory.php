<?php

namespace Database\Factories;

use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DocumentChunk>
 */
class DocumentChunkFactory extends Factory
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
            'guid' => fake()->uuid(),
            'content' => fake()->sentence(10),
            'token_count' => fake()->randomDigitNotZero(),
            'document_id' => Document::factory(),
        ];
    }



}
