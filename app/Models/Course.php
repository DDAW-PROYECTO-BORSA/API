<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Module;
use App\Models\Family;



class Course extends Model
{
    use HasFactory;

    public function module()
    {
        return $this->hasMany(Module::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
