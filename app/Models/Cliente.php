<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'TClientes';

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'email',
        'movil',

        'contacto',
        'direccion',
        'cp',
        'poblacion',
        'provincia',
        'fax',
        'cargo',
        'titular_nom',
        'titular_ape',
        'direccion_envio',
        'cp_envio',
        'poblacion_envio',
        'provincia_envio',
        'pago',

        'establecido',
        'eliminado',
    ];

    protected $casts = [
        'establecido' => 'bool',
        'eliminado' => 'bool',
    ];

    public function presupuestos()
    {
        return $this->hasMany(Presupuesto::class, 'cliente_id');
    }

    public function proyectos()
    {
        return $this->hasMany(Proyecto::class, 'cliente_id');
    }

}
