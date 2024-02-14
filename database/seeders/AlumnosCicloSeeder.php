<?php

namespace Database\Seeders;

use App\Models\Alumnos;
use App\Models\Ciclos;
use Illuminate\Database\Seeder;

class AlumnosCicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alumnos = Alumnos::all();
        $ciclos = Ciclos::all();

        // Por cada alumno se seleccionará uno o varios ciclos y se creará un registro
        foreach ($alumnos as $alumno){
            // Seleccion aleatoria de los ciclos
            $cicloIndex = rand(0, count($ciclos) - 1);
            $cicloAsignado = $ciclos[$cicloIndex];


            $timestampInicio = strtotime('-5 years');
            $timestampFin = time();
            // Genera un timestamp aleatorio entre esos dos
            $timestampAleatorio = rand($timestampInicio, $timestampFin);
            // Convierte el timestamp aleatorio en un formato de fecha
            $fechaFin = date('Y-m-d H:i:s', $timestampAleatorio);

            $alumno->ciclos()->attach($cicloAsignado->id, [
                'finalizacion' => $fechaFin,
                'validado' => true
            ]);
        }
    }
}
