<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="EmpresaResource",
 *     description="**Empresas**",
 *     @OA\Xml(name="EmpresaResource"),
 * )
 */

class EmpresaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    /**
     * @var \App\Models\Empresas[]
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
     *      description="Identificador único del usuario",
     *      type="integer",
     *      example=1
     *  ),
     *
     * @OA\Property(
     *      property="name",
     *      title="Nombre",
     *      description="Nombre de la empresa",
     *      type="string",
     *      example="Aceitunas el Serpis S.L."
     *  ),
     *
     * @OA\Property(
     *        property="direccion",
     *        title="Dirección",
     *        description="Dirección completa de la empresa",
     *        type="string",
     *        example="3953 Ziemann Groves\nWest Kathrynmouth, MT 41924"
     *    ),
     *
     * @OA\Property(
     *         property="email",
     *         title="Email",
     *         description="Email de contacto de la empresa",
     *         type="string",
     *         example="kendra66@example.com"
     *     ),
     *
     * @OA\Property(
     *       property="CIF",
     *       title="CIF",
     *       description="CIF de la empresa, será único para cada registro",
     *       type="string",
     *       example="B59015379"
     *   ),
     *
     *  @OA\Property(
     *        property="contacto",
     *        title="Contacto",
     *        description="Contacto de la empresa",
     *        type="string",
     *        example="Juanita Lehner Cassin"
     *    ),
     *
     * @OA\Property(
     *       property="web",
     *       title="Web",
     *       description="Web de la empresa",
     *       type="string",
     *       example="www.miweb.com"
     *   )
     * )
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
            'web' => $this->web != null ? $this->web : ''
        ];
    }
}
