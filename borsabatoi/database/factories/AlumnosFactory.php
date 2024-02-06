<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alumnos>
 */
class AlumnosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::where('rol', 'alumno')->inRandomOrder()->first() ?: User::factory()->create(['rol' => 'alumno']);

    return [
        'idUsuario' => $user->id,
        'apellido' => $this->faker->lastName(),
        'CV' => $this->faker->paragraph() 
    ];
    }
}
