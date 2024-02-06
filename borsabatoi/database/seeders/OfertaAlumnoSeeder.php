<?php

namespace Database\Seeders;

use App\Models\Alumnos;
use App\Models\Ciclos;
use App\Models\Ofertas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Asegúrate de importar la fachada DB

class OfertaAlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { 
        $ofertas = Ofertas::all();
    
        foreach ($ofertas as $oferta) {
            $cicloIds = $oferta->ciclos->pluck('id');

            if ($cicloIds->isEmpty()) {
                continue; // No hay ciclos asociados a esta oferta
            }

            $alumnos = Alumnos::whereHas('ciclos', function ($query) use ($cicloIds) {
                $query->whereIn('id', $cicloIds);
            })->get();

            // Verificar la consulta SQL generada
            //$sql = $alumnos->toSql();
            //$bindings = $alumnos->getBindings();

            // Reemplazar los placeholders por los parámetros reales para una depuración más fácil
            //$fullSql = vsprintf(str_replace(['?'], ['\'%s\''], $sql), $bindings);
            //echo "Consulta SQL completa: {$fullSql}" . PHP_EOL;

            foreach ($alumnos as $alumnoAsignado) {
                
                $oferta->alumnos()->attach($alumnoAsignado->idUsuario);
            }
        }
    }
}





