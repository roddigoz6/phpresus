<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    protected $primaryKey = 'proyecto_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'TProyectos';

    protected $fillable = [
        'proyecto_id',
        'cliente_id',
        'estado',
        'serie_ref',
        'num_ref',
        'pago',
        'eliminado',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($proyecto){
            $year = date('y');
            $count = Proyecto::whereYear('created_at', date('Y'))->count() + 1;
            $numero = str_pad($count, 5, '0', STR_PAD_LEFT);
            $proyecto->proyecto_id = $numero . '/' . $year;
        });
    }

    protected $casts = [
        'eliminado' => 'bool',
    ];

    public function presupuesto()
    {
        return $this->hasOne(Presupuesto::class, 'proyecto_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}