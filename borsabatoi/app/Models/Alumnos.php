<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumnos extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'idUsuario';


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
}
