<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoPresupuesto extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_id',
        'presupuesto_id',
        'precio',
        'cantidad',
        'orden_prod',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class, 'presupuesto_id');
    }
}
