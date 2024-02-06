<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ofertas>
 */
class OfertasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descripcion' => $this->faker->paragraph(),
            'duracion' => $this->faker->numberBetween(1, 999),
            'contacto' => $this->faker->name,
            'metodoInscripcion' => $this->faker->randomElement(['email', 'inscripcion']),
            'estado' => $this->faker->randomElement(['activa', 'caducada']),
            'validado' => $this->faker->boolean,
        ];
    }
}
