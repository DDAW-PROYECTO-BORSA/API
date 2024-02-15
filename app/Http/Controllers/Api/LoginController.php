<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

/**
 * @OA\Post(
 * path="/api/login",
 * summary="Sign in",
 * description="Login by email, password",
 * operationId="authLogin",
 * tags={"auth"},
 * @OA\RequestBody(
 *    required=true,
 *    description="Pass user credentials",
 *    @OA\JsonContent(
 *       required={"email","password"},
 *       @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *       @OA\Property(property="password", type="string", format="password", example="PassWord12345"),
 *    ),
 * ),
 * @OA\Response(
 *    response=422,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Email o contraseña erróneos. Por favor, inténtalo de nuevo")
 *        )
 *     )
 * ,
 * @OA\Response(
 *     response=200,
 *     description="Success",
 *     @OA\JsonContent(
 *         @OA\Property(property="token", type="string")
 *          )
 *       )
 * )
 */

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $messages = [];
        if(User::where('email',$request->email)->first() == null){
            $messages[] = ['email' => 'El email introducido es incorrecto, por favor inténtalo de nuevo'];
        } else {
            $messages[] = ['password' => 'La contraseña introducida es incorrecta, por favor inténtalo de nuevo'];
        }

       if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages($messages);
       }

        $user = User::where('email', $request->email)->firstOrFail();

        // Crear un token de Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['userId' => $user->id, "rol" => $user->rol, 'token' => $token], 200);
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
