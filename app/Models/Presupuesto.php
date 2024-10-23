<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;
    protected $table = 'TPresupuestos';

    protected $fillable = [
        'proyecto_id',
        'nom_pres',
        'precio_total',
        'pago',
        'iva',
        'estado',
        'aceptado',
        'eliminado',
    ];

    protected $casts = [
        'aceptado' => 'bool',
        'eliminado' => 'bool',
    ];

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function productoPresupuestos()
    {
        return $this->hasMany(ProductoPresupuesto::class, 'presupuesto_id');
    }
}
