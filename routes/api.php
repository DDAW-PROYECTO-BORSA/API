<?php

use App\Http\Controllers\Api\CicloController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\AlumnosController;

use App\Http\Controllers\Api\FamiliaController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\OfertaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('ofertas/inscribirse/{idOferta}/{idAlumno}', [OfertaController::class,'inscribirse']);
Route::post('ofertas/desinscribirse/{idOferta}/{idAlumno}', [OfertaController::class,'inscribirse']);
Route::get('ofertas/candidatos/{id}', [OfertaController::class,'candidatos']);
Route::get('ofertas/inscritasAlumno/', [OfertaController::class, 'ofertasAlumnoInscrito'])->middleware('auth:sanctum');

Route::apiResource('empresas',EmpresaController::class)->middleware('auth:sanctum');;

Route::apiResource('ofertas',OfertaController::class)->middleware('auth:sanctum');
Route::apiResource('familias', FamiliaController::class);
Route::apiResource('ciclos', CicloController::class);

Route::apiResource('alumnos', AlumnosController::class);

Route::post('login', [LoginController::class,'login']);
