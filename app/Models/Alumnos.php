<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Alumnos",
 *     description="Modelo alumno",
 *     @OA\Xml(
 *         name="Alumno"
 *     ),
 *      @OA\Property (property="id", type="integer", readOnly="true", example="1"),
 *      @OA\Property (property="name", type="string", readOnly="true", description="Nombre del usuario", example="1"),
 *      @OA\Property (property="apellidos", title="Apellidos", readOnly="true", description="Apellidos del alumno",type="string", example="Lehner Cassin"),
 *      @OA\Property (property="direccion", title="Dirección", readOnly="true", description="Dirección completa del alumno", type="string", example="3953 Ziemann Groves\nWest Kathrynmouth, MT 41924"),
 *      @OA\Property (property="email", title="Email", readOnly="true", description="Email de contacto del alumno", type="string", example="kendra66@example.com"),
 *      @OA\Property (property="CV", title="CV", readOnly="true", description="Enlace a su curriculum vitae o perfil de LinkedIn", type="string", example="www.myCV.com"),
 *      @OA\Property(property="ciclos", title="Ciclos", readOnly="true", description="Ciclos los cuales ha cursado el alumno", type="array", @OA\Items(ref="#/components/schemas/CicloResource")
 *
 *  )
 * )
 */

class Alumnos extends Model
{


    use HasFactory;
    protected $table = 'alumnos';
    protected $primaryKey = 'idUsuario';
    protected $fillable = [
        'idUsuario',
        'apellido',
        'cv',
    ];
    protected $hidden = [
        'contacto',
    ];


    function user(){
        return $this->belongsTo(User::class, 'idUsuario', 'id');
    }

    function ciclos()
    {
        return $this->belongsToMany(Ciclos::class, 'alumnosCiclos', 'idUsuario', 'idCiclo')->withPivot('finalizacion', 'validado');
    }

    function ofertas()
    {
        return $this->belongsToMany(Ciclos::class, 'alumnosCiclos', 'idUsuario', 'idCiclo')->withPivot('finalizacion', 'validado');
    }

    public function delete()
    {
        $this->ofertas()->detach();
        parent::delete();

    }
}
