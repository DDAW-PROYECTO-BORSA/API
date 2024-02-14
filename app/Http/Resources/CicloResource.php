<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="CicloResource",
 *     description="Project resource",
 *     @OA\Xml(name="CicloResource"),
 * )
 */

class CicloResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    /**
     * @OA\Property(
     *     property="data",
     *     title="data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Models\Ciclos[]
     */

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ciclo' => $this->ciclo,
            'vliteral' => $this->vliteral,
            'cliteral' => $this->cliteral,
            'idFamilia' => $this->familia->id,
            'responsable' => $this->responsable
        ];
    }
}
