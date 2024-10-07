<?php

namespace App\Observers;

use App\Models\Estudiante;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;

class EmailObserver implements Observer
{
    protected Collection $estudiantes;

    public function __construct(Collection $estudiantes)
    {
        $this->estudiantes = $estudiantes;
    }

    public function update($data)
    {
        $emailData = [
            'nombre_producto' => $data['nombre_producto'],
            'nombre_emprendimiento' => $data['nombre_emprendimiento'],
            'descripcion' => $data['descripcion'],
            'precio' => $data['precio']
        ];

        foreach ($this->estudiantes as $estudiante) {
            Mail::send('emails.nuevo_producto', $emailData, function ($message) use ($estudiante) {
                $message->to($estudiante->email)
                        ->subject('Nuevo producto disponible en tus favoritos');
            });
        }
    }
}
