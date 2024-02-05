<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Book;
use App\Models\User;

class Sale extends Model
{
    use HasFactory;


    public function books(){
        return $this->belongsTo(Book::class, 'idBook', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'idUser', 'id');
    }
}
