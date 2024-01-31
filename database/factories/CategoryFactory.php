<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
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
            'desc' => fake()->sentence(5),
            'type' => fake()->randomElement(['restaurant', 'menu']),
            'image' => fake()->imageUrl(640, 480, 'category', true),
        ];
    }
}
