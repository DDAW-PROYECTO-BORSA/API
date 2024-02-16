<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     title="Ofertas",
 *     description="Modelo oferta",
 *     @OA\Xml(
 *         name="Oferta"
 *     ),
 *      @OA\Property (property="idEmpresa", type="integer", readOnly="true", description="id de usuario de la empresa", example="1"),
 *      @OA\Property (property="descripcion", title="descripcion", readOnly="true", description="Descripción de la oferta", type="string", example="Ut officia vel debitis cupiditate repellat soluta sit aspernatur. Repudiandae magni quibusdam distinctio saepe id iste. Corporis officia ipsa ratione dolorum deserunt omnis."),
 *      @OA\Property (property="duracion", title="Dirección", readOnly="true", description="Duración del contrato, en meses", type="integer", example="12"),
 *      @OA\Property (property="contacto", title="Contacto", readOnly="true", description="Persona de contacto de la empresa", type="string", example="Shania Morar"),
 *      @OA\Property (property="metodoInscripcion", title="Método de inscripción", readOnly="true", description="Los aspirantes se podrán inscribir mediante un email o em la propia web", type="string", example="email"),
 *      @OA\Property (property="email", title="email", readOnly="true", description="Email donde inscribirse a la oferta", type="string", example="example@empresa.com"),
 *      @OA\Property (property="estado", title="Estado", readOnly="false", description="Estado de la oferta, puede estar activa o caducada ", type="string", example="activa")
 * )
 * )
 */

class Ofertas extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'ofertas';

    public function alumnos()
    {
        return $this->belongsToMany(Alumnos::class, 'ofertasAlumnos', 'idOferta', 'idUsuario');
    }

    public function ciclos()
    {
        return $this->belongsToMany(Ciclos::class, 'ofertasCiclos', 'idOferta', 'idCiclo');
    }

    public function empresas()
    {
        return $this->belongsTo(Empresas::class,'idEmpresa');
    }
}
