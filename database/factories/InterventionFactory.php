<?php

namespace Database\Factories;

use App\Models\Maintenance;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Intervention>
 */
class InterventionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'maintenance_id' => Maintenance::factory(),
            'date_debut' => fake()->dateTime(),
            'date_fin' => fake()->dateTimeBetween('now', '+5 days'),
            'etat_post_maintenance' => fake()->randomElement(['fonctionnel', 'non fonctionnel']),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
