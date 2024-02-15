<?php

namespace Database\Seeders;

use App\Models\Ciclos;
use App\Models\Ofertas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfertaCicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ciclos = Ciclos::all();
        $ofertas = Ofertas::all();

        // Por cada alumno se seleccionará uno o varios ciclos y se creará un registro
        foreach ($ofertas as $oferta) {
            // Seleccion aleatoria de los ciclos
            $cicloIndex = rand(0, count($ciclos) - 1);
            $cicloAsignado = $ciclos[$cicloIndex];
            $oferta->ciclos()->attach($cicloAsignado->id);
        }
    }
}
