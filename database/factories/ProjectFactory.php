<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'team_id' => Team::factory(),
            'active' => 1,
            'slug' => fake()->slug(),
            'web_page' => fake()->boolean(),
            'private' => fake()->boolean(),
            'meta_data' => [
                'password' => 'bar',
            ],
        ];
    }

    public function webShared()
    {
        return $this->state(function (array $attributes) {
            return [
                'slug' => 'foobar',
                'web_page' => 1,
                'private' => 1,
                'meta_data' => [
                    'password' => null,
                ],
            ];
        });
    }
}
