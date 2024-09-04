<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;
    protected $table = 'TPresupuestos';

    protected $fillable = [
        'cliente_id',
        'proyecto_id',
        'precio_total',
        'aceptado',
        'eliminado',
    ];

    protected $casts = [
        'aceptado' => 'bool',
        'eliminado' => 'bool',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class, 'proyecto_id');
    }

    public function productoPresupuestos()
    {
        return $this->hasMany(ProductoPresupuesto::class, 'presupuesto_id');
    }
}
