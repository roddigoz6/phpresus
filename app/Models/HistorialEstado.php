<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialEstado extends Model
{
    use HasFactory;
    protected $table = 'THistorialEstados';

    protected $fillable = [
        'proyecto_id',
        'visita_id',
        'presupuestado',
        'presupuesto_aceptado',
        'por_cobrar',
        'cerrado',
        'nota_cerrar'
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function visita()
    {
        return $this->belongsTo(Visita::class, 'visita_id');
    }
}
