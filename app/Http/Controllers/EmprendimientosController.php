<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprendimiento;
use App\Models\Estudiante;
use App\Models\Categoria;
use Illuminate\Support\Facades\Auth;


class EmprendimientosController extends Controller
{
    
    protected $redirectTo = '/';

    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $emprendimientos = Emprendimiento::all(); // Obtén todos los emprendimientos
        return view('emprendimientos.index', compact('emprendimientos'));
    }


    public function misEmprendimientos()
    {
        $user = Auth::user();
        $emprendimientos = $user->emprendimientos;
        return view('emprendimientos.misEmprendimientos', compact('emprendimientos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('emprendimientos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        // Validar y guardar los datos
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'required|string',
            'categoria_id' => 'required|integer|exists:categorias,id'
        ]);
    
        // Obtener el ID del usuario autenticado
        $emprendedor_id = Auth::id();
    
        // Asignar el ID del usuario autenticado al array de datos validados
        $validatedData['emprendedor_id'] = $emprendedor_id;
    
        // Crear el emprendimiento en la base de datos
        Emprendimiento::create($validatedData);


        return redirect()->route('emprendimientos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Emprendimiento $emprendimiento)
    {
        $productos = $emprendimiento->productos;
        return view('emprendimientos.show', compact('emprendimiento', 'productos'));
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
