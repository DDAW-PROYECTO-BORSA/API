<?php

namespace Database\Seeders;

use App\Models\Ciclos;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class CicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFile = Storage::disk('public')->path('ciclos.json');
        $ciclos = json_decode(file_get_contents($jsonFile), true);
        $responsable = User::where('rol','representante')->first();

        foreach ($ciclos as $ciclo) {
            Ciclos::create([
                'id' => $ciclo['id'],
                'ciclo' => $ciclo['ciclo'],
                'idFamilia' => $ciclo['departamento'],
                'vliteral' => $ciclo['vliteral'],
                'cliteral' => $ciclo['cliteral'],
                'responsable' => $responsable->id
            ]);
        }
    }
}
