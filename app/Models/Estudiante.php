<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Estudiante extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'cif',
        'nombre',
        'apellido',
        'email',
        'password',
        'celular',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function emprendimientos()
    {
        return $this->hasMany(Emprendimiento::class, 'emprendedor_id');
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function carrera()
    {
        return $this->belongsTo(Estudiante::class);
    }
}
