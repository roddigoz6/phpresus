<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
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

    public function orden()
    {
        return $this->hasMany(Orden::class, 'presupuesto_id');
    }

    public function productoPresupuestos()
    {
        return $this->hasMany(ProductoPresupuesto::class, 'presupuesto_id');
    }
}
