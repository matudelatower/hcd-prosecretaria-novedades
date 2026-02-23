<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ResponsableController;
use App\Http\Controllers\NovedadController;
use App\Http\Controllers\DesignacionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Rutas solo para administradores
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('areas', AreaController::class);
        Route::resource('responsables', ResponsableController::class);
        Route::resource('designaciones', DesignacionController::class);
        Route::resource('users', UserController::class);
    });
    
    // Rutas para todos los usuarios autenticados
    Route::resource('novedades', NovedadController::class);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
