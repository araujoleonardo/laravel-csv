<?php

use App\Http\Controllers\CargaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/carga', [CargaController::class, 'carga'])->name('carga');
