<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{
    Solicitud,
    Equipo
};
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Solicitud_Equipo>
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
