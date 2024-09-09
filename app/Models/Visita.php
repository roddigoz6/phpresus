<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;
    protected $table = 'TVisitas';

    protected $fillable = [
        'proyecto_id',
        'descripcion',
        'fecha_inicio',
        'hora_inicio',
        'fecha_fin',
        'hora_fin',
        'contacto_visita',
        'prioridad',
        'nota_cerrar',
        'eliminado',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($visita) {
            if ($visita->isDirty('nota_cerrar')) {
                $proyectoId = $visita->proyecto_id;

                $historial = new HistorialEstado([
                    'proyecto_id' => $proyectoId,
                    'visita_id' => $visita->id,
                    'nota_cerrar' => now(),
                ]);
                $historial->save();
            }
        });
    }

    protected $casts = [
        'eliminado' => 'bool',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

}
