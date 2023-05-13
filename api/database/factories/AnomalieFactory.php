<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bouteille;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Anomalie>
 */
class AnomalieFactory extends Factory
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
            'user_id' => User::inRandomOrder()->first(),
            'message' => fake()->paragraph(),
            'resolue' => numberBetween(0, 1),
            'date_resolution' => fake()->dateTime()
        ];
    }
}
