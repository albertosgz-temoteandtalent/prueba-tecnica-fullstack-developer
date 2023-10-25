<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/url-generator/imagen', [\App\Http\Controllers\DynamicPage::class, 'crearImagen'])->name('dynamic-page.crear-imagen');
Route::post('/url-generator/usuario', [\App\Http\Controllers\PerfilUsuarioController::class, 'store'])->name('dynamic-page.crear-usuario');
Route::post('/url-generator/usuario/{perfilUsuario}/enviar-correo', [\App\Http\Controllers\PerfilUsuarioController::class, 'enviarCorreo'])->name('dynamic-page.enviar-correo');

