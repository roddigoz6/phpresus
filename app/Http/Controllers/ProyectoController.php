<?php

namespace App\Http\Controllers;

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

        $query = Proyecto::where('eliminado', false)
                    ->with('cliente');

        if ($search) {

            $query->whereHas('cliente', function($q) use ($search) {
                $q->where('nombre', 'like', "%$search%");
            });
        }

        $proyectos = $query->paginate(15);
        $proyectosPresupuesto = Proyecto::where('eliminado', false)
                                    ->where('estado', 'Presupuestado')
                                    ->with('cliente')
                                    ->paginate(15);
        $proyectosVisita = Proyecto::where('eliminado', false)
                                    ->where('estado', 'Visita')
                                    ->with('cliente')
                                    ->paginate(15);
        $proyectosRealizado = Proyecto::where('eliminado', false)
                                    ->where('estado', 'Realizado')
                                    ->with('cliente')
                                    ->paginate(15);
        $proyectosFinalizado = Proyecto::where('eliminado', false)
                                    ->where('estado', 'Finalizado')
                                    ->with('cliente')
                                    ->paginate(15);
        $proyectosCobrado = Proyecto::where('eliminado', false)
                                    ->where('estado', 'Cobrado')
                                    ->with('cliente')
                                    ->paginate(15);
        $proyectosCerrado = Proyecto::where('eliminado', false)
                                    ->where('estado', 'Cerrado')
                                    ->with('cliente')
                                    ->paginate(15);

        if ($proyectos->count() == 0 && $proyectos->lastPage() > 1) {
            return redirect()->route('proyecto.index', ['page' => $proyectos->lastPage() - 1, 'tab' => $tab]);
        }

        return view('pages/proyecto.index', compact(
            'proyectos',
            'proyectosPresupuesto',
            'proyectosVisita',
            'proyectosRealizado',
            'proyectosFinalizado',
            'proyectosCobrado',
            'proyectosCerrado',
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
