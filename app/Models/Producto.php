<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $table = 'TProductos';

    protected $fillable = [
        'nombre',
        'precio',
        'leyenda',
        'stock',
        'tipo',
        'eliminado',
    ];

    protected $casts = [
        'precio' => 'float',
        'stock' => 'int',
        'eliminado' => 'bool',
    ];

    public function producto_presupuestos()
    {
        return $this->hasMany(ProductoPresupuesto::class, 'producto_id');
    }

}
