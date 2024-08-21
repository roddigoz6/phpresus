<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $table = 'TFacturas';

    protected $fillable = [
        'orden_id',
        'eliminado',
    ];

    protected $casts = [
        'eliminado' => 'bool',
    ];

}
