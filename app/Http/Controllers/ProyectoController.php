<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\Proyecto;
use App\Models\Presupuesto;
use App\Models\Visita;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tab = $request->input('tab', 'all');

        // Consulta base para proyectos activos
        $query = Proyecto::where('eliminado', false)
                    ->with('cliente');

        if ($search) {
            $query->whereHas('cliente', function($q) use ($search) {
                $q->where('nombre', 'like', "%$search%");
            });
        }

        // Proyectos activos
        $proyectos = $query->paginate(15);

        // Proyectos por estado
        $proyectosPresupuestado = Proyecto::where('eliminado', false)
                                        ->where('estado', 'presupuestado')
                                        ->with('cliente')
                                        ->paginate(15);

        $proyectosPresupuestoAceptado = Proyecto::where('eliminado', false)
                                                ->where('estado', 'presupuesto_aceptado')
                                                ->with('cliente')
                                                ->paginate(15);

        $proyectosFacturadoPendienteCobro = Proyecto::where('eliminado', false)
                                                    ->where('estado', 'facturado_pendiente_cobro')
                                                    ->with('cliente')
                                                    ->paginate(15);

        $proyectosFacturaCobrada = Proyecto::where('eliminado', false)
                                            ->where('estado', 'factura_cobrada')
                                            ->with('cliente')
                                            ->paginate(15);

        // Nuevos proyectos cerrados
        $proyectosCerrado = Proyecto::where('cerrado', true)
                                    ->where('eliminado', false)
                                    ->with('cliente')
                                    ->paginate(15);

        // Configuración para visitas de la semana
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();

        $visitas = Visita::whereBetween('fecha_inicio', [$inicioSemana, $finSemana])->get();
        $rangoSemana = $inicioSemana->translatedFormat('d \d\e F') . ' al ' . $finSemana->translatedFormat('d \d\e F');

        // Redirección si no hay proyectos en la primera página y hay más páginas
        if ($proyectos->count() == 0 && $proyectos->lastPage() > 1) {
            return redirect()->route('proyecto.index', ['page' => $proyectos->lastPage() - 1, 'tab' => $tab]);
        }

        return view('pages/proyecto.index', compact(
            'visitas',
            'proyectos',
            'proyectosPresupuestado',
            'proyectosPresupuestoAceptado',
            'proyectosFacturadoPendienteCobro',
            'proyectosFacturaCobrada',
            'proyectosCerrado',
            'rangoSemana',
            'tab'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Proyecto $proyecto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proyecto $proyecto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proyecto $proyecto)
    {
        //
    }

    public function aceptar(Request $request, $id)
    {
        // Obtén el proyecto por ID
        $proyecto = Proyecto::with(['presupuesto', 'cliente'])->find($id);

        if (!$proyecto) {
            return response()->json(['success' => false, 'message' => 'Proyecto no encontrado.'], 404);
        }

        try {
            // Actualiza el presupuesto relacionado y marca como aceptado
            $presupuesto = $proyecto->presupuesto;
            if ($presupuesto) {
                $presupuesto->aceptado = true;
                $presupuesto->save();
            } else {
                return response()->json(['success' => false, 'message' => 'Presupuesto no encontrado.'], 404);
            }

            // Actualiza el cliente relacionado
            $cliente = $proyecto->cliente;
            if ($cliente) {
                $cliente->establecido = true;
                $cliente->save();
            } else {
                return response()->json(['success' => false, 'message' => 'Cliente no encontrado.'], 404);
            }

            // Actualiza el estado del proyecto
            $proyecto->estado = 'presupuesto_aceptado';
            $proyecto->save();

            return response()->json(['success' => true, 'message' => 'El proyecto y el presupuesto han sido aceptados correctamente.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hubo un problema al aceptar el presupuesto: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            //
            $proyecto = Proyecto::where('proyecto_id', $id)->firstOrFail();
            $proyecto->update(['eliminado' => true]);

            Presupuesto::where('proyecto_id', $id)->update(['eliminado' => true]);
            Visita::where('proyecto_id', $id)->update(['eliminado' => true]);

            return response()->json(['success' => true, 'message' => 'Proyecto y registros relacionados eliminados correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hubo un problema al eliminar el proyecto.'], 500);
        }
    }
}
