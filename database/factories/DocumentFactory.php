<?php

namespace Database\Factories;

use App\Ingress\IngressTypeEnum;
use App\Ingress\StatusEnum;
use App\Models\Project;
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
            "token_count" => fake()->randomDigitNotZero(),
            "status" => StatusEnum::Pending,
            "type" => IngressTypeEnum::WebScrape,
            "guid" => fake()->uuid(),
            'project_id' => Project::factory(),
            'meta_data' => [
                'Maker',
                'Culture',
                'Title',
                'Date Made',
                'Materials',
                'Measurements',
                'Accession Number',
                'Museum Collection',
                'Label Text',
                'Tags',
            ],
        ];
    }
}
