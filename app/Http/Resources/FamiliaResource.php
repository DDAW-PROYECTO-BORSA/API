<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="FamiliaResource",
 *     description="Project resource",
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
     * @OA\Property(
     *     property="data",
     *     title="data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Models\Familias[]
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
