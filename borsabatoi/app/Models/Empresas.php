<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'empresas';
    protected $primaryKey = 'idUsuario';
    public $incrementing = false;
    protected $fillable = [
        'idUsuario',
        'CIF',
        'contacto',
        'web',
    ];

    function user(){
        return $this->belongsTo(User::class, 'idUsuario', 'id');
    }

    function ofertas(){
        return $this->hasMany(Ofertas::class,'idEmpresa');
    }
}
