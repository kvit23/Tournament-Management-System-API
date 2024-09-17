<?php

namespace Database\Factories;

use App\Models\Games;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tournament>
 */
class TournamentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'description' => fake()->text,
            'games_id' => Games::factory(),
            'max_participants' => fake()->numberBetween(80 , 150),
            'user_id' => User::factory()->state(['is_admin' => 1]),
            'winner_id' => User::factory(),
            'status' => fake()->randomElement(['upcoming','started','finished']),
            'start_date' => fake()->dateTimeBetween('+1 days', '+1 month'),
            'end_date' => fake()->dateTimeBetween('+1 month', '+2 month'),
        ];
    }
}
