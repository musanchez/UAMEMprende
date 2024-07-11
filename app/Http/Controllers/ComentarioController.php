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
    public function destroy(Comentario $comentario)
    {
        if (auth()->user()->id == $comentario->estudiante_id || auth()->user()->admin) {
            $comentario->delete();
            return redirect()->back()->with('success', 'Comentario eliminado con éxito.');
        } else {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar este comentario.');
        }
    }

    public function update(Request $request, Comentario $comentario)
    {
        if (auth()->user()->id == $comentario->estudiante_id || auth()->user()->admin) {
            $request->validate([
                'comentario' => 'required|string|max:255',
            ]);

            $comentario->update([
                'comentario' => $request->comentario,
            ]);

            return redirect()->back()->with('success', 'Comentario actualizado con éxito.');
        } else {
            return redirect()->back()->with('error', 'No tienes permiso para actualizar este comentario.');
        }
    }

}
