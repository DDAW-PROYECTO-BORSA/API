<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CiclosController;
use App\Http\Controllers\ActivateUserThingsController;
use App\Models\User;
use App\Models\Alumnos;
use Illuminate\Support\Facades\Hash;



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
Route::get('/ofertas/activar/{id}/', [ActivateUserThingsController::class, 'validarOferta'])->name('alumno.validarCiclo');

Route::resource('ciclos', CiclosController::class);


Route::get('/auth/github/redirect', function (){
    return Socialite::driver('github')->redirect();

});
Route::get('/auth/github/callback', function () {
    $githubUser = Socialite::driver('github')->user();

    $admin = User::where('rol', 'administrador')->first();
            // Crear usuario
            $user = new User();
            $user->name = $githubUser->name;
            $user->email = $githubUser->email;
            $user->password = Hash::make("password");
            $user->direccion = "";
            $user->rol = 'alumno';
            $user->save();
            // Crear el alumno asociada al usuario
            $alumno = new Alumnos();
            $alumno->apellido = "";
            $alumno->cv = $githubUser->user['html_url'];

            // Guardar el alumno asociada al usuario
            $user->alumno()->save($alumno);
            $alumno = Alumnos::findOrFail($user->id);

            $user->notify(new ActivarCuentaNotification($user));


            foreach ($request->ciclosA as $cicloA) {
                $ciclo = Ciclos::findOrFail($cicloA['id']);
                $alumno->ciclos()->attach($ciclo->id, [
                    'finalizacion' => $cicloA['finalizacion'],
                ]);                
                $ciclo->usuarioResponsable->notify(new ValidarCiclosNotification($alumno, $ciclo));
                $admin->notify(new ValidarCiclosNotification($alumno, $ciclo));

            }
});