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



        foreach ($ciclos as $ciclo) {
            $responsablesDisponibles = User::where('rol', 'responsable')
                ->whereDoesntHave('ciclosComoResponsable')
                ->pluck('id');
                if ($responsablesDisponibles->isNotEmpty()) {
                    // Tomar el primer ID de responsable disponible
                    $responsableId = $responsablesDisponibles->first();
                    
                    // Asignar este usuario como responsable del ciclo actual
                    Ciclos::create([
                        'id' => $ciclo['id'],
                        'ciclo' => $ciclo['ciclo'],
                        'idFamilia' => $ciclo['departamento'],
                        'vliteral' => $ciclo['vliteral'],
                        'cliteral' => $ciclo['cliteral'],
                        'responsable' => $responsableId
                    ]);
            
                    // Remover el ID de responsable utilizado de la lista de disponibles
                    $responsablesDisponibles = $responsablesDisponibles->filter(function($id) use ($responsableId) {
                        return $id != $responsableId;
                    });
                } else {
                    // Manejar el caso de que no haya más responsables disponibles
                    // Puede ser creando un nuevo usuario con rol 'responsable' o asignando un valor predeterminado
                    $responsable = User::factory()->create(["rol" => 'responsable']);
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
    }