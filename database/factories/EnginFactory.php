<?php

namespace Database\Factories;

use App\Enums\EnginCarburant;
use App\Enums\EnginStatus;
use App\Models\TypeEngin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Engin>
 */
class EnginFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'designation' => fake()->name(),
            'marque' => fake()->company(),
            'modele' => fake()->word(),
            'numero_serie' => fake()->unique()->bothify('??-####'),
            'compteur_h' => 0,
            'compteur_km' => 0,
            'capacite_reservoir' => fake()->randomFloat(2, 50, 500),
            'etat' => fake()->randomElement(EnginStatus::cases()),
            'type_carburant' => fake()->randomElement(EnginCarburant::cases()),
            'date_acquisition' => fake()->dateTimeBetween('-5 years', 'now'),
            'type_engin_id' => TypeEngin::inRandomOrder()->first()->id,
        ];
    }
}
