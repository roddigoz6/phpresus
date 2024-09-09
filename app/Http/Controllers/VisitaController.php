<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Visita;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->input('search');
        $tab = $request->input('tab', 'all');

        $today = Carbon::today();
        $threeDaysFromNow = Carbon::today()->addDays(3);

        // Consulta base para todas las visitas
        $query = Visita::where('eliminado', false)
                        ->orderBy('fecha_inicio', 'asc');

        if ($search) {
            $query->whereHas('cliente', function($q) use ($search) {
                $q->where('nombre', 'like', "%$search%");
            });
        }

        $visitas = $query->paginate(15);
        $queryBaja = clone $query;
        $visitasBaja = $queryBaja->where('prioridad', 'Baja')->paginate(15);

        $queryMedia = clone $query;
        $visitasMedia = $queryMedia->where('prioridad', 'Media')->paginate(15);

        $queryAlta = clone $query;
        $visitasAlta = $queryAlta->where('prioridad', 'Alta')->paginate(15);

        $queryAntiguas = clone $query;
        $queryAntiguas->whereDate('fecha_inicio', '<', $today)
                    ->whereNotNull('nota_cerrar')
                    ->where('nota_cerrar', '!=', '');

        $visitasAntiguas = $queryAntiguas->paginate(15);

        if ($visitas->count() == 0 && $visitas->lastPage() > 1) {
            return redirect()->route('visita.index', ['page' => $visitas->lastPage() - 1, 'tab' => $tab]);
        }

        return view('pages/visita.index', compact(
            'visitas',
            'visitasBaja',
            'visitasMedia',
            'visitasAlta',
            'visitasAntiguas',
            'today',
            'threeDaysFromNow',
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

    public function cerrar(Request $request, $id)
    {
        $request->validate([
            'nota_cerrar' => 'required|string|max:255',
        ]);

        $visita = Visita::findOrFail($id);
        $proyecto = $visita->proyecto;

        $fechaHoraFin = now();
        $fecha_fin = $fechaHoraFin->toDateString();
        $hora_fin = $fechaHoraFin->toTimeString();

        // Actualiza los campos de la visita
        $visita->update([
            'nota_cerrar' => $request->nota_cerrar,
            'fecha_fin' => $fecha_fin,
            'hora_fin' => $hora_fin,
        ]);

        // Verifica el estado del proyecto y actualiza solo si es necesario
        if ($proyecto->estado !== 'por_facturar') {
            $proyecto->update([
                'estado' => 'por_facturar',
            ]);
            $mensaje = 'Visita cerrada. Proyecto ' . $proyecto->proyecto_id . ' pendiente de factura.';
        } else {
            $mensaje = 'Visita cerrada del proyecto ' . $proyecto->proyecto_id . '.';
        }

        // Redireccionar con mensaje de éxito
        return redirect()->route('proyecto.index')->with('success_visita_cerrar', $mensaje);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //dd($request->all());
        $validatedData = $request->validate([
            'proyecto_id' => 'required|exists:TProyectos,proyecto_id',
            'descripcion' => 'nullable|string|max:255',
            'fecha_inicio' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'hora_fin' => [
                'nullable',
                'date_format:H:i',
                function ($attribute, $value, $fail) use ($request) {
                    $fechaInicio = $request->input('fecha_inicio');
                    $fechaFin = $request->input('fecha_fin');
                    $horaInicio = $request->input('hora_inicio');

                    if ($fechaInicio === $fechaFin && $value <= $horaInicio) {
                        $fail('La hora de fin debe ser posterior a la hora de inicio cuando la fecha de fin es la misma que la fecha de inicio.');
                    }
                },
            ],
            'contacto_visita' => 'required|string|max:255',
            'prioridad' => 'required|string|max:10',
        ]);

        //dd($validatedData);
        $visita = Visita::create([

            'proyecto_id' => $validatedData['proyecto_id'],
            'descripcion' => $validatedData['descripcion'],
            'fecha_inicio' => $validatedData['fecha_inicio'],
            'hora_inicio' => $validatedData['hora_inicio'],
            'fecha_fin' => $validatedData['fecha_fin'],
            'hora_fin' => $validatedData['hora_fin'],
            'contacto_visita' => $validatedData['contacto_visita'],
            'prioridad' => $validatedData['prioridad'],
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('visita.index')->with('success_vis', 'Visita agendada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Visita $visita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Visita $visita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Visita $visita)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        try {
            $visita = Visita::findOrFail($id);
            $visita->update(['eliminado' => true]);

            return response()->json(['success' => true, 'message' => 'Visita eliminada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hubo un problema al eliminar la visita.'], 500);
        }
    }
}
