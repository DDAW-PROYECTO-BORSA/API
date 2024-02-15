<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="CicloResource",
 *     description="**Ciclos**",
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
     * @var \App\Models\Ciclos[]
     *
     * @OA\Property(
     *     property="data",
     *     title="data",
     *     description="Data wrapper",
     *     type="object",
     *
     * @OA\Property(
     *      property="id",
     *      title="ID",
     *      description="Identificador único del ciclo",
     *      type="integer",
     *      example=1
     *  ),
     *
     * @OA\Property(
     *      property="ciclo",
     *      title="Ciclo",
     *      description="Nombre del Ciclo",
     *      type="string",
     *      example="CFM APD (LOE)"
     *  ),
     *
     * @OA\Property(
     *       property="vliteral",
     *       title="Vliteral",
     *       description="Nombre completo del Ciclo en valencià",
     *       type="string",
     *       example="Atenció a persones en situació de dependència"
     *   ),
     *
     * @OA\Property(
     *        property="cliteral",
     *        title="Cliteral",
     *        description="Nombre completo del Ciclo en castellano",
     *        type="string",
     *        example="Atención a personas en situación de dependencia"
     *    ),
     *
     * @OA\Property(
     *       property="idFamilia",
     *       title="IDFamilia",
     *       description="Identificador único de la familia a la que pertenece",
     *       type="integer",
     *       example=1
     *   ),
     *
     * @OA\Property(
     *       property="responsable",
     *       title="Responsable",
     *       description="Identificador único del usuario responsable del ciclo",
     *       type="integer",
     *       example=1
     *   )
     * )
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
