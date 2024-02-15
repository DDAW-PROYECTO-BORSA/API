<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="FamiliaResource",
 *     description="**Familias**",
 *     @OA\Xml(name="FamiliaResource"),
 * )
 */

class FamiliaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    /**
     * @var \App\Models\Familias[]
     * @OA\Property(
     *     property="data",
     *     title="data",
     *     description="Data wrapper",
     *     type="object",
     *
     * @OA\Property(
     *      property="id",
     *      title="ID",
     *      description="Identificador único de la familia",
     *      type="integer",
     *      example=1
     *  ),
     *
     *
     * @OA\Property(
     *       property="vliteral",
     *       title="Vliteral",
     *       description="Nombre completo de la familia en valencià, en mayúsculas",
     *       type="string",
     *       example="ANGLES"
     *   ),
     *
     * @OA\Property(
     *        property="cliteral",
     *        title="Cliteral",
     *        description="Nombre completo de la familia en castellano, en mayúsculas",
     *        type="string",
     *        example="INGLES"
     *    ),
     *
     * @OA\Property(
     *       property="deptcurt",
     *       title="Abreviación",
     *       description="Abreviación del nombre de la família",
     *       type="string",
     *       example="Ang"
     *   )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'vliteral' => $this->vliteral,
            'cliteral' => $this->cliteral,
            'deptcurt' => $this->depcurt
        ];
    }
}
