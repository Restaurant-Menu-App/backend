<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'price' => fake()->randomFloat(0, 100, 20000),
            'desc' => fake()->text,
            'priority' => fake()->randomElement([1, 2, 3]),
            'category_id' => Category::all()->random()->id,
            'restaurant_id' => Restaurant::all()->random()->id,
        ];
    }
}
