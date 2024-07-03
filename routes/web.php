<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/', function () {
    //return view('layouts.app');
    return view('emprendimientos.index');
});
*/


Auth::routes();

Route::get('/', [App\Http\Controllers\EmprendimientosController::class, 'index'])->name('emprendimientos.index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/estudiantes', [App\Http\Controllers\EstudianteController::class, 'index']) -> name('estudiantes.index');

Route::get('/emprendimientos', [App\Http\Controllers\EmprendimientosController::class, 'index'])->name('emprendimientos.index');

Route::get('/crear-emprendimiento', [App\Http\Controllers\EmprendimientosController::class, 'create'])->name('crear.emprendimiento');

Route::get('/categorias', [App\Http\Controllers\CategoriasController::class, 'index'])->name('categorias.index');

Route::post('/post-emprendimiento', [App\Http\Controllers\EmprendimientosController::class, 'store'])->name('guardar.emprendimiento');