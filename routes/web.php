<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\LoginController;
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

Route::view('/login',"login")->name('login');
Route::view('/registro',"registro")->name('registro');
Route::view('/inicio',"inicio")->middleware('auth')->name('inicio');

Route::post('/validar-registro',[LoginController::class,'registro'])->name('validar-registro');
Route::post('/inicia-sesion',[LoginController::class,'login'])->name('inicia-sesion');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');