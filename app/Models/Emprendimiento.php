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
        'categoria_id'
    ];

    public function emprendedor()
    {
        return $this->belongsTo(Estudiante::class, 'emprendedor_id');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function preferencias()
    {
        return $this->hasMany(Preferencia::class);
    }

    public function promedioCalificaciones()
    {
        return $this->preferencias()->whereNotNull('calificacion')->avg('calificacion');
    }

}
