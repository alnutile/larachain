<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
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
            'role' => 'user', //user, agent
            'content' => fake()->sentence(4, true),
            'user_id' => User::factory(),
            'project_id' => Project::factory(),
            'token_count' => fake()->randomDigitNotZero(),
        ];
    }

    public function assistantMessage()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'assistant',
            ];
        });
    }

    public function systemMessage()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'system',
            ];
        });
    }
}
