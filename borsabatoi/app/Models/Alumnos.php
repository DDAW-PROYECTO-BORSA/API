<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumnos extends Model
{
    use HasFactory;

    function user(){
        return $this->belongsTo(User::class, 'idUsuario', 'id');
    }

    function ciclos()
    {
        return $this->belongsToMany(Ciclo::class, 'alumnosCiclos', 'idUsuario', 'idCiclo')->withPivot('finalizacion', 'validado');
    }
}
