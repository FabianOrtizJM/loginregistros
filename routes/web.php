<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use GuzzleHttp\Middleware;

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
    return view('login');
});

Route::get('/login',[AuthController::class,'mostrarFormulariologin'])->name('login');
Route::get('/registro',[AuthController::class,'mostrarFormularioRegistro'])->name('registro');
Route::get('/inicio',[AuthController::class,'mostrarFormularioinicio'])->middleware('auth','signed')->name('inicio');


Route::post('/validar-registro',[AuthController::class,'registro'])->name('validar-registro');
Route::post('/inicia-sesion',[AuthController::class,'login'])->name('inicia-sesion');
Route::get('/inicia-sesion',[AuthController::class,'login'])->name('inicia-sesion');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::post('/login-two-factor/{user}', [AuthController::class, 'login2FA'])->name('login2fa');
