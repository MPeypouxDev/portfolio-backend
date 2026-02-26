<?php

namespace Database\Factories;

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
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->word(3),
            'description' => $this->faker->sentence(15),
            'status' => $this->faker->randomElement(['published', 'draft', 'archived']),
            'github_url' => 'https://github.com',
            'demo_url' => 'https://demo.com',
            'date_realisation' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'is_featured' => $this->faker->boolean(),
            'order' => $this->faker->numberBetween(1, 10),
            'type' => $this->faker->randomElement(['frontend', 'backend', 'fullstack']),
        ];
    }
}
