<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;


class ApiLoginController extends Controller
{

    // En LoginController 

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
                'password' => Hash::make('password'),
                'google_id' => $user->id,
            ]
        );

        // Iniciar sessió de l'usuari
        Auth::login($localUser);

        // Generar token Sanctum
        $token = $localUser->createToken('Personal Access Token')->plainTextToken;

        // Redirigir l'usuari amb el token
        return view('auth.success', ['token' => $token]); // Asumint que tens una vista 'auth.success'

    } catch (\Exception $e) {
        // Maneig d'errors
        return view('auth.error', ['error' => $e->getMessage()]); // Asumint que tens una vista 'auth.error'
    }
}

    public function login(Request $request)
    { 
         $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);


        
        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'login' => ['The provided credentials are incorrect.'],
            ]);
        } 
        
        $user = User::where('email', $request->email)->firstOrFail();

        // Crear un token de Sanctum
        $token = $user->createToken('api-token')->plainTextToken;
        return response()->json(['token' => $token], 200);
    }
}