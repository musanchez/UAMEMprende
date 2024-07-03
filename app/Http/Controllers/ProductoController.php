<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Emprendimiento;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Show the form for creating a new product.
     */
    public function create($emprendimientoId)
    {
        // Puedes pasar el ID del emprendimiento a la vista si es necesario
        return view('productos.create', ['emprendimientoId' => $emprendimientoId]);
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'oculto' => 'boolean',
            'emprendimiento_id' => 'required|exists:emprendimientos,id',
        ]);

        // Crear un nuevo producto
        Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'oculto' => $request->oculto ?? false,
            'emprendimiento_id' => $request->emprendimiento_id,
        ]);

        // Redirigir a algún lugar después de guardar, por ejemplo a la lista de productos del emprendimiento
        return redirect()->route('emprendimientos.show', $request->emprendimiento_id)->with('success', 'Producto creado exitosamente.');
    }
}
