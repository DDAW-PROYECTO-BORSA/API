<?php

namespace Database\Seeders;

use App\Models\Alumnos;
use App\Models\Ciclos;
use App\Models\Ofertas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfertaAlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ofertas = Ofertas::all();

        // Por cada oferta se seleccionarán varios alumnos y se creará un registro por cada uno
        foreach ($ofertas as $oferta) {
            // Seleccion aleatoria de los alumnos
            $alumnos = Alumnos::where('idCiclo', $oferta->ciclos());
            $alumnoIndex = rand(0, count($alumnos) - 1);
            $alumnoAsignado = $alumnos[$alumnoIndex];

            $oferta->alumnos()->attach($alumnoAsignado->id);
        }
    }
}
