<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Los datos introducidos son incorrectos.'],
            ]);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        // Crear un token de Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }


    public function githubRedirect()
    {
        return Socialite::driver('github')->redirect();
    }

    public function githubCallback()
    {
        $user = Socialite::driver('github')->user();
        dd($user);
    }

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
                return response()->json('Error, usuari no registrat', 500);
            }
            setcookie('auth_token', $token, [
                'expires' => time() + 86400, // Expira en 1 dia
                'path' => '/',
                'domain' => 'localhost', // Ajusta al teu domini
                'secure' => true,
                'httponly' => true,
                'samesite' => 'Strict',
            ]);

            return response()->json(['token' => $token], 200);

        } catch (Exception $e) {
            // Maneig d'errors
            return  response()->json(['error' => $e->getMessage()]);
        }
    }
}
