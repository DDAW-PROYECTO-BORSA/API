<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ofertas extends Model
{
    use HasFactory;
    public $timestamps = false;
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
