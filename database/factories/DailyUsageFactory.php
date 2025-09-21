<?php

namespace Database\Factories;

use App\Models\Engin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DailyUsage>
 */
class DailyUsageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Date d'usage entre -7 mois et aujourd'hui
        $dateUsage = fake()->dateTimeBetween('-7 months', 'now')->format('Y-m-d');

        // Heure sortie : même jour, entre 07:00 et 09:00 (début de journée)
        $heureSortie = fake()->dateTimeBetween($dateUsage.' 07:00:00', $dateUsage.' 09:00:00');

        // Heure retour (optionnelle) : entre heure sortie et 17:00 (fin journée)
        $heureRetour = fake()->boolean(75) // 75% de chances que l'engin soit rentré
            ? fake()->dateTimeBetween($heureSortie, $dateUsage.' 17:00:00')
            : null;

        $compteurHSortie = fake()->randomFloat(2, 1000, 2000);
        $compteurKmSortie = fake()->randomFloat(2, 10000, 20000);

        $compteurHRetour = $heureRetour
            ? $compteurHSortie + fake()->randomFloat(2, 1, 10)
            : null;
        $compteurKmRetour = $heureRetour
            ? $compteurKmSortie + fake()->randomFloat(2, 10, 100)
            : null;

        return [
            'date_usage' => $dateUsage,
            'site_destination' => $this->faker->city(),
            'is_returned' => $heureRetour !== null,
            'observation_depart' => $this->faker->optional()->sentence(),
            'heure_sortie' => $heureSortie,
            'heure_retour' => $heureRetour,
            'compteur_h_sortie' => $compteurHSortie,
            'compteur_km_sortie' => $compteurKmSortie,
            'compteur_h_retour' => $compteurHRetour,
            'compteur_km_retour' => $compteurKmRetour,
            'observation_retour' => $heureRetour ? $this->faker->optional()->sentence() : null,
            'carburant_rempli_l' => $heureRetour ? $this->faker->randomFloat(2, 0, 50) : null,
            'engin_id' => Engin::factory(),
            'operateur_id' => User::factory()->state([
                'role' => 'operateur',
            ]),
            'agent_suivi_id' => User::factory()->state([
                'role' => 'agent_suivi',
            ]),
        ];

    }
}
