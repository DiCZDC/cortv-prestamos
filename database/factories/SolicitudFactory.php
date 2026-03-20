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
            'estado' => fake()->randomElement(['Pendiente', 'Autorizada', 'Entregada', 'Rechazada','Devuelta']),
            'fecha_prestamo' => fake()->dateTimeBetween('-2 year', '+1 year'),
            'fecha_devolucion' => fake()->dateTimeBetween('-1 year', '+1 year'),
            'fecha_entrega' => fake()->optional()->dateTimeBetween('-1 year', '+1 year'),
        ];
    }
}
