<?php

use App\Http\Controllers\Settings\GestorApisController;
use App\Http\Controllers\SineaController\ReestablecerContraseña;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['auth']], function () {

    Route::get('settings/api', [GestorApisController::class, 'index'])->name('settings.apis.index');
    Route::get('settings/create', [GestorApisController::class, 'create'])->name('settings.apis.create');
    Route::post('settings/', [GestorApisController::class, 'store'])->name('settings.apis.store');
    Route::get('settings/{api}/edit', [GestorApisController::class, 'edit'])->name('settings.apis.edit');
    Route::put('settings/{api}', [GestorApisController::class, 'update'])->name('settings.apis.update');
    Route::delete('settings/{api}', [GestorApisController::class, 'destroy'])->name('settings.apis.destroy');



// Rutas para las APIs
    Route::resource('settings/apis', GestorApisController::class)->except(['show']);
    Route::get('/settings/apis/test-connection', [GestorApisController::class, 'showTestConnection'])->name('settings.apis.testConnectionForm');
    Route::post('/settings/apis/test-connection', [GestorApisController::class, 'testConnection'])->name('settings.apis.testConnection');
    Route::post('/settings/apis/log-event', [GestorApisController::class, 'logEvent'])->name('settings.apis.logEvent');

/* RUTAS PARA API SINEA */
    Route::get('/desarrollo', [ReestablecerContraseña::class, 'index'])->name('settings.apis.index');
    Route::get('/sinea/buscar-solicitante', [ReestablecerContraseña::class, 'buscarSolicitante'])->name('sinea.buscarSolicitante');
    Route::post('/sinea/validar-preguntas', [ReestablecerContraseña::class, 'validarPreguntas'])->name('sinea.validarPreguntas');
    Route::post('/sinea/update-password', [ReestablecerContraseña::class, 'updatePassword'])->name('sinea.updatePassword');
    Route::get('/sinea/authake/user/login', [ReestablecerContraseña::class, 'login'])->name('sinea.login');
    //testing plantilla
    Route::get('/sineapassword', [ReestablecerContraseña::class, 'vista']);
});
