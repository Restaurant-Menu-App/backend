<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->companySuffix(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'website_url' => fake()->url(),
            'facebook_url' => fake()->url(),
            'address' => fake()->address(),
            'is_active' => 1,
            'open_time' => '09:00',
            'close_time' => '18:00',
            'close_on' => null,
            'desc' => fake()->paragraph(),
            'image' => fake()->imageUrl(640, 480, 'restaurant', true),
            'user_id' => User::all()->random()->id,
        ];
    }
}
