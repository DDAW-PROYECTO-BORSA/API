<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
