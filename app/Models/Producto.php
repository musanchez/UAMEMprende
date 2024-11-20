<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'precio', 'oculto', 'emprendimiento_id', 'imagen'];


    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class);
    }

    use HasFactory;

    public function getImagenAttribute($value)
    {
        return $value ?? asset('logo.png');
    }

    protected $casts = [
        'oculto' => 'boolean',
    ];
}
