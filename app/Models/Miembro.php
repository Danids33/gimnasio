<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Miembro extends Model
{
    use SoftDeletes;

    protected $table = 'miembros';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre_completo',
        'cedula',
        'telefono',
        'tipo_membresia',
        'fecha_inscripcion',
        'fecha_inicio',
        'fecha_fin',
        'esta_activo',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'fecha_inscripcion' => 'date',
            'fecha_inicio' => 'date',
            'fecha_fin' => 'date',
            'esta_activo' => 'boolean',
        ];
    }

    /**
     * Boot del modelo - actualiza automáticamente esta_activo basándose en fecha_fin
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($miembro) {
            // Si fecha_fin existe, actualizar esta_activo automáticamente
            if ($miembro->fecha_fin) {
                $miembro->esta_activo = $miembro->fecha_fin->isFuture();
            }
        });
    }
}
