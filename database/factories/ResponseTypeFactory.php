<?php

namespace Database\Factories;

use App\Models\Project;
use App\ResponseType\ResponseTypeEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ResponseType>
 */
class ResponseTypeFactory extends Factory
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
            'type' => ResponseTypeEnum::ChatUi,
            'project_id' => Project::factory(),
        ];
    }

    public function vectorSearch()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ResponseTypeEnum::VectorSearch,
            ];
        });
    }

    public function apiTranformer()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ResponseTypeEnum::Api,
            ];
        });
    }
}
