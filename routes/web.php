<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Models\Estudiante;
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
use App\Http\Controllers\PreferenciaController;
use App\Http\Controllers\EstudianteController;

Auth::routes();

Route::get('/', [App\Http\Controllers\EmprendimientosController::class, 'index'])->name('emprendimientos.index');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/estudiantes', [App\Http\Controllers\EstudianteController::class, 'index']) -> name('estudiantes.index');

Route::get('/misEmprendimientos', [App\Http\Controllers\EmprendimientosController::class, 'misEmprendimientos']) ->name('misEmprendimientos');

Route::get('/emprendimientos', [App\Http\Controllers\EmprendimientosController::class, 'index'])->name('emprendimientos.index');

Route::get('/crear-emprendimiento', [App\Http\Controllers\EmprendimientosController::class, 'create'])->name('crear.emprendimiento');

// Route::get('/categorias', [App\Http\Controllers\CategoriasController::class, 'index'])->name('categorias.index');

Route::post('/post-emprendimiento', [App\Http\Controllers\EmprendimientosController::class, 'store'])->name('guardar.emprendimiento');

Route::get('/emprendimiento/{emprendimiento}', [App\Http\Controllers\EmprendimientosController::class, 'show'])->name('emprendimientos.show');

Route::get('/emprendimiento/{id}/editarscreen', [App\Http\Controllers\EmprendimientosController::class, 'showEmprendimientoEditScreen'])->name('editar.emprendimiento');

Route::put('/emprendimiento/{id}/editarbd', [App\Http\Controllers\EmprendimientosController::class, 'update'])->name('actualizar.emprendimiento');

Route::delete('/emprendimiento/{id}/eliminar', [App\Http\Controllers\EmprendimientosController::class, 'destroy'])->name('eliminar.emprendimiento');

Route::get('/emprendimiento/{id}/productos', [App\Http\Controllers\EmprendimientosController::class, 'emprendimientoProductos'])->name('emprendimiento.productos');

Route::get('emprendimientos/{emprendimiento_id}/productos/create', [App\Http\Controllers\ProductoController::class, 'create'])->name('crear.producto');

Route::post('/emprendimientos/{emprendimiento_id}/productos', [App\Http\Controllers\ProductoController::class, 'store'])->name('crear.producto.store');

Route::get('/emprendimientos/{emprendimiento}/productos/{producto}/editar', [App\Http\Controllers\ProductoController::class, 'edit'])->name('editar.producto');

Route::put('/emprendimientos/{emprendimiento}/productos/{producto}', [App\Http\Controllers\ProductoController::class, 'update'])->name('editar.producto.update');

Route::post('/comentarios', [App\Http\Controllers\ComentarioController::class, 'store'])->name('comentarios.store');


Route::get('/favorites', [App\Http\Controllers\EmprendimientosController::class, 'favoritos'])->name('favorites');
Route::post('/favorites/add/{emprendimiento}', [PreferenciaController::class, 'addFavorite'])->name('favorites.add');
Route::post('/favorites/remove/{emprendimiento}', [PreferenciaController::class, 'removeFavorite'])->name('favorites.remove');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/{id}/edit', [EstudianteController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id}', [EstudianteController::class, 'update'])->name('profile.update');
});

Route::get('/estudiantes', [EstudianteController::class, 'index'])->name('estudiantes');
Route::post('/estudiantes/{id}/activar', [EstudianteController::class, 'activar'])->name('estudiantes.activar');
Route::post('/estudiantes/{id}/desactivar', [EstudianteController::class, 'desactivar'])->name('estudiantes.desactivar');

Route::post('/calificar-emprendimiento', [PreferenciaController::class, 'storeOrUpdate'])->name('calificar.emprendimiento');