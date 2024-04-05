<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogoController;
use GuzzleHttp\Middleware;
use Spatie\Permission\Contracts\Role;

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

Route::get('/catalogo',[CatalogoController::class,'index'])->middleware('auth','signed')->name('catalogo');
Route::get('/catalogo/create',[CatalogoController::class,'create'])->name('create');
Route::post('/store',[CatalogoController::class,'store'])->name('store');
Route::get('/edit/{id}',[CatalogoController::class,'edit'])->name('edit');
Route::put('/update/{id}',[CatalogoController::class,'update'])->name('update');
Route::delete('/delete/{id}',[CatalogoController::class,'destroy'])->name('delete');

Route::get('/login',[AuthController::class,'mostrarFormulariologin'])->name('login');
Route::get('/registro',[AuthController::class,'mostrarFormularioRegistro'])->name('registro');
Route::get('/inicio',[AuthController::class,'mostrarFormularioinicio'])->middleware('auth','signed')->name('inicio');


Route::post('/validar-registro',[AuthController::class,'registro'])->name('validar-registro');
Route::post('/inicia-sesion',[AuthController::class,'login'])->name('inicia-sesion');
Route::get('/inicia-sesion',[AuthController::class,'login'])->name('inicia-sesion');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::post('/login-two-factor/{user}', [AuthController::class, 'login2FA'])->name('login2fa');
