<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emprendimiento;

class PreferenciaController extends Controller
{
    //
    public function addFavorite(Request $request, Emprendimiento $emprendimiento)
    {
        $request->user()->preferencias()->updateOrCreate(
            ['emprendimiento_id' => $emprendimiento->id],
            ['favorito' => true]
        );

        return response()->json(['message' => 'Emprendimiento añadido a favoritos.']);
    }

    public function removeFavorite(Request $request, Emprendimiento $emprendimiento)
    {
        $request->user()->preferencias()->where('emprendimiento_id', $emprendimiento->id)->delete();

        return response()->json(['message' => 'Emprendimiento eliminado de favoritos.']);
    }

}
