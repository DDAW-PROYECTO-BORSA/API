<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ofertas extends Model
{
    use HasFactory;

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'alumnosOfertas', 'idOferta', 'idUsuario');
    }

    public function ciclos()
    {
        return $this->belongsToMany(Ciclo::class, 'ciclosOfertas', 'idOferta', 'idCiclo');
    }
}
