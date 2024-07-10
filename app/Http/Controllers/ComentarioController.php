<?php
namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'comentario' => 'required|string|max:255',
            'estudiante_id' => 'required|exists:estudiantes,id',
            'emprendimiento_id' => 'required|exists:emprendimientos,id',
        ]);

        // Crear un nuevo comentario
        $comentario = Comentario::create([
            'comentario' => $request->comentario,
            'estudiante_id' => $request->estudiante_id,
            'emprendimiento_id' => $request->emprendimiento_id,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('emprendimientos.show', $request->emprendimiento_id)->with('success', 'Comentario añadido exitosamente.');
    }
}
