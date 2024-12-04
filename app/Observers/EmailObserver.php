<?php

namespace App\Observers;

use App\Models\Producto;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;

class EmailObserver implements Observer
{
    public function update(mixed $data): void
    {
        // Verificar si el data es una instancia de Producto
        if ($data instanceof Producto && !$data->oculto) {
            // Obtener el emprendimiento vinculado al producto
            $emprendimiento = $data->emprendimiento;

            // Obtener los estudiantes que tienen este emprendimiento como favorito
            $estudiantesFavoritos = $emprendimiento->preferencias()
                ->where('favorito', true)
                ->with('estudiante')
                ->get()
                ->pluck('estudiante');

            // Enviar correos electrónicos a los estudiantes favoritos
            $emailData = [
                'nombre_producto' => $data->nombre,
                'descripcion' => $data->descripcion,
                'precio' => $data->precio,
                'nombre_emprendimiento' => $emprendimiento->nombre
            ];

            foreach ($estudiantesFavoritos as $estudiante) {
                Mail::send('emails.nuevo_producto', $emailData, function ($message) use ($estudiante) {
                    $message->to($estudiante->email)
                            ->subject('Nuevo producto disponible en tus favoritos');
                });
            }
        }
    }
}
