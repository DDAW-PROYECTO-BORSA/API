<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    use HasFactory;
    public $timestamps = false;

    function user(){
        return $this->belongsTo(User::class, 'idUsuario', 'id');
    }
}
