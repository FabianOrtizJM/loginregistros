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


Route::get('/catalogo',[CatalogoController::class,'index'])->name('catalogo')->middleware(['verify.role:Administrador,Coordinador,Usuario','auth']);
Route::get('/catalogo/create',[CatalogoController::class,'create'])->name('create')->middleware(['verify.role:Administrador,Coordinador','auth']);
Route::post('/store',[CatalogoController::class,'store'])->name('store')->middleware(['verify.role:Administrador,Coordinador','auth']);
Route::get('/edit/{id}',[CatalogoController::class,'edit'])->name('edit')->middleware(['verify.role:Administrador,Coordinador','auth']);
Route::put('/update/{id}',[CatalogoController::class,'update'])->name('update')->middleware(['verify.role:Administrador,Coordinador','auth']);
Route::delete('/delete/{id}',[CatalogoController::class,'destroy'])->name('delete')->middleware(['verify.role:Administrador,Coordinador','auth']);

Route::get('/users',[UserController::class,'index'])->name('users.index')->middleware(['verify.role:Administrador,Coordinador','auth']);
Route::get('/users/create',[UserController::class,'create'])->name('users.create')->middleware(['verify.role:Administrador','auth']);
Route::post('/users',[UserController::class,'store'])->name('users.store')->middleware(['verify.role:Administrador','auth']);
Route::get('/users/{id}/edit',[UserController::class,'edit'])->name('users.edit')->middleware(['verify.role:Administrador','auth']);
Route::put('/users/{id}',[UserController::class,'update'])->name('users.update')->middleware(['verify.role:Administrador','auth']);
Route::delete('/users/{id}',[UserController::class,'destroy'])->name('users.destroy')->middleware(['verify.role:Administrador','auth']);  

Route::get('/login',[AuthController::class,'mostrarFormulariologin'])->name('login');
Route::get('/registro',[AuthController::class,'mostrarFormularioRegistro'])->name('registro');
Route::get('/inicio',[AuthController::class,'mostrarFormularioinicio'])->name('inicio');


Route::post('/validar-registro',[AuthController::class,'registro'])->name('validar-registro');
Route::post('/inicia-sesion',[AuthController::class,'login'])->name('inicia-sesion');
Route::get('/inicia-sesion',[AuthController::class,'login'])->name('inicia-sesion');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::post('/login-two-factor/{user}', [AuthController::class, 'login2FA'])->name('login2fa');


