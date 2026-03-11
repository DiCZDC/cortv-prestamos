<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    prestamosController,
    ArchivoController,
    RecepcionController,
    PersonalController,
    EquipoController   
};


Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard'); 
    
    Route::prefix('prestamos')->name('prestamos.')->group(function () {
        Route::controller(prestamosController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('create', 'create')->name('create');
            Route::get('/{id}', 'show')->name('show');
        });
        
    });

    Route::prefix('archivos')->name('archivos.')->group(function () {
        Route::controller(ArchivoController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{id}', 'show')->name('show');
        });
    });

    Route::prefix('recepcion')->name('recepcion.')->group(function () {
        Route::controller(RecepcionController::class)->group(function () {
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
            Route::get('/{id}', 'show')->name('show');
        });
    });


});

require __DIR__.'/settings.php';
