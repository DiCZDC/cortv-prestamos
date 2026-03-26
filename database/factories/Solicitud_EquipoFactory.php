<?php

namespace Database\Factories;

use App\Models\Equipo;
use App\Models\Solicitud;
use App\Models\Solicitud_Equipo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Solicitud_Equipo>
 */
class Solicitud_EquipoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'id_solicitud' => Solicitud::query()->inRandomOrder()->value('id'),
            'id_unidad_Equipo' => Equipo::query()->inRandomOrder()->value('id'),
        ];
    }
}
