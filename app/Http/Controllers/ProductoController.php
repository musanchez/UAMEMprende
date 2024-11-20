<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Emprendimiento;
use Illuminate\Http\Request;
use App\Observers\ProductoSubject;
use App\Observers\EmailObserver;
use App\Observers\Subject; // Add this line to import the Subject class
use Maatwebsite\Excel\Facades\Excel; // Add this line to import the Excel facade
use App\Imports\ProductosImport; // Add this line to import the ProductosImport class

class ProductoController extends Controller
{
    /**
     * Show the form for creating a new product.
     */
    public function create($emprendimiento_id)
    {
        $emprendimiento = Emprendimiento::find($emprendimiento_id);
        return view('productos.create', compact('emprendimiento'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request, $emprendimiento_id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'imagen' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'oculto' => 'boolean',
        ]);

        // Crear el producto vinculado al emprendimiento
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'precio' => $request->precio,
            'emprendimiento_id' => $emprendimiento_id,
            'oculto' => $request->oculto
        ]);

        // Registrar el observador y notificar
        $subject = new ProductoSubject();
        $emailObserver = new EmailObserver();

        // Registrar el observador
        $subject->attach($emailObserver);

        // Notificar a los observadores sobre el nuevo producto
        $subject->notify($producto);  // Notificar si corresponde


        // Redirigir a algún lugar después de guardar, por ejemplo a la lista de productos del emprendimiento
        return redirect()->route('emprendimiento.productos', $emprendimiento_id)->with('success', 'Producto creado exitosamente.');
    }

    public function edit(Emprendimiento $emprendimiento, Producto $producto)
    {
        return view('productos.editar', compact('emprendimiento', 'producto'));
    }

    public function update(Request $request, Emprendimiento $emprendimiento, Producto $producto)
    {
        // Validate the request data
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'imagen' => 'required',
            'precio' => 'required'
        ]);

        // Update the producto
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->imagen = $request->input('imagen');
        $producto->precio = $request->input('precio');
        $producto->oculto = $request->input('oculto');
        $producto->save();

        // Redirect back to the producto list
        return redirect()->route('emprendimiento.productos', $emprendimiento->id);
    }

    public function importarProductos(Request $request, Emprendimiento $emprendimiento)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls'
        ]);

        Excel::import(new ProductosImport($emprendimiento->id), $request->file('archivo'));

        return redirect()->back()->with('success', 'Productos importados correctamente.');
    }
}
