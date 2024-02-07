<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclos extends Model
{
    use HasFactory;
    public $timestamps = false;

    function usuarioResponsable(){
        return $this->belongsTo(User::class, 'responsable', 'id');
    }

    function familia(){
        return $this->belongsTo(Familias::class, 'idFamilia', 'id');
    }

    function alumnos()
    {
        return $this->belongsToMany(Alumnos::class, 'alumnosCiclos', 'idCiclo', 'idUsuario')->withPivot('finalizacion', 'validado');
    }
}
