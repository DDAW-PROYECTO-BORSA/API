<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familias extends Model
{
    use HasFactory;

    public $timestamps = false;


    public function ciclo(){
        return $this->hasOne(Ciclos::class, 'idFamilia', 'id');
    }
}
