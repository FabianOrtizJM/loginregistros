<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\UserController;
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


Route::get('/catalogo',[CatalogoController::class,'index'])->name('catalogo');
Route::get('/catalogo/create',[CatalogoController::class,'create'])->name('create');
Route::post('/store',[CatalogoController::class,'store'])->name('store');
Route::get('/edit/{id}',[CatalogoController::class,'edit'])->name('edit');
Route::put('/update/{id}',[CatalogoController::class,'update'])->name('update');
Route::delete('/delete/{id}',[CatalogoController::class,'destroy'])->name('delete');

Route::get('/users',[UserController::class,'index'])->name('users.index');
Route::get('/users/create',[UserController::class,'create'])->name('users.create');
Route::post('/users',[UserController::class,'store'])->name('users.store');
Route::get('/users/{id}/edit',[UserController::class,'edit'])->name('users.edit');
Route::put('/users/{id}',[UserController::class,'update'])->name('users.update');
Route::delete('/users/{id}',[UserController::class,'destroy'])->name('users.destroy');

Route::get('/login',[AuthController::class,'mostrarFormulariologin'])->name('login');
Route::get('/registro',[AuthController::class,'mostrarFormularioRegistro'])->name('registro');
Route::get('/inicio',[AuthController::class,'mostrarFormularioinicio'])->name('inicio');


Route::post('/validar-registro',[AuthController::class,'registro'])->name('validar-registro');
Route::post('/inicia-sesion',[AuthController::class,'login'])->name('inicia-sesion');
Route::get('/inicia-sesion',[AuthController::class,'login'])->name('inicia-sesion');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::post('/login-two-factor/{user}', [AuthController::class, 'login2FA'])->name('login2fa');


