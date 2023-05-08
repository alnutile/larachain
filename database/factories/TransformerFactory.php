<?php

namespace Database\Factories;

use App\Models\Project;
use App\Transformers\TransformerTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tranformer>
 */
class TransformerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order' => fake()->randomDigitNotZero(),
            'prompt_token' => [],
            'type' => TransformerTypeEnum::PdfTransformer,
            'project_id' => Project::factory(),
        ];
    }

    public function pdfTranformer()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => TransformerTypeEnum::PdfTransformer,
            ];
        });
    }
}
