<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'descripcion',
        'stock',
        'tipo',
        'categoria_id',
        'eliminado',
    ];

    protected $casts = [
        'precio' => 'float',
        'stock' => 'int',
        'eliminado' => 'bool',
    ];

    public function categoria(){
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function producto_presupuestos()
    {
        return $this->hasMany(ProductoPresupuesto::class, 'producto_id');
    }

}
