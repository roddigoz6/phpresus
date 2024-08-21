<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visita extends Model
{
    use HasFactory;
    protected $table = 'TVisita';

    protected $fillable = [
        'proyecto_id',
        'fecha_visita',
        'hora_visita',
        'contacto_visita',
        'prioridad',
        'eliminado',
    ];

    protected $casts = [
        'eliminado' => 'bool',
    ];

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'proyecto_id');
    }

}
