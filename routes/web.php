<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OpenAIController;

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

Route::get('/', [BookController::class, 'index'])->name('inici');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('sales', SaleController::class)->only(['index', 'show']);
    Route::resource('users', UserController::class);
});

Route::get('auth/google', 'api\ApiLoginController@redirectToGoogle');
Route::get('auth/google/callback', 'api\ApiLoginController@handleGoogleCallback');
Route::get('/openai', [OpenAIController::class, 'index'])->name('openai.index');

require __DIR__.'/auth.php';

Route::get('/books/admitir/{id}', [BookController::class, 'admitirLibro'])->name('books.admitir');
Route::get('/books/comprar/{id}', [BookController::class, 'comprarLibro'])->name('books.comprar');

Route::get('/books/misLibros', [BookController::class, 'myBooks'])->name('books.loggedIndex');;
Route::resource('books',BookController::class);

Route::get('/books/purchase/{id}', function () {
    return view('books.purchase');
})->name('books.purchase');

Route::resource('courses',CourseController::class);
Route::resource('families',FamilyController::class);
Route::resource('modules',ModuleController::class);


