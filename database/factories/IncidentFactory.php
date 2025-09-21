<?php

namespace Database\Factories;

use App\Models\DailyUsage;
use App\Models\Engin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incident>
 */
class IncidentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date_signalement' => fake()->dateTimeBetween('-1 year', 'now'),
            'description' => fake()->sentence(),
            'niveau_gravite' => fake()->randomElement(['critique', 'majeur', 'mineur']),
            'engin_id' => Engin::factory(),
            'operateur_id' => User::factory()->state([
                'role' => 'operateur',
            ]),
            'resolu' => fake()->boolean(),
            'date_resolution' => fake()->date(),
            'daily_usage_id' => DailyUsage::factory(),
        ];
    }
}
