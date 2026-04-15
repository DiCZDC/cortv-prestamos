<?php

use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\RecepcionController;
use App\Http\Controllers\CalendarioController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::prefix('archivo')->name('archivo.')->group(function () {
        Route::controller(ArchivoController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show');
        });
    });
    
    Route::prefix('prestamo')->name('prestamo.')->group(function () {
        Route::controller(PrestamoController::class)->group(function () {
            Route::get('/create', 'create')->middleware('role:trabajador|admin')->name('create');
            Route::get('/{id}', 'show')->middleware('role:admin')->name('show');
            Route::get('/', 'index')->middleware('role:admin')->name('index');
        });
    });    

    Route::prefix('calendario')->name('calendario.')->group(function () {
        Route::controller(CalendarioController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show');
        });
    });

    Route::middleware(['auth', 'role:admin'])->group(function () {
        

        Route::prefix('recepcion')->name('recepcion.')->group(function () {
            Route::controller(RecepcionController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
            });
        });
        Route::prefix('entrega')->name('entrega.')->group(function () {
            Route::controller(EntregaController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
            });
        });

        Route::prefix('personal')->name('personal.')->group(function () {
            Route::controller(PersonalController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{id}', 'show')->name('show');
            });
        });

        Route::prefix('equipo')->name('equipo.')->group(function () {
            Route::controller(EquipoController::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::get('/{id}', 'show')->name('show');
            });
        });



    });

    

});

require __DIR__.'/settings.php';
