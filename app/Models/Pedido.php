<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;
    protected $fillable = [
        'estudiante_id',
        'emprendimiento_id',
        'mensaje',
        'estado',
    ];
    protected $attributes = [
        'estado' => 'pendiente',
    ];
    // Relación con el modelo Estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    // Relación con el modelo Emprendimiento
    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class);
    }
}
