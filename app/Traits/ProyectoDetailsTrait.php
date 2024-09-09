<?php

namespace App\Traits;

use App\Models\Proyecto;

trait ProyectoDetailsTrait
{
    public function getProyectoDetails($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $cliente = $proyecto->cliente;
        $visitas = $proyecto->visitas;

        $presupuesto = $proyecto->presupuesto;
        if ($presupuesto) {
            $productoPresupuestos = $presupuesto->productoPresupuestos->sortBy('orden');
        } else {
            $productoPresupuestos = collect();
        }

        return compact('proyecto', 'cliente', 'visitas', 'productoPresupuestos');
    }
}
