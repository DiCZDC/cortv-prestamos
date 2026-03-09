<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{
    User,
    Equipo
};
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Solicitud>
 */
class SolicitudFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_trabajador' => User::query()->inRandomOrder()->value('id'),
            'id_admin' => User::query()->inRandomOrder()->value('id'),
            'motivo' => fake()->sentence(),
            'estado' => fake()->randomElement(['Pendiente', 'Aprobada', 'Rechazada']),
            'fecha_prestamo' => fake()->date(),
            'fecha_devolucion' => fake()->date(),
            'fecha_entrega' => fake()->optional()->date(),
        ];
    }
}
