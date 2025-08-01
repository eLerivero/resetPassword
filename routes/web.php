<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SineaController\ReestablecerContraseña;

Route::get('/', function () {
    return view('welcome');
});


    Route::get('/desarrollo', [ReestablecerContraseña::class, 'index'])->name('settings.apis.index');
    Route::get('/sinea/buscar-solicitante', [ReestablecerContraseña::class, 'buscarSolicitante'])->name('sinea.buscarSolicitante');
    Route::post('/sinea/validar-preguntas', [ReestablecerContraseña::class, 'validarPreguntas'])->name('sinea.validarPreguntas');
    Route::post('/sinea/update-password', [ReestablecerContraseña::class, 'updatePassword'])->name('sinea.updatePassword');
    Route::get('/sinea/authake/user/login', [ReestablecerContraseña::class, 'login'])->name('sinea.login');
    //testing plantilla
    Route::get('/sineapassword', [ReestablecerContraseña::class, 'vista']);