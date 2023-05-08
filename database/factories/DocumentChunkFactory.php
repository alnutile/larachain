<?php

namespace Database\Factories;

use App\Ingress\StatusEnum;
use App\Models\Document;
use App\Models\Source;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DocumentChunk>
 */
class DocumentChunkFactory extends Factory
{
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
            'document_id' => Document::factory(),
        ];
    }
}
