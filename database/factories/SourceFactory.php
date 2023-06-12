<?php

namespace Database\Factories;

use App\Models\Project;
use App\Source\SourceEnum;
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
                SourceEnum::WebFile,
            ]),
            'created_at' => fake()->dateTime,
            'updated_at' => fake()->dateTime,
        ];
    }

    public function fileUpload()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => SourceEnum::FileUploadSource,
                'meta_data' => [
                    'file_name' => 'test.csv',
                ],
            ];
        });
    }

    public function webHook()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => SourceEnum::WebHook,
                'meta_data' => [],
            ];
        });
    }

    public function scrapeWebPage()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => SourceEnum::ScrapeWebPage,
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
                'type' => SourceEnum::WebFile,
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
