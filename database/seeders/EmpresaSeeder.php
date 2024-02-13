<?php

namespace Database\Seeders;

use App\Models\Empresas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::factory()->create(['name' => 'Responsable CIP FP Batoi', 'email' => 'cipfpbatoi@gva.edu', 'rol' => 'empresa']);

        Empresas::create([
            'idUsuario' => $user->id,
            'CIF' => $this->faker->numerify('B########'),
            'contacto' => fake()->name(),
            'web' => 'https://cipfpbatoi.es'
        ]);

        Empresas::factory()->count(25)->create();
    }
}
