<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoEmp extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];
    
    public $timestamps = false; // Deshabilita las columnas `created_at` y `updated_at`

}
