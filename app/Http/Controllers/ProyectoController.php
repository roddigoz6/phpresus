<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Traits\ProyectoDetailsTrait;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use App\Models\Cliente;

use App\Mail\ProyectoEnviado;
use App\Mail\ProformaEnviada;
use App\Models\Proyecto;
use App\Models\Producto;
use App\Models\Presupuesto;
use App\Models\Visita;

use Dompdf\Dompdf;
use Dompdf\Options;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    use ProyectoDetailsTrait;

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
            $query->where(function($q) use ($search) {
                $q->where(DB::raw('SUBSTRING_INDEX(proyecto_id, "-", 1)'), 'like', "%$search%")
                    ->orWhere('serie_ref', 'like', "%$search%")
                    ->orWhere('num_ref', 'like', "%$search%")
                    ->orWhereHas('cliente', function($q) use ($search) {
                        $q->where('nombre', 'like', "%$search%");
                    });
            });
        }

        // Proyectos activos
        $proyectos = $query
                    ->orderBy('proyecto_id', 'desc')
                    ->paginate(15);

        // Proyectos por estado
        $proyectosAbiertos = Proyecto::where('eliminado', false)
            ->where('estado', 'abierto')
            ->with('cliente')
            ->orderBy('proyecto_id', 'desc')
            ->paginate(15);

        $proyectosCerrados = Proyecto::where('eliminado', false)
            ->where('estado', 'cerrado')
            ->with('cliente')
            ->orderBy('proyecto_id', 'desc')
            ->paginate(15);

       // Proyectos activos
        $proyectos = $query
        ->orderBy('proyecto_id', 'desc')
        ->paginate(15);

        // Proyectos por estado
        $proyectosAbiertos = Proyecto::where('eliminado', false)
        ->where('estado', 'abierto')
        ->orderBy('proyecto_id', 'desc')
        ->paginate(15);

        $proyectosCerrados = Proyecto::where('eliminado', false)
        ->where('estado', 'cerrado')
        ->orderBy('proyecto_id', 'desc')
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
            'proyectosAbiertos',
            'proyectosCerrados',
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
        try {
            //
            $validatedData = $request->validate([
                'cliente_id' => 'nullable|exists:TClientes,id',
                'serie_ref' => 'string|max:255|nullable',
                'num_ref' => 'string|max:255|nullable',
                'pago' => 'string|max:255|nullable',
                'iva' => 'string|max:255|nullable',
            ]);

            if (empty($validatedData['cliente_id'])) {
                $validatedClient = $request->validate([
                    'nombre' => 'nullable|string|max:255',
                    'apellido' => 'nullable|string|max:255',
                    'dni' => 'nullable|string|max:9',
                    'email' => 'nullable|string|max:255',
                    'movil' => 'nullable|string|max:20',
                    'contacto' => 'nullable|string|max:255',
                    'direccion' => 'nullable|string|max:255',
                    'cp' => 'nullable|string|max:9',
                    'poblacion' => 'nullable|string|max:255',
                    'provincia' => 'nullable|string|max:255',
                    'fax' => 'nullable|string|max:255',
                    'cargo' => 'nullable|string|max:255',
                    'titular_nom' => 'nullable|string|max:255',
                    'titular_ape' => 'nullable|string|max:255',
                    'direccion_envio' => 'nullable|string|max:255',
                    'cp_envio' => 'nullable|string|max:9',
                    'poblacion_envio' => 'nullable|string|max:255',
                    'provincia_envio' => 'nullable|string|max:255',
                    'pago' => 'nullable|string|max:255',
                ]);

                $cliente = new Cliente();
                $cliente->fill($validatedClient);
                $cliente->pago = $validatedData['pago'];
                $cliente->save();

                $validatedData['cliente_id'] = $cliente->id;
            }

            $proyecto = new Proyecto();
            $proyecto->cliente_id = $validatedData['cliente_id'];
            $proyecto->estado = 'abierto';
            $proyecto->serie_ref = $validatedData['serie_ref'];
            $proyecto->num_ref = $validatedData['num_ref'];
            $proyecto->pago = $validatedData['pago'];
            $proyecto->iva = $validatedData['iva'];
            $proyecto->save();

            return response()->json(['success' => true, 'message' => 'Proyecto creado correctamente.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $cliente = $proyecto->cliente;
        $presupuesto = $proyecto->presupuesto;
        if ($presupuesto) {
            $productoPresupuestos = $presupuesto->productoPresupuestos->sortBy('orden');
        } else {
            $productoPresupuestos = collect();
        }

        //dd($productoPresupuestos);

        return view('pages/proyecto.show', compact('proyecto', 'cliente',  'productoPresupuestos'));
    }

    public function budget($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $cliente = $proyecto->cliente;
        $presupuesto = $proyecto->presupuesto;
        if ($presupuesto) {
            $productoPresupuestos = $presupuesto->productoPresupuestos->sortBy('orden');
        } else {
            $productoPresupuestos = collect();
        }

        return view('pages/proyecto.budget', compact('proyecto', 'cliente',  'productoPresupuestos'));
    }

    public function details($id)
    {
        $data = $this->getProyectoDetails($id);
        return view('pages/proyecto.details', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proyecto $proyecto)
    {
        //
        $clientes = Cliente::where('eliminado', false)->get();

        return response()->json([$clientes]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Proyecto $proyecto)
    {
        try {
            $validatedData = $request->validate([
                'cliente_id' => 'nullable|exists:TClientes,id',
                'serie_ref' => 'string|max:255|nullable',
                'pago' => 'string|max:255|nullable',
                'iva' => 'string|max:255|nullable',
            ]);

            if (empty($validatedData['cliente_id'])) {
                $validatedClient = $request->validate([
                    'nombre' => 'nullable|string|max:255',
                    'apellido' => 'nullable|string|max:255',
                    'dni' => 'nullable|string|max:9',
                    'email' => 'nullable|string|max:255',
                    'movil' => 'nullable|string|max:20',
                    'contacto' => 'nullable|string|max:255',
                    'direccion' => 'nullable|string|max:255',
                    'cp' => 'nullable|string|max:9',
                    'poblacion' => 'nullable|string|max:255',
                    'provincia' => 'nullable|string|max:255',
                    'fax' => 'nullable|string|max:255',
                    'cargo' => 'nullable|string|max:255',
                    'titular_nom' => 'nullable|string|max:255',
                    'titular_ape' => 'nullable|string|max:255',
                    'direccion_envio' => 'nullable|string|max:255',
                    'cp_envio' => 'nullable|string|max:9',
                    'poblacion_envio' => 'nullable|string|max:255',
                    'provincia_envio' => 'nullable|string|max:255',
                    'pago' => 'nullable|string|max:255',
                ]);

                $cliente = new Cliente();
                $cliente->fill($validatedClient);
                $cliente->pago = $validatedData['pago'];
                $cliente->save();

                $validatedData['cliente_id'] = $cliente->id;
            }

            //
            $proyecto->update([
                'cliente_id' => $validatedData['cliente_id'],
                'serie_ref' => $validatedData['serie_ref'],
                'pago' => $validatedData['pago'],
                'iva' => $validatedData['iva'],
            ]);

            return response()->json(['success' => true, 'message' => 'Proyecto actualizado correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function aceptar(Request $request, $id)
    {
        // Obtén el proyecto por ID con su presupuesto y cliente
        $proyecto = Proyecto::with(['presupuesto.productoPresupuestos', 'cliente'])->find($id);

        if (!$proyecto) {
            return response()->json(['success' => false, 'message' => 'Proyecto no encontrado.'], 404);
        }

        try {
            // Actualiza el presupuesto relacionado y marca como aceptado
            $presupuesto = $proyecto->presupuesto;
            if ($presupuesto) {
                $presupuesto->aceptado = true;
                $presupuesto->save();

                // Actualiza el stock para cada producto en el presupuesto
                foreach ($presupuesto->productoPresupuestos as $productoPres) {
                    if ($productoPres->producto_id) { // Verifica si el producto_id existe
                        $producto = Producto::find($productoPres->producto_id);

                        if ($producto) { // Verifica si el producto se encuentra
                            $producto->stock -= $productoPres->cantidad;
                            $producto->save();
                        }
                    }
                }
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

    public function cerrar(Request $request, $id)
    {
        // Obtén el proyecto por ID
        $proyecto = Proyecto::find($id);

        if (!$proyecto) {
            return response()->json(['success' => false, 'message' => 'Proyecto no encontrado.'], 404);
        }

        try {

            $proyecto->cerrado = true;
            $proyecto->save();

            return response()->json(['success' => true, 'message' => 'El proyecto se ha cerrado.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hubo un problema al cerrar el proyecto: ' . $e->getMessage()], 500);
        }
    }

    public function download($id, $sendByEmail = false)
    {
        $proyecto = Proyecto::find($id);

        $cliente = $proyecto->cliente;

        $presupuesto = $proyecto->presupuesto;
        if ($presupuesto) {
            $productoPresupuestos = $presupuesto->productoPresupuestos->sortBy('orden');
        } else {
            $productoPresupuestos = collect();
        }

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', false);
        $options->set('defaultFont', 'Inter');
        $options->set('isBase64ImageEnabled', true);

        $dompdf = new Dompdf($options);

        // Renderizar la vista como HTML
        $html = view('pages/proyecto.show', compact('proyecto', 'cliente', 'productoPresupuestos'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        $pdfName = "proyecto_{$cliente->nombre}_{$proyecto->proyecto_id}.pdf";
        $pdfPath = "public/proyectos/{$pdfName}";

        // Guarda el PDF en el servidor
        Storage::put($pdfPath, $output);

        if ($sendByEmail) {
            // Devuelve la ruta del archivo PDF para el envío por correo
            return $pdfName;
        } else {
            return response()->stream(function () use ($output) {
                echo $output;
            }, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$pdfName}\"",
            ]);
        }
    }

    public function downloadBudget($id, $sendByEmail = false)
    {
        $proyecto = Proyecto::find($id);

        $cliente = $proyecto->cliente;
        $presupuesto = $proyecto->presupuesto;
        $productoPresupuestos = $presupuesto ? $presupuesto->productoPresupuestos->sortBy('orden') : collect();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', false);
        $options->set('defaultFont', 'Inter');
        $options->set('isBase64ImageEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view('pages/proyecto.budget', compact('proyecto', 'cliente', 'productoPresupuestos'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        $pdfName = "proforma_{$cliente->nombre}_{$proyecto->proyecto_id}.pdf";
        $pdfPath = "public/proformas/{$pdfName}";

        Storage::put($pdfPath, $output);

        if ($sendByEmail) {
            return $pdfName;  // Devuelve la ruta relativa
        } else {
            return response()->stream(function () use ($output) {
                echo $output;
            }, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$pdfName}\"",
            ]);
        }
    }

    public function sendMail($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $cliente = $proyecto->cliente;

        $pdfName = $this->download($id, true);
        $pdfUrl = url('/storage/proyectos/' . $pdfName);
        $clienteEmail = $cliente->email;

        try {
            // Enviar correo electrónico con el PDF adjunto
            Mail::to($clienteEmail)->send(new ProyectoEnviado($proyecto, $pdfName));
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function sendMailBudget($id)
    {
        $proyecto = Proyecto::findOrFail($id);
        $cliente = $proyecto->cliente;

        $pdfName = $this->downloadBudget($id, true);
        $pdfUrl = url('/storage/proformas/' . $pdfName);
        $clienteEmail = $cliente->email;

        try {
            // Enviar correo electrónico con el PDF adjunto
            Mail::to($clienteEmail)->send(new ProformaEnviada($proyecto, $pdfName));
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $proyecto = Proyecto::where('proyecto_id', $id)->firstOrFail();
            $presupuesto = Presupuesto::where('proyecto_id', $id)->first();

            if ($presupuesto) {
                foreach ($presupuesto->productoPresupuestos as $productoPresu) {
                    if ($productoPresu->producto_id) {
                        $producto = Producto::find($productoPresu->producto_id);

                        if ($producto) {
                            $producto->stock += $productoPresu->cantidad;
                            $producto->save();
                        }
                    }
                }
            }

            $proyecto->update(['eliminado' => true]);
            Presupuesto::where('proyecto_id', $id)->update(['eliminado' => true]);
            Visita::where('proyecto_id', $id)->update(['eliminado' => true]);

            return response()->json(['success' => true, 'message' => 'Proyecto y registros relacionados eliminados correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hubo un problema al eliminar el proyecto: ' . $e->getMessage()], 500);
        }
    }

}
