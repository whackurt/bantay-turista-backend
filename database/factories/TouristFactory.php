<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tourist>
 */
class TouristFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'qr_code' => fake()->numberBetween(100000, 2147483647),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'address' => fake()->address,
            'gender' => fake()->randomElement(['Male', 'Female']),
            'nationality' => fake()->randomElement(['Korean', 'Japanese', 'American', 'Argentinian']),
            'photo_url' => fake()->url(),
            'contact_number' => fake()->phoneNumber(),
            'user_id' => User::factory()
        ];
    }
}