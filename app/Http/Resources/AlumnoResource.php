<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="AlumnoResource",
 *     description="**Alumnos**",
 *     @OA\Xml(name="AlumnoResource"),
 * )
 */
class AlumnoResource extends JsonResource
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
     *      description="Identificador único del usuario",
     *      type="integer",
     *      example=1
     *  ),
     *
     * @OA\Property(
     *      property="name",
     *      title="Nombre",
     *      description="Nombre del alumno",
     *      type="string",
     *      example="Crystal"
     *  ),
     *
     * @OA\Property(
     *       property="apellidos",
     *       title="Apellidos",
     *       description="Apellidos del alumno",
     *       type="string",
     *       example="Lehner Cassin"
     *   ),
     *
     * @OA\Property(
     *        property="direccion",
     *        title="Dirección",
     *        description="Dirección completa del alumno",
     *        type="string",
     *        example="3953 Ziemann Groves\nWest Kathrynmouth, MT 41924"
     *    ),
     *
     * @OA\Property(
     *         property="email",
     *         title="Email",
     *         description="Email de contacto del alumno",
     *         type="string",
     *         example="kendra66@example.com"
     *     ),
     *
     * @OA\Property(
     *       property="CV",
     *       title="CV",
     *       description="Enlace a su curriculum vitae o perfil de LinkedIn",
     *       type="string",
     *       example="www.myCV.com"
     *   ),
     *
     * @OA\Property(
     *       property="ciclos",
     *       title="Ciclos",
     *       description="Ciclos los cuales ha cursado el alumno",
     *       type="array",
     *       @OA\Items(ref="#/components/schemas/CicloResource")
     *   )
     * )
     */

    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->user->id,
            'nombre' => $this->user->name,
            'apellido' => $this->apellido,
            'direccion' => $this->user->direccion,
            'email' => $this->user->email,
            'CV' => $this->CV,
            'ciclos' => $this->ciclos
        ];
    }
}
