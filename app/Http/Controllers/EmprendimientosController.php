<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprendimiento;
use App\Models\Estudiante;
use App\Models\Categoria;
use App\Models\EstadoEmp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\decorator\concretos\CategoriaFiltro;
use App\decorator\concretos\NombreFiltro;
use App\decorator\BaseEmprendimientoFiltro;
use App\decorator\EmprendimientoFiltro;
use App\decorator\EmprendimientoFiltroDecorador;


class EmprendimientosController extends Controller
{

    protected $redirectTo = 'uamEmprende';

    /**
     * Display a listing of the resource.
     */
    /*public function index(Request $request)
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
    */

    public function index(Request $request)
    {
        // Obtenemos todos los emprendimientos
        $emprendimientos = Emprendimiento::query();

        // Creamos el filtro base
        $filter = new BaseEmprendimientoFiltro();

        // Aplicamos el filtro por nombre si se proporciona
        if ($request->filled('search')) {
            $filter = new NombreFiltro($filter, $request->input('search'));
        }

        // Aplicamos el filtro por categoría si se selecciona
        if ($request->filled('category') && $request->category != '') {
            $filter = new CategoriaFiltro($filter, $request->input('category'));
        }

        // Finalmente, aplicamos todos los filtros al query de emprendimientos
        $emprendimientosFiltrados = $filter->filter($emprendimientos)->get();

        $categorias = Categoria::all();

        return view('emprendimientos.index', compact('emprendimientosFiltrados', 'categorias'));
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

    public function listarPendientes()
    {
        $categorias = Categoria::all(); // Asumiendo que tienes un modelo Categoria
    
        // Obtener los emprendimientos pendientes
        $emprendimientos = Emprendimiento::whereHas('estado_emp', function ($query) {
            $query->where('nombre', 'PENDIENTE');
        })->with(['emprendedor', 'categoria'])->get();
    
        return view('emprendimientos.showPendientes', compact('emprendimientos', 'categorias'));
    }

    public function pendientes(Request $request)
        {
        $search = $request->query('search');
        $category = $request->query('category');

        $query = Emprendimiento::whereHas('estado_emp', function ($q) {
            $q->where('nombre', 'PENDIENTE');
        });

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                ->orWhere('descripcion', 'LIKE', "%{$search}%");
            });
        }

        if ($category) {
            $query->where('categoria_id', $category);
        }

        $emprendimientos = $query->get();
        $categorias = Categoria::all();

        return view('emprendimientos.showPendientes', compact('emprendimientos', 'categorias'));
    }

    public function show(Emprendimiento $emprendimiento)
    {
        $productos = $emprendimiento->productos;
        return view('emprendimientos.show', compact('emprendimiento', 'productos'));
        //
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('emprendimientos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Imagen opcional
            'categoria_id' => 'required|integer|exists:categorias,id',
        ]);

        $imagePath = null;

        // Procesar la imagen si se ha subido
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $fileName = time() . '_arte_emprendimiento_' . $file->getClientOriginalName();
            $imagePath = $file->storeAs('emprendimientos', $fileName, 'public');
        } else {
            // Asignar una imagen predeterminada si no se sube ninguna
            $imagePath = 'emprendimientos/default.jpg';
        }

        // Crear el emprendimiento con la imagen procesada
        $emprendimiento = Emprendimiento::create([
            'nombre' => $validatedData['nombre'],
            'descripcion' => $validatedData['descripcion'],
            'imagen' => $imagePath, // Usa la ruta procesada o la predeterminada
            'categoria_id' => $validatedData['categoria_id'],
            'emprendedor_id' => Auth::id(),
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('emprendimientos.index')
            ->with('success', 'Emprendimiento creado correctamente');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function update(int $id, Request $request)
    {
        // Buscar el emprendimiento por ID
        $emprendimiento = Emprendimiento::findOrFail($id);

        // Validar los datos de entrada
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Imagen opcional
            'categoria_id' => 'required|integer|exists:categorias,id',
        ]);

        // Manejo de la imagen cargada o uso de la predeterminada
        if ($request->hasFile('imagen')) {
            // Subir nueva imagen
            $file = $request->file('imagen');
            $fileName = time() . '_emprendimiento_' . str_replace(' ', '_', $validatedData['nombre']) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('emprendimientos', $fileName, 'public');
            $validatedData['imagen'] = $imagePath;

            // Eliminar la imagen anterior si existía y no era la predeterminada
            if ($emprendimiento->imagen && $emprendimiento->imagen !== 'emprendimientos/default.jpg') {
                Storage::disk('public')->delete($emprendimiento->imagen);
            }
        } else {
            // Asignar la imagen predeterminada si no se subió una nueva
            $validatedData['imagen'] = $emprendimiento->imagen ?? 'emprendimientos/default.jpg';
        }

        // Actualizar los datos del emprendimiento
        $emprendimiento->update($validatedData);

        // Redirigir con mensaje de éxito
        return redirect()->route('misEmprendimientos')
            ->with('success', 'Emprendimiento actualizado correctamente.');
    }





    // EmprendimientoController.php

    public function favoritos()
    {
        $emprendimientos = Emprendimiento::whereHas('preferencias', function ($query) {
            $query->where('estudiante_id', auth()->id())->where('favorito', true);
        })->whereHas('estado_emp', function ($query) {
            $query->where('nombre', 'VERIFICADO');
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

    public function validar($id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        $estadoVerificado = EstadoEmp::where('nombre', 'VERIFICADO')->first();
        
        if ($estadoVerificado) {
            $emprendimiento->estado_emp_id = $estadoVerificado->id;
            $emprendimiento->save();

            return redirect()->route('emprendimientos.pendientes')->with('success', 'Emprendimiento validado exitosamente.');
        } else {
            return redirect()->route('emprendimientos.pendientes')->with('error', 'Error al validar el emprendimiento.');
        }
    }

    public function rechazar($id)
    {
        $emprendimiento = Emprendimiento::findOrFail($id);
        $estadoRechazado = EstadoEmp::where('nombre', 'RECHAZADO')->first();

        if ($estadoRechazado) {
            $emprendimiento->estado_emp_id = $estadoRechazado->id;
            $emprendimiento->save();

            return redirect()->route('emprendimientos.pendientes')->with('success', 'Emprendimiento rechazado exitosamente.');
        } else {
            return redirect()->route('emprendimientos.pendientes')->with('error', 'Error al rechazar el emprendimiento.');
        }
    }
}

