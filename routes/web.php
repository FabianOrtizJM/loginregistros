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

Route::get('/signed',[CatalogoController::class,'signed'])->name('signed')->middleware(['auth', 'check.vpn']);
Route::get('/createcatalogo',[CatalogoController::class,'createcatalogo'])->name('createcatalogo')->middleware(['auth', 'check.vpn']);
Route::get('/catalogo',[CatalogoController::class,'index'])->name('catalogo')->middleware(['verify.role:Administrador,Coordinador,Usuario','auth','signed', 'check.vpn']);
Route::get('/catalogo/create',[CatalogoController::class,'create'])->name('create')->middleware(['verify.role:Administrador,Coordinador','auth','signed', 'check.vpn']);
Route::post('/store',[CatalogoController::class,'store'])->name('store')->middleware(['verify.role:Administrador,Coordinador','auth', 'check.vpn']);
Route::get('/editcatalogo/{id}',[CatalogoController::class,'editcatalogo'])->name('editcatalogo')->middleware(['auth', 'check.vpn']);
Route::get('/edit/{id}',[CatalogoController::class,'edit'])->name('edit')->middleware(['verify.role:Administrador,Coordinador','auth','signed', 'check.vpn']);
Route::put('/update/{id}',[CatalogoController::class,'update'])->name('update')->middleware(['verify.role:Administrador,Coordinador','auth', 'check.vpn']);
Route::delete('/delete/{id}',[CatalogoController::class,'destroy'])->name('delete')->middleware(['verify.role:Administrador,Coordinador','auth', 'check.vpn']);

Route::get('/signedusers',[UserController::class,'signedusers'])->name('signedusers')->middleware(['auth']);
Route::get('/users',[UserController::class,'index'])->name('users.index')->middleware(['verify.role:Administrador,Coordinador','auth','signed', 'check.vpn']);
Route::get('/createusers',[UserController::class,'createusers'])->name('createusers')->middleware(['auth', 'check.vpn']);
Route::get('/users/create',[UserController::class,'create'])->name('users.create')->middleware(['verify.role:Administrador','auth','signed', 'check.vpn']);
Route::post('/users',[UserController::class,'store'])->name('users.store')->middleware(['verify.role:Administrador','auth', 'check.vpn']);
Route::get('/editusers/{id}',[UserController::class,'editusers'])->name('editusers')->middleware(['auth', 'check.vpn']);
Route::get('/users/{id}/edit',[UserController::class,'edit'])->name('usersedit')->middleware(['verify.role:Administrador','auth','signed', 'check.vpn']);
Route::put('/users/{id}',[UserController::class,'update'])->name('users.update')->middleware(['verify.role:Administrador','auth', 'check.vpn']);
Route::delete('/users/{id}',[UserController::class,'destroy'])->name('users.destroy')->middleware(['verify.role:Administrador','auth', 'check.vpn']);  

Route::get('/login',[AuthController::class,'mostrarFormulariologin'])->name('login');
Route::get('/registro',[AuthController::class,'mostrarFormularioRegistro'])->name('registro');
Route::get('/signedinicio',[AuthController::class,'signedinicio'])->name('signedinicio')->middleware('auth');
Route::get('/inicio',[AuthController::class,'mostrarFormularioinicio'])->name('inicio')->middleware('auth','signed');


Route::post('/validar-registro',[AuthController::class,'registro'])->name('validar-registro');
Route::post('/inicia-sesion',[AuthController::class,'login'])->name('inicia-sesion');
Route::get('/inicia-sesion',[AuthController::class,'login'])->name('inicia-sesion');
Route::get('/logout',[AuthController::class,'logout'])->name('logout');
Route::post('/login-two-factor/{user}', [AuthController::class, 'login2FA'])->name('login2fa');


