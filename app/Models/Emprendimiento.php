<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Emprendimiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'emprendedor_id',
        'categoria_id',
        'estado_emp_id'
    ];

    protected static function boot()
    {
        parent::boot();

        // Asignar el estado 'PENDIENTE' por defecto antes de crear un nuevo emprendimiento
        static::creating(function ($emprendimiento) {
            $estadoPendienteId = DB::table('estados_emps')->where('nombre', 'PENDIENTE')->value('id');
            $emprendimiento->estado_emp_id = $estadoPendienteId;
        });
    }

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

    public function estadoEmp()
    {
        return $this->belongsTo(EstadoEmp::class, 'estado_emp_id');
    }

}
