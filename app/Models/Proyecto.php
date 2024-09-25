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
        'iva',
        'cerrado',
        'eliminado'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($proyecto){
            $year = date('y');
            $count = Proyecto::whereYear('created_at', date('Y'))->count() + 1;
            $numero = str_pad($count, 5, '0', STR_PAD_LEFT);
            $proyecto->proyecto_id = $numero . '-' . $year;
        });

        static::created(function ($proyecto) {
            $historial = new HistorialEstado([
                'proyecto_id' => $proyecto->proyecto_id,
                'presupuestado' => now(),
            ]);
            $historial->save();
        });

        static::updating(function ($proyecto) {

            if ($proyecto->isDirty('estado')) {

                $historial = HistorialEstado::where('proyecto_id', $proyecto->proyecto_id)->first();

                if ($historial) {
                    $estado = $proyecto->estado;
                    $historial->update([$estado => now()]);
                }
            }

            if ($proyecto->isDirty('cerrado') && $proyecto->cerrado) {

                $historial = HistorialEstado::where('proyecto_id', $proyecto->proyecto_id)->first();

                if ($historial) {
                    $historial->update(['cerrado' => now()]);
                }
            }
        });
    }

    protected $casts = [
        'cerrado' => 'bool',
        'eliminado' => 'bool',
    ];

    public function presupuesto()
    {
        return $this->hasMany(Presupuesto::class, 'proyecto_id');
    }

    public function visitas()
    {
        return $this->hasMany(Visita::class, 'proyecto_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
