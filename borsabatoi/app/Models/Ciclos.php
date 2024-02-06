<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclos extends Model
{
    use HasFactory;

    function responsable(){
        return $this->belongsTo(User::class, 'responsable', 'id');
    }

    function familia(){
        return $this->belongsTo(Familias::class, 'idFamilia', 'id');
    }

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumnosCiclos', 'idCiclo', 'idUsuario');
    }
}
