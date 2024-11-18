<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return Inertia::render('Quotation');
});
Route::get('/clientes', [ClienteController::class, 'index']);
Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/create', [ClienteController::class, 'create']);
Route::post('/clientes', [ClienteController::class, 'store'])->name('clientes.store');
