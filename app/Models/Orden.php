<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $table = 'ordenes';

    protected $fillable = [
        'presupuesto_id',
        'cliente_id',
        'cliente_nombre',
        'cliente_apellido',
        'cliente_dni',
        'precio_total',
        'cobrado',
        'eliminado',
    ];

    protected $casts = [
        'cobrado' => 'bool',
        'eliminado' => 'bool',
    ];

    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class, 'presupuesto_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function productoOrden()
    {
        return $this->hasMany(ProductoOrden::class, 'orden_id');
    }
}
