<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MegustaController;
use App\Http\Controllers\MensajeController;
use Illuminate\Support\Facades\Auth;

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

Auth::routes(['verify' => true]);

Route::get('/', [App\Http\Controllers\FrontendController::class, 'index'])->name('index');

//user routes
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//UserController
Route::resource('backend/user', UserController::class, ['names' => 'backend.user']); //middleware en el constructor
//extras user controller
Route::post('password/change', [UserController::class, 'changePassword'])->name('password.change')->middleware('verified');
Route::post('user/change', [UserController::class, 'changeUser'])->name('user.change')->middleware('verified');
//rutas de restauración de email
Route::get('email/restore/{id}/{email}', [UserController::class, 'restoreEmail'] )->name('email.restore')->middleware('signed');//muestra el formulario
Route::post('email/restore/{id}/{email}', [UserController::class, 'restorePreviousEmail'] )->name('email.restore')->middleware('signed'); //salva el form


//backend
Route::resource('backend/producto', ProductoController::class, ['names' => 'backend.producto'])->middleware('verified');
Route::delete('backend/imgproducto/{id}', [ProductoController::class, 'imgdestroy'] )->name('backend.imgproducto.destroy')->middleware('verified');
Route::resource('backend/megusta', MegustaController::class, ['names' => 'backend.megusta'])->middleware('verified');
Route::resource('backend/mensaje', MensajeController::class, ['names' => 'backend.mensaje'])->middleware('verified');

Route::get('backend/mensaje/{id}/{producto}', [UserController::class, 'enviarMensaje'] )->name('backend.mensaje.enviar')->middleware('signed');//
