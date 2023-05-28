<?php

namespace Database\Factories;

use App\Models\Project;
use App\Source\SourceTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Source>
 */
class SourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word,
            'description' => fake()->text,
            'meta_data' => [
                'key' => fake()->word,
                'value' => fake()->sentence,
            ],
            'project_id' => Project::factory(),
            'order' => fake()->numberBetween(1, 10),
            'type' => fake()->randomElement([
                SourceTypeEnum::WebFile,
            ]),
            'created_at' => fake()->dateTime,
            'updated_at' => fake()->dateTime,
        ];
    }

    public function scrapeWebPage()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => SourceTypeEnum::ScrapeWebPage,
                'meta_data' => [
                    'url' => 'https://wikipedia.org/wiki/Laravel',
                ],
            ];
        });
    }

    public function webFileMetaData()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => SourceTypeEnum::WebFile,
                'meta_data' => [
                    'url' => 'https://wikipedia.com/foo.pdf',
                    'username' => 'foo',
                    'password' => 'bar',
                    'auth' => 'basic',
                ],
            ];
        });
    }
}
