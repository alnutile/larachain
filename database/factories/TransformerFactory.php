<?php

namespace Database\Factories;

use App\Models\Project;
use App\Transformer\TransformerEnum;
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
            'type' => TransformerEnum::PdfTransformer,
            'project_id' => Project::factory(),
        ];
    }

    public function embed()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => TransformerEnum::EmbedTransformer,
            ];
        });
    }

    public function json()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => TransformerEnum::JsonTransformer,
            ];
        });
    }

    public function csvTransformer()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => TransformerEnum::CsvTransformer,
            ];
        });
    }

    public function pdfTranformer()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => TransformerEnum::PdfTransformer,
            ];
        });
    }

    public function html2text()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => TransformerEnum::Html2Text,
            ];
        });
    }
}
