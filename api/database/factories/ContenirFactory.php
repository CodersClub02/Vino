<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bouteille;
use App\Models\Cellier;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contenir>
 */
class ContenirFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bouteille_id' => Bouteille::inRandomOrder()->first(),
            'cellier_id' => Cellier::inRandomOrder()->first(),
            'date_achat' => fake()->date(),
            'garder_jusqu_a' => fake()->year(),
            'notes' => fake()->numberBetween(1, 5),
            'prix_paye' => fake()->numberBetween(10, 1000),
            'quantite' => fake()->numberBetween(0, 10),
            'millesime' => fake()->numberBetween(1900, 2023),
        ];
    }
}
