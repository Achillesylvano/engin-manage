<?php

namespace Database\Factories;

use App\Models\Engin;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Maintenance>
 */
class MaintenanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['corrective', 'préventive']),
            'description' => fake()->sentence(),
            'date_planifiee' => fake()->dateTimeBetween('+2 days', '+6 months'),
            'statut' => fake()->randomElement(['planifiee', 'en cours', 'terminee', 'annulee']),
            'engin_id' => Engin::factory(),
            'technicien_id' => User::factory()->state([
                'role' => 'technicien',
            ]),
            'incident_id' => fake()->optional()->randomElement([null, Incident::factory()]),
            'responsable_id' => User::factory()->state([
                'role' => 'responsable_flotte',
            ]),
        ];
    }
}
