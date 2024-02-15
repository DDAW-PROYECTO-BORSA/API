<?php

namespace App\Http\Resources;

use App\Models\Ciclos;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfertaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'empresa' => $this->empresas->user->name,
            'descripcion' => $this->descripcion,
            'duracion' => $this->duracion,
            'ciclos' => $this->getCiclos(),
            'contacto' => $this->contacto,
            'metodoInscripcion' => $this->metodoInscripcion,
            'estado' => $this->estado,
            'validado' => $this->validado,
        ];
    }
    private function getCiclos(){
        $ciclos = $this->ciclos;
        $cliteral = [];
        foreach ($ciclos as $ciclo){
            $cliteral[] = [
                'idCiclo' => $ciclo->id,
                'cliteral' => $ciclo->cliteral
            ];
        }

        return $cliteral;
    }
}
