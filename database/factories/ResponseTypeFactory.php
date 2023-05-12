<?php

namespace Database\Factories;

use App\Models\Outbound;
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
            'meta_data' => [],
            'type' => ResponseTypeEnum::ChatUi,
            'outbound_id' => Outbound::factory(),
        ];
    }

    public function trimText()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ResponseTypeEnum::TrimText,
                'meta_data' => []
            ];
        });
    }

    public function combineContent()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ResponseTypeEnum::CombineContent,
                'meta_data' => [
                    'token_limit' => 750
                    ]
            ];
        });
    }

    public function vectorSearch()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ResponseTypeEnum::VectorSearch,
            ];
        });
    }

    public function chatUi()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => ResponseTypeEnum::ChatUi,
                'prompt_token' => [
                    'assistant' => 'message here',
                    'system' => 'message here',
                ],
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
