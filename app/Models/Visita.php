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
        'eliminado',
    ];

    protected $casts = [
        'eliminado' => 'bool',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

}
