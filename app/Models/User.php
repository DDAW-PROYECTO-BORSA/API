<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 *
 * @OA\Schema(
 * required={"password"},
 * @OA\Xml(name="User"),
 * @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 * @OA\Property(property="role", type="string", readOnly="true", description="Rol del usuario"),
 * @OA\Property(property="email", type="string", readOnly="true", format="email", description="Email del usuario, será único", example="user@gmail.com"),
 * @OA\Property(property="email_verified_at", type="string", readOnly="true", format="date-time", description="Datetime marker of verification status", example="2019-02-25 12:59:20"),
 * @OA\Property(property="name", type="string", maxLength=32, example="John"),
 * @OA\Property(property="google_id",type="string", maxLength=255, description="ID de Google, se añadirá automáticamente si inicia sesión mediante una cuenta de Google con el mismo email con el que se ha registrado",  example="115280133845067737067")
 * )
 *
 * Class User
 *
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function alumno(){
        return $this->hasOne(Alumnos::class, 'idUsuario', 'id');
    }

    public function empresa(){
        return $this->hasOne(Empresas::class, 'idUsuario', 'id');
    }

    function ciclosComoResponsable(){
        return $this->hasMany(Ciclos::class, 'responsable', 'id');
    }
}
