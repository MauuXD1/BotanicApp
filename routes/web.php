<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GaleriaController;

Route::get('/', [GaleriaController::class, 'index'])->name('inicio');

