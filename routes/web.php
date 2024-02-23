<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CiclosController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\OfertasController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivateUserThingsController;
use App\Models\User;
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

Route::redirect('/', '/login')->name('home');

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
Route::resource('alumnos', AlumnoController::class);
Route::get('/ofertas/stats', [OfertasController::class, 'estadisticas'])->name('ofertas.estadisticas');
Route::resource('ofertas', OfertasController::class);
Route::resource('empresas', EmpresasController::class)->middleware('rol:administrador');

Route::get('/users/activos', [UserController::class, 'alumnosActivos'])->name('users.alumnosActivos');

Route::resource('users', UserController::class);
Route::get('/users/cambiarContrasenya/{id}', [UserController::class, 'cambiarContrasenya']);



Route::get('/auth/github/redirect', function (){
    return Socialite::driver('github')->redirect();

});
Route::get('/auth/github/callback', function () {
    $githubUser = Socialite::driver('github')->user();

    $user = User::where('email', $githubUser->email)->first();

    if(!$user->providerId){
        $user->providerId = $githubUser->id;
        $user->update();
    }
    if ($user->rol == "alumno" || $user->rol == "empresa"){
        $token = $user->createToken('api-token')->plainTextToken;
        return redirect('https://app2.projecteg4.ddaw.es/googleCallback#userId=' . $user->id . '&token=' . $token . '&rol=' . $user->rol);
    }else {
        auth()->login($user, true);
        return redirect('dashboard');
    }
});

Route::get('/auth/google', [LoginController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback']);
