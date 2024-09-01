<?php

namespace App\Http\Controllers;

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

        $query = Visita::where('eliminado', false)
                    ->orderBy('fecha_inicio', 'asc');

        if ($search) {
            $query->whereHas('cliente', function($q) use ($search) {
                $q->where('nombre', 'like', "%$search%");
            });
        }

        $visitas = $query->paginate(15);

        $visitasBaja = Visita::where('eliminado', false)
                            ->where('prioridad', 'Baja')
                            ->orderBy('fecha_inicio', 'asc')
                            ->paginate(15);

        $visitasMedia = Visita::where('eliminado', false)
                            ->where('prioridad', 'Media')
                            ->orderBy('fecha_inicio', 'asc')
                            ->paginate(15);

        $visitasAlta = Visita::where('eliminado', false)
                            ->where('prioridad', 'Alta')
                            ->orderBy('fecha_inicio', 'asc')
                            ->paginate(15);

        // Redirigir a la última página si no hay visitas y hay más de una página
        if ($visitas->count() == 0 && $visitas->lastPage() > 1) {
            return redirect()->route('visita.index', ['page' => $visitas->lastPage() - 1, 'tab' => $tab]);
        }

        return view('pages/visita.index',
            compact(
                'visitas',
                'visitasBaja',
                'visitasMedia',
                'visitasAlta',
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
        //dd($request->all());
        // Validar los datos recibidos
        $validatedData = $request->validate([
            'proyecto_id' => 'required|exists:TProyectos,proyecto_id',
            'descripcion' => 'string|max:255',
            'fecha_inicio' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'hora_fin' => 'nullable|date_format:H:i|after:hora_inicio',
            'contacto_visita' => 'required|string|max:255',
            'prioridad' => 'required|string|max:10',
        ]);

        // Crear la visita con los datos validados
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
