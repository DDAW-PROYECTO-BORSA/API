<?php

use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\AlumnosController;

use App\Http\Controllers\Api\LoginController;
use App\Http\Resources\EmpresaCollection;
use App\Http\Resources\EmpresaResource;
use App\Models\Empresas;
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

Route::apiResource('empresas',EmpresaController::class);
Route::apiResource('alumnos', AlumnosController::class);

Route::post('login', [LoginController::class,'login']);

