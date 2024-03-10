<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\LoginController;
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

Route::get('/login',[LoginController::class,'mostrarFormulariologin'])->name('login');
Route::get('/registro',[LoginController::class,'mostrarFormularioRegistro'])->name('registro');
Route::get('/inicio',[LoginController::class,'mostrarFormularioinicio'])->middleware('auth','signed')->name('inicio');


Route::post('/validar-registro',[LoginController::class,'registro'])->name('validar-registro');
Route::post('/inicia-sesion',[LoginController::class,'login'])->name('inicia-sesion');
Route::get('/inicia-sesion',[LoginController::class,'login'])->Middleware('auth','signed')->name('inicia-sesion');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');
Route::post('/login-two-factor/{user}', [LoginController::class, 'login2FA'])->name('login2fa');
