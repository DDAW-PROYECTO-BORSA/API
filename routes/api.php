<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\BookCollection;
use App\Models\Book;

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
Route::post('login', [\App\Http\Controllers\Api\ApiLoginController::class,'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users',App\Http\Controllers\Api\UserController::class);
Route::apiResource('modules',App\Http\Controllers\Api\ModuleController::class);
Route::apiResource('families',App\Http\Controllers\Api\FamilyController::class);
Route::apiResource('courses',App\Http\Controllers\Api\CourseController::class);

Route::apiResource('books',App\Http\Controllers\Api\BookController::class)->only(['index', 'show']);
Route::apiResource('books',App\Http\Controllers\Api\BookController::class)->only(['update', 'delete', 'store'])->middleware('auth:sanctum');

Route::apiResource('sales',App\Http\Controllers\Api\SaleController::class)->only(['index', 'show']);
Route::apiResource('sales',App\Http\Controllers\Api\SaleController::class)->only(['update', 'delete', 'store'])->middleware('auth:sanctum');

