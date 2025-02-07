<?php

namespace Database\Factories;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'user_id' => User::inRandomOrder()->first()->id,  // atau
        // 'user_id' => fake()->numberBetween(1, 102),  // karena total user ada 102
        'title' => fake()->sentence(),
        'is_complete' => fake()->boolean(),
    ];
}
}
