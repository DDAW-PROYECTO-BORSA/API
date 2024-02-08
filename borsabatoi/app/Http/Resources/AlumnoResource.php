<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlumnoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->user->id,
            'nombre' => $this->user->name,
            'apellido' => $this->apellido,
            'direccion' => $this->user->direccion,
            'email' => $this->user->email,
            'CV' => $this->CV
        ];
    }
}
