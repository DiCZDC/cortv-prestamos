<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Equipo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Equipo>
 */
class EquipoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_categoria' => Categoria::query()->inRandomOrder()->value('id'),
            'marca' => fake()->company(),
            'modelo' => fake()->word(),
        ];
    }
}
