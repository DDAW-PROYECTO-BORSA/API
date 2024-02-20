<?php

namespace Database\Factories;

use App\Models\Empresas;
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
            'idEmpresa' => Empresas::inRandomOrder()->value('idUsuario'),
            'descripcion' => $this->faker->paragraph(),
            'duracion' => $this->faker->numberBetween(1, 999),
            'contacto' => $this->faker->name,
            'metodoInscripcion' => $this->faker->randomElement(['email', 'inscripcion']),
            'estado' => 'activa',
            'email' => $this->faker->email,
            'validado' => true
        ];
    }
}
