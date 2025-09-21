<?php

namespace Database\Factories;

use App\Models\Engin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assurance>
 */
class AssuranceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dateDebut = fake()->dateTimeBetween('-15 years', 'now');
        $dateFin = (clone $dateDebut)->modify('+'.fake()->numberBetween(1, 12).' months');

        return [
            'compagnie' => fake()->name(),
            'date_debut' => $dateDebut->format('Y-m-d'),
            'date_fin' => $dateFin->format('Y-m-d'),
            'montant' => fake()->randomFloat(2, 100, 10000),
            'engin_id' => Engin::factory()->create()->id,
        ];
    }
}
