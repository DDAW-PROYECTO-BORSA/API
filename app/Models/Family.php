<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Module;


class Family extends Model

{
    use HasFactory;

    public function course()
    {
        return $this->hasMany(Course::class);
    }
}
