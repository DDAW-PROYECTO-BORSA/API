<?php

namespace App\Http\Resources;

use App\Models\Ciclos;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="OfertaResource",
 *     description="**Ofertas**",
 *     @OA\Xml(name="OfertaResource"),
 * )
 */

class OfertaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    /**
     * @var \App\Models\Ofertas[]
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
     *      description="Identificador único de la oferta",
     *      type="integer",
     *      example=1
     *  ),
     *
     * @OA\Property(
     *      property="empresa",
     *      title="Empresa",
     *      description="Nombre de la empresa que ha publicado la oferta",
     *      type="string",
     *      example="Aceitunas el Serpis S.L."
     *  ),
     *
     * @OA\Property(
     *       property="descripcion",
     *       title="Descripción",
     *       description="Descripción de la oferta",
     *       type="string",
     *       example="Se ofrece puesto de trabajo como pinche de cocina en tienda de comidas para llevar"
     *   ),
     *
     * @OA\Property(
     *        property="duracion",
     *        title="Duración",
     *        description="Duración del contrato ofrecido, en meses",
     *        type="integer",
     *        example="4"
     *    ),
     *
     * @OA\Property(
     *         property="ciclos",
     *         title="Ciclos",
     *         description="Id de los ciclos necesarios que ha de tener el alumno para inscribirse",
     *         type="array",
     *         @OA\Items(
     *             type="object",
     *                   @OA\Property(property="idCiclo", type="integer", example=1),
     *                   @OA\Property(property="cliteral", type="string", example="Atención a personas en situación de dependencia")
     *         )
     *     ),
     *
     * @OA\Property(
     *       property="contacto",
     *       title="Contacto",
     *       description="Persona de contacto de la empresa",
     *       type="string",
     *       example="Mrs. Katlyn Hessel MD"
     *   ),
     *
     * @OA\Property(
     *       property="metodoInscripcion",
     *       title="Método de inscripción",
     *       description="Método para inscribirse a la oferta, puede ser mediante la web o por email a la empresa",
     *       type="string",
     *       example="email"
     *   ),
     * @OA\Property(
     *        property="estado",
     *        title="Estadp",
     *        description="Estado de la oferta, puede ser activa o caducada",
     *        type="string",
     *        example="caducada"
     *    ),
     *
     * @OA\Property(
     *        property="validado",
     *        title="Validado",
     *        description="Si la oferta ha sido validada por el responsable indicado",
     *        type="integer",
     *        example="1"
     *    )
     * )
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=> $this->id,
            'empresa' => $this->empresas != null ? $this->empresas->user->name : '',
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
