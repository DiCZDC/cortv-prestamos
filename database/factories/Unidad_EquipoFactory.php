<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{
    Equipo};
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unidad_Equipo>
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
            'estado' => fake()->randomElement(['Disponible', 'Prestado', 'En reparación']),
        ];
    }
}
