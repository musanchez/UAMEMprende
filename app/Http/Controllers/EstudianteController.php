<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Estudiante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = Estudiante::with('carrera')->where('admin', false)->get();
        return view('estudiantes.index', compact('usuarios'));
    }

    public function activar($id)
    {
        $usuario = Estudiante::findOrFail($id);
        $usuario->status = true;
        $usuario->save();

        return response()->json(['success' => true, 'message' => 'Usuario activado correctamente']);
    }

    public function desactivar($id)
    {
        $usuario = Estudiante::findOrFail($id);
        $usuario->status = false;
        $usuario->save();

        return response()->json(['success' => true, 'message' => 'Usuario desactivado correctamente']);
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->id != $id) {
            return redirect()->route('home')->with('error', 'No puedes actualizar el perfil de otro usuario.');
        }

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'carrera_id' => 'required|exists:carreras,id',
            'current_password' => 'required|string',
            'new_password' => 'nullable|string|min:8|confirmed'
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.'])->withInput();
        }

        $user->nombre = $request->nombre;
        $user->apellido = $request->apellido;
        $user->carrera_id = $request->carrera_id;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('emprendimientos.index')->with('success', 'Perfil actualizado correctamente.');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        if ($user->id != $id) {
            return redirect()->route('home')->with('error', 'No puedes editar el perfil de otro usuario.');
        }
        $carreras = Carrera::all();

        // Obtener la información del usuario y pasarla a la vista
        return view('estudiantes.edit', compact('user', 'carreras'));
        //
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
