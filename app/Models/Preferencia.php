<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preferencia extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'favorito',
        'calificacion',
        'estudiante_id',
        'emprendimiento_id'
    ];

    protected $casts = [
        'favorito' => 'boolean',
        'calificacion' => 'integer'
    ];

    public function estudiante() {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function emprendimiento() {
        return $this->belongsTo(Emprendimiento::class, 'emprendimiento_id');
    }
    
}
