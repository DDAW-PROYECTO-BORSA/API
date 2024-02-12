<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            // Trobar o crear l'usuari basat en la informació de Google
            $localUser = User::updateOrCreate(
                ['email' => $user->email],
                [
                    'name' => $user->name,
                    'google_id' => $user->id,
                    'rol' => 'google',
                    'password' => Hash::make(Str::random()),
                    'activado' => 0
                    // Altres camps que vulguis guardar
                ]
            );

            // Iniciar sessió de l'usuari
            Auth::login($localUser);

            // Generar token Sanctum
            $token = $localUser->createToken('Personal Access Token')->plainTextToken;

            // Redirigir l'usuari amb el token
            return view('auth.success', ['token' => $token]);

        } catch (\Exception $e) {
            // Maneig d'errors
            return view('auth.error', ['error' => $e->getMessage()]); // Asumint que tens una vista 'auth.error'
        }
    }

}


