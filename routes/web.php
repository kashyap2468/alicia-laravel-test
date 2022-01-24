<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');

Route::get('/addImagetoFavourite/{imageId}', [\App\Http\Controllers\HomeController::class, 'addImagetoFavourite'])->name('addImagetoFavourite');
Route::get('/removeImageFavourite/{imageId}', [\App\Http\Controllers\HomeController::class, 'removeImageFavourite'])->name('removeImageFavourite');

Route::get('/gotoregister',[\App\Http\Controllers\HomeController::class, 'goToRegister'])->name('gotoregister');
//Route::post('login','HomeController@login')->name('login.post');
Route::post('/register-user', [\App\Http\Controllers\HomeController::class, 'process_signup']);
Route::post('/login-user', [\App\Http\Controllers\HomeController::class, 'login']);
Route::get('/logout', [\App\Http\Controllers\HomeController::class, 'logout']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
