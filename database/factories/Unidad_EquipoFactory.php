<?php

namespace Database\Factories;

use App\Models\Equipo;
use App\Models\Unidad_Equipo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Unidad_Equipo>
 */
class Unidad_EquipoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_equipo' => Equipo::query()->inRandomOrder()->value('id'),
            'sicipo' => fake()->unique()->numerify('SICIPO-####'),
            'estado' => fake()->randomElement(['Disponible', 'Prestado', 'En reparación', 'Reservado']),
        ];
    }
}
