<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TypeEngin>
 */
class TypeEnginFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = [
            'Grue mobile',
            'Chariot élévateur',
            'Tracteur portuaire',
            'Camion',
            'Élévateur',
        ];

        return [
            'nom' => fake()->unique()->randomElement($types),
        ];
    }
}
