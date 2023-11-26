<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::apiResource('/mapel', App\Http\Controllers\api\MapelController::class);
Route::apiResource('/ujian', App\Http\Controllers\api\UjianController::class);
Route::apiResource('/soal', App\Http\Controllers\api\SoalController::class);
Route::get('/byid/{id}', [App\Http\Controllers\api\DataUjianController::class, 'showID']);
Route::apiResource('/jawaban', App\Http\Controllers\api\JawabanController::class);
Route::apiResource('/ujihasil', App\Http\Controllers\UjihasilController::class);

// users
Route::post('/register', App\Http\Controllers\api\RegisterController::class)->name('register');
Route::post('/login', App\Http\Controllers\api\LoginController::class)->name('login');
Route::middleware('auth:api')->get('/user', function(Request $request) {
  return $request->user();
});
Route::post('/logout', App\Http\Controllers\api\LogoutController::class)->name('logout');
