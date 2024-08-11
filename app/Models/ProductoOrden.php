<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoOrden extends Model
{
    use HasFactory;
    protected $table = 'producto_ordenes';

    protected $fillable = [
        'producto_id',
        'orden_id',
        'precio',
        'cantidad',
        'orden_prod',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function orden()
    {
        return $this->belongsTo(Presupuesto::class, 'orden_id');
    }
}
