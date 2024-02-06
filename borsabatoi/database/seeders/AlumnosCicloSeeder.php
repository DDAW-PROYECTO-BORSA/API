<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlumnosCicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alumnos = Alumno::all();
        $ciclos = Ciclo::all();

        // Por cada alumno se seleccionará uno o varios ciclos y se creará un registro
        foreach ($alumnos as $alumno){
            // Seleccion aleatoria de los ciclos
            $cicloId = rand(1, count($ciclos));
            $cicloAsignado = Ciclo::find($cicloId);
            $fechaFin = $this->faker->dateTimeBetween('-5 years', 'now');
            $alumno->ciclos()->attach($cicloAsignado->id, [
                'finalizacion' => $fechaFin,
                'validado' => true
            ]);


        }
    }
}
