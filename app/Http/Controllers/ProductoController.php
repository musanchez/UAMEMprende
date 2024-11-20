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
            'descripcion' => 'required|string|max:1000',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Imagen opcional
            'precio' => 'required|numeric',
            'oculto' => 'nullable|boolean'
        ]);

        $imagePath = 'productos/logo.png'; // Imagen por defecto

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $imagePath = $file->storeAs('productos', $fileName, 'public');
        }

        // Crear el producto vinculado al emprendimiento
        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagen' => $imagePath,
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
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Imagen opcional
            'precio' => 'required|numeric',
            'oculto' => 'nullable|boolean'
        ]);

        // Si se carga una nueva imagen, procesarla
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Generar un nombre único
            $path = $file->storeAs('productos', $fileName, 'public'); // Guardar en public/productos
            $producto->imagen = $path; // Actualizar la ruta en la base de datos
        }

        // Actualizar los demás campos
        $producto->nombre = $request->input('nombre');
        $producto->descripcion = $request->input('descripcion');
        $producto->precio = $request->input('precio');
        $producto->oculto = $request->input('oculto', 0); // Por defecto, no oculto si no se envía el valor
        $producto->save();

        // Redirigir a la lista de productos con mensaje de éxito
        return redirect()->route('emprendimiento.productos', $emprendimiento->id)
            ->with('success', 'Producto actualizado correctamente.');
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
