<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CiclosController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivateUserThingsController;
use App\Models\User;
use App\Models\Alumnos;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\ActivarCuentaNotification;
use App\Notifications\ValidarCiclosNotification;
use Laravel\Socialite\Facades\Socialite;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    auth()->logout();
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/alumnos/activar/{id}', [ActivateUserThingsController::class, 'activarCuenta'])->name('alumno.activarCuenta');
Route::get('/alumnos/activar/{userId}/{cicloId}', [ActivateUserThingsController::class, 'validarCiclo'])->name('alumno.validarCiclo');
Route::get('/ofertas/activar/{id}/', [ActivateUserThingsController::class, 'validarOferta']);

Route::resource('ciclos', CiclosController::class);
Route::resource('users', UserController::class);
Route::get('/users/cambiarContrasenya/{id}', [UserController::class, 'cambiarContrasenya']);




Route::get('/auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);

Route::get('/auth/github/redirect', function (){
    return Socialite::driver('github')->redirect();

});
Route::get('/auth/github/callback', function () {
    $githubUser = Socialite::driver('github')->user();

    $admin = User::where('rol', 'administrador')->first();
            // Crear usuario
    $user = User::where('email', $githubUser->email)->first();

    if(!$user->providerId){
        $user->providerId = $githubUser->id;
        $user->update();
    }
    auth()->login($user, true);
    return redirect('dashboard');
});
