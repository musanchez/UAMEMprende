<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprendimiento;
use App\Models\Preferencia;

class PreferenciaController extends Controller
{
    //
    public function addFavorite(Request $request, Emprendimiento $emprendimiento)
    {
        $preferencia = Preferencia::updateOrCreate(
            [
                'estudiante_id' => auth()->id(),
                'emprendimiento_id' => $emprendimiento->id
            ],
            [
                'favorito' => true
            ]
        );

        return response()->json(['message' => 'Emprendimiento añadido a favoritos!', 'favorito' => true]);
    }

    public function removeFavorite(Request $request, Emprendimiento $emprendimiento)
    {
        $preferencia = Preferencia::where('estudiante_id', auth()->id())
            ->where('emprendimiento_id', $emprendimiento->id)
            ->update(['favorito' => false]);

        return response()->json(['message' => 'Emprendimiento eliminado de favoritos!', 'favorito' => false]);
    }

    public function storeOrUpdate(Request $request)
    {
        // Validar el formulario, asegurándonos de recibir la calificación
        $request->validate([
            'calificacion' => 'required|integer|min:0|max:5',
            'estudiante_id' => 'required|exists:estudiantes,id',
            'emprendimiento_id' => 'required|exists:emprendimientos,id',
        ]);

        $estudiante_id = $request->estudiante_id;
        $emprendimiento_id = $request->emprendimiento_id;
        $calificacion = $request->calificacion;

        // Verificar si ya existe una preferencia para este estudiante y emprendimiento
        $preferencia = Preferencia::where('estudiante_id', $estudiante_id)
                                  ->where('emprendimiento_id', $emprendimiento_id)
                                  ->first();

        if ($preferencia) {
            // Si existe, actualizamos la calificación existente
            $preferencia->calificacion = $calificacion;
            $preferencia->save();
        } else {
            // Si no existe, creamos una nueva preferencia con la calificación
            Preferencia::create([
                'calificacion' => $calificacion,
                'estudiante_id' => $estudiante_id,
                'emprendimiento_id' => $emprendimiento_id,
            ]);
        }

        // Redireccionar o devolver respuesta según sea necesario
        return redirect()->back()->with('success', 'Calificación guardada correctamente.');
    }
}
