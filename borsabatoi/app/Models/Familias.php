<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Familias extends Model
{
    use HasFactory;


    public function ciclo(){
        return $this->hasOne(Ciclos::class, 'id', 'idFamilia');
    }
}
