<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ofertas extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function alumnos()
    {
        return $this->belongsToMany(Alumnos::class, 'alumnosOfertas', 'idOferta', 'idUsuario');
    }

    public function ciclos()
    {
        return $this->belongsToMany(Ciclos::class, 'ciclosOfertas', 'idOferta', 'idCiclo');
    }
}
