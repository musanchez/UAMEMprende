<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'precio', 'oculto', 'emprendimiento_id'];


    public function emprendimiento()
    {
        return $this->belongsTo(Emprendimiento::class);
    }

    use HasFactory;
}
