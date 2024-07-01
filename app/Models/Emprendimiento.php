<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emprendimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'emprendedor_id',
    ];

    public function emprendedor()
    {
        return $this->belongsTo(Estudiante::class, 'emprendedor_id');
    }
}
