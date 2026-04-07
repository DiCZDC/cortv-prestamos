<?php

namespace Database\Factories;

use App\Models\Solicitud;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Solicitud>
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
        $estado = fake()->randomElement(['Pendiente', 'Autorizada', 'Entregada', 'Rechazada', 'Devuelta']);
        $fecha_prestamo = fake()->dateTimeBetween('-1 month', '+1 month');
        $fecha_devolucion = fake()->dateTimeBetween($fecha_prestamo, '+1 month');
        $fecha_entrega = null;

        if ($estado === 'Devuelta') {
            $fecha_entrega = fake()->dateTimeBetween($fecha_devolucion->format('Y-m-d H:i:s').' -1 month', $fecha_devolucion->format('Y-m-d H:i:s').' +1 month');
        } elseif ($estado === 'Autorizada') {
            $fecha_prestamo = fake()->dateTimeBetween('now', '+1 month');
            $fecha_devolucion = fake()->dateTimeBetween($fecha_prestamo->format('Y-m-d H:i:s').'+1 day', $fecha_prestamo->format('Y-m-d H:i:s').' +1 month');
        }

        return [
            'id_trabajador' => User::query()->inRandomOrder()->value('id'),
            'id_admin' => User::query()->inRandomOrder()->value('id'),
            'motivo' => fake()->sentence(),
            'estado' => $estado,
            'fecha_prestamo' => $fecha_prestamo,
            'fecha_devolucion' => $fecha_devolucion,
            'fecha_entrega' => $fecha_entrega,
        ];
    }
}
