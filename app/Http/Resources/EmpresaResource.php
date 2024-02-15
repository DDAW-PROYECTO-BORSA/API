<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaResource extends JsonResource
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
            'direccion' => $this->user->direccion,
            'email' => $this->user->email,
            'CIF' => $this->CIF,
            'contacto' => $this->contacto,
            'rol' => $this->user->rol,
            'web' => $this->web != null ? $this->web : ''
        ];
    }
}
