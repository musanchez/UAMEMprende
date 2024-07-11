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
    public function index(Request $request)
    {
        $query = Emprendimiento::query();

        $query->whereHas('emprendedor', function ($q) {
            $q->where('status', true);
        });

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->search . '%')
                    ->orWhere('descripcion', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('categoria_id', $request->category);
        }

        $emprendimientos = $query->get();
        $categorias = Categoria::all();

        return view('emprendimientos.index', compact('emprendimientos', 'categorias'));
    }



    public function misEmprendimientos()
    {
        $user = Auth::user();
        $emprendimientos = $user->emprendimientos;
        return view('emprendimientos.misEmprendimientos', compact('emprendimientos'));
    }

    public function emprendimientoProductos($id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        $productos = $emprendimiento->productos;
        return view('emprendimientos.productosEmprendimiento', compact('emprendimiento', 'productos'));
    }

    public function showEmprendimientoEditScreen($id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        $categorias = Categoria::all(); // Assuming you have a Categoria model
        return view('emprendimientos.editar', compact('emprendimiento', 'categorias'));
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
        $emp = Emprendimiento::create($validatedData);


        return redirect()->route('emprendimientos.show', $emp);
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
    public function update(int $id, Request $request)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);

        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'required|string',
            'categoria_id' => 'required|integer|exists:categorias,id'
        ]);

        $emprendimiento->update($validatedData);

        return redirect()->route('misEmprendimientos')
            ->with('success', 'Emprendimiento actualizado correctamente');
    }

    // EmprendimientoController.php

    public function favoritos()
    {
        $userId = auth()->id();
        $emprendimientos = Emprendimiento::whereHas('preferencias', function ($query) use ($userId) {
            $query->where('estudiante_id', $userId)->where('favorito', true);
        })->get();

        return view('emprendimientos.favoritos', compact('emprendimientos'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        $emprendimiento->delete();

        return redirect()->route('misEmprendimientos')->with('success', 'Emprendimiento eliminado con éxito');
    }
}
