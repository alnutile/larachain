<?php

namespace Database\Factories;

use App\Models\Project;
use App\Outbound\OutboundEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outbound>
 */
class OutboundFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => OutboundEnum::ChatUi,
            'project_id' => Project::factory(),
            'active' => 1,
        ];
    }

    public function api()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => OutboundEnum::Api,
            ];
        });
    }

    public function chatUi()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => OutboundEnum::ChatUi,
            ];
        });
    }
}
