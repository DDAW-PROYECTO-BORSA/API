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

            // Comprovar si l'usuari existeix amb autenticació de Google
            $existingUser = User::where('google_id',$user->id)->first();
            // Comprovar si l'usuari està resgistrat amb el correu de l'usuari de Google
            $userWithoutGoogleAuth = User::where('email',$user->email)->first();

            if($existingUser != null){
                Auth::login($existingUser);
                $token = $existingUser->createToken('Personal Access Token')->plainTextToken;
            } elseif ($userWithoutGoogleAuth != null) {
                $userWithoutGoogleAuth->google_id = $user->id;
                $userWithoutGoogleAuth->save();
                Auth::login($userWithoutGoogleAuth);
                $token = $userWithoutGoogleAuth->createToken('Personal Access Token')->plainTextToken;
            } else {
                return view('auth.error', ['error' => 'Usuari no registrat']);
            }

            return view('auth.success', ['token' => $token]);

        } catch (\Exception $e) {
            // Maneig d'errors
            return view('auth.error', ['error' => $e->getMessage()]); // Asumint que tens una vista 'auth.error'
        }
    }

}


