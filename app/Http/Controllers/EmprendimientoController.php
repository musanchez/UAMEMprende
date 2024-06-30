<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprendimiento;

class EmprendimientoController extends Controller
{
    public function index()
    {
        $emprendimientos = Emprendimiento::all();
        return view('layouts.emprendimientos', compact('emprendimientos'));
    }

    public function create()
    {
        return view('layouts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
        ]);

        Emprendimiento::create($request->all());

        return redirect()->route('emprendimientos.index')->with('success', 'Emprendimiento creado exitosamente.');
    }

    public function show($id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        return view('layouts.ver', compact('emprendimiento'));
    }

    public function edit($id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        return view('layouts.edit', compact('emprendimiento'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria' => 'required|string|max:255',
            'ubicacion' => 'required|string|max:255',
        ]);

        $emprendimiento = Emprendimiento::findOrFail($id);
        $emprendimiento->update($request->all());

        return redirect()->route('emprendimientos.index')->with('success', 'Emprendimiento actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        $emprendimiento->delete();

        return redirect()->route('emprendimientos.index')->with('success', 'Emprendimiento eliminado exitosamente.');
    }
}
