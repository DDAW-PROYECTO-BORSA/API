<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresas>
 */
class EmpresasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create(['rol' => 'empresa']);

        
        return [
            'idUsuario' => $user->id,
            'CIF' => $this->faker->numerify('B########'),
            'contacto' => fake()->name(),
            'web' => $this->faker->url()

        ];
    }
}
