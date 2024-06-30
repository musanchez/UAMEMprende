<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmprendimientoController;

Route::get('/', function () {
    return view('layouts.app');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas para Emprendimientos
Route::get('/emprendimientos', [EmprendimientoController::class, 'index'])->name('emprendimientos.index');
Route::get('/emprendimientos/create', [EmprendimientoController::class, 'create'])->name('emprendimientos.create');
Route::post('/emprendimientos', [EmprendimientoController::class, 'store'])->name('emprendimientos.store');
Route::get('/emprendimientos/{id}', [EmprendimientoController::class, 'show'])->name('emprendimientos.show');
Route::get('/emprendimientos/{id}/edit', [EmprendimientoController::class, 'edit'])->name('emprendimientos.edit');
Route::put('/emprendimientos/{id}', [EmprendimientoController::class, 'update'])->name('emprendimientos.update');
Route::delete('/emprendimientos/{id}', [EmprendimientoController::class, 'destroy'])->name('emprendimientos.destroy');
