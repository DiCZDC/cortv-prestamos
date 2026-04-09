<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $lucideIcons = [
            'home', 'settings', 'user', 'mail', 'calendar', 'camera', 'bell', 'heart',
            'star', 'search', 'menu', 'check', 'x', 'alert', 'info', 'help-circle',
            'clock', 'trending-up', 'download', 'upload', 'share', 'eye', 'lock',
            'unlock', 'key', 'credit-card', 'dollar-sign', 'shopping-cart', 'gift',
            'package', 'map', 'phone', 'volume', 'wifi', 'battery', 'sun', 'moon',
        ];

        return [
            'nombre_categoria' => $this->faker->word(),
            'icono' => $this->faker->randomElement($lucideIcons),
        ];
    }
}
