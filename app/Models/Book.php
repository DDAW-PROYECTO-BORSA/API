<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Sale;
use App\Models\User;


class Book extends Model
{
    use HasFactory;

    public function sales(){
        return $this->hasOne(Sale::class, 'id', 'idBook');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'idUser', 'id');
    }
}
