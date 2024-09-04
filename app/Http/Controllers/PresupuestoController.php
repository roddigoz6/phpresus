<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Mail\Saludo;
use App\Mail\PresupuestoEnviado;
use App\Models\ProductoPresupuesto;
use App\Models\Presupuesto;
use App\Models\Proyecto;
use App\Models\Producto;
use App\Models\Cliente;

use Dompdf\Dompdf;
use Dompdf\Options;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PresupuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tab = $request->input('tab', 'all');

        $query = Presupuesto::where('eliminado', false);

        if ($search) {
            $query->whereHas('cliente', function($q) use ($search) {
                $q->where('nombre', 'like', "%$search%");
            });
        }

        $presupuestos = $query->paginate(15);
        $presupuestosNoAceptados = Presupuesto::where('eliminado', false)->where('aceptado', 0)->paginate(15);
        $presupuestosAceptados = Presupuesto::where('eliminado', false)->where('aceptado', 1)->paginate(15);

        if ($presupuestos->count() == 0 && $presupuestos->lastPage() > 1) {
            return redirect()->route('presupuesto.index', ['page' => $presupuestos->lastPage() - 1, 'tab' => $tab]);
        }

        return view('pages/presupuesto.index', compact('presupuestos', 'presupuestosNoAceptados', 'presupuestosAceptados', 'tab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $cliente_id = $request->query('cliente_id');
        $cliente = Cliente::findOrFail($cliente_id);

        return view('pages.presupuesto.create', compact('cliente'));
    }


    public function getProductos(Request $request)
    {
        try {
            $search = $request->input('search');
            $order = $request->input('order', 'asc');
            $precio_order = $request->input('precio_order', 'asc');
            $sortBy = $request->input('sort_by', 'nombre');

            $productosQuery = Producto::where('eliminado', false);

            // Si se incluye un término de búsqueda, filtra los productos por nombre o ID
            if ($search) {
                $productosQuery->where(function ($query) use ($search) {
                    $query->where('id', $search)
                        ->orWhere('nombre', 'like', '%' . $search . '%');
                });
            }

            // Ordena los productos según el criterio seleccionado
            if ($sortBy === 'precio') {
                $productosQuery->orderBy('precio', $precio_order);
            } else {
                $productosQuery->orderBy('nombre', $order);
            }

            // Pagina los resultados
            $productos = $productosQuery->paginate(15);

            // Responde con HTML si la solicitud es AJAX, o con la vista completa si no lo es
            if ($request->ajax()) {
                return response()->json([
                    'html' => view('pages.presupuesto.productos', compact('productos', 'order', 'precio_order'))->render(),
                ]);
            }

            return view('pages.presupuesto.productos', compact('productos', 'order', 'precio_order'));
        } catch (\Exception $e) {
            Log::error('Error al obtener productos: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            //dd($request);
            // Validar los datos de entrada
            $validatedData = $request->validate([
                'cliente_id' => 'required|exists:TClientes,id',
                'precio_total' => 'required|numeric|min:0',
                'lista_productos' => 'required|json',
                'serie_ref' => 'string|max:255|nullable',
                'num_ref' => 'string|max:255|nullable'
            ]);

            // Crear un nuevo proyecto
            $proyecto = new Proyecto();
            $proyecto->cliente_id = $validatedData['cliente_id'];
            $proyecto->estado = 'Presupuestado';
            $proyecto->serie_ref = $validatedData['serie_ref'];
            $proyecto->num_ref = $validatedData['num_ref'];
            $proyecto->pago = $request->input('pago');
            $proyecto->save();

            // Crear un nuevo presupuesto asociado al proyecto
            $presupuesto = new Presupuesto();
            $presupuesto->cliente_id = $validatedData['cliente_id'];
            $presupuesto->proyecto_id = $proyecto->proyecto_id;
            $presupuesto->precio_total = $validatedData['precio_total'];
            $presupuesto->save();

            // Guardar los productos y capítulos asociados al presupuesto
            $productos = json_decode($validatedData['lista_productos'], true);

            foreach ($productos as $producto) {
                ProductoPresupuesto::create([
                    'presupuesto_id' => $presupuesto->id,
                    'producto_id' => $producto['id'] ?? null,
                    'capitulo_id' => $producto['capitulo_id'] ?? null,
                    'cantidad' => $producto['cantidad'] ?? null,
                    'precio' => $producto['precio'] ?? null,
                    'orden' => $producto['orden'],
                    'titulo' => $producto['titulo'] ?? null,
                    'descripcion' => $producto['descripcion'] ?? null,
                    'tipo' => $producto['tipo'],
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Presupuesto creado correctamente.']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'La validación falló.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hubo un problema al guardar los datos.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Presupuesto $presupuesto)
    {
        $presupuesto->load('cliente', 'productoPresupuestos.producto');
        $presupuesto->setRelation('productoPresupuestos', $presupuesto->productoPresupuestos->sortBy('orden_prod'));

        return view('pages/presupuesto.show', compact('presupuesto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function edit(Presupuesto $presupuesto)
    {
        $clientes = Cliente::where('eliminado', false)->get();

        $presupuesto->load('cliente', 'productoPresupuestos.producto', 'proyecto');

        $proyecto = $presupuesto->proyecto;

        $productosArrastrados = $presupuesto->productoPresupuestos->map(function($pp) {
            return [
                'id' => optional($pp->producto)->id,
                'capitulo_id' => $pp->capitulo_id,
                'nombre' => optional($pp->producto)->nombre,
                'cantidad' => $pp->cantidad,
                'precio' => $pp->precio,
                'orden' => $pp->orden,
                'stock' => $pp->stock,
                'tipo' => $pp->tipo,
                'titulo' =>$pp->titulo,
                'descripcion' => $pp->descripcion,
            ];
        });

        $productosArrastrados = $productosArrastrados->sortBy('orden')->values();

        return view('pages/presupuesto.edit', compact('presupuesto', 'proyecto', 'clientes', 'productosArrastrados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presupuesto $presupuesto)
    {
        // Validar los datos de entrada
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:tclientes,id',
            'precio_total' => 'required|numeric|min:0',
            'lista_productos' => 'required|json',
        ]);

        // Actualizar los datos del presupuesto
        $presupuesto->update([
            'cliente_id' => $validatedData['cliente_id'],
            'precio_total' => $validatedData['precio_total'],
        ]);

        // Eliminar los productos antiguos asociados con el presupuesto
        $presupuesto->productoPresupuestos()->delete();

        // Decodificar la lista de productos del JSON
        $productos = json_decode($validatedData['lista_productos'], true);
        foreach ($productos as $producto) {
            $presupuestoProducto = new ProductoPresupuesto();
            $presupuestoProducto->presupuesto_id = $presupuesto->id;
            $presupuestoProducto->producto_id = $producto['id'] ?? null;
            $presupuestoProducto->capitulo_id = $producto['capitulo_id'] ?? null;
            $presupuestoProducto->cantidad = $producto['cantidad'] ?? null;
            $presupuestoProducto->precio = $producto['precio'] ?? null;
            $presupuestoProducto->orden = $producto['orden'];
            $presupuestoProducto->titulo = $producto['titulo'] ?? null;
            $presupuestoProducto->descripcion = $producto['descripcion'] ?? null;
            $presupuestoProducto->save();

            if (isset($presupuestoProducto->producto_id)) {
                $productoModel = Producto::find($presupuestoProducto->producto_id);

                if ($productoModel) {
                    $productoModel->precio = $producto['precio'];
                    $productoModel->save();
                }
            }
        }
//dd($productos);
        return redirect()->route('proyecto.index')->with('update_pres', 'Proyecto actualizado.')->with('clear_storage', true);
    }

    public function download(Presupuesto $presupuesto, $sendByEmail = false)
    {
        // Obtener datos del presupuesto
        $cliente = $presupuesto->cliente;

        $productos_print = $presupuesto->productoPresupuestos()
            ->orderBy('orden_prod')
            ->get();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view('pages/presupuesto.show', compact('presupuesto', 'productos_print'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        $pdfName = "presupuesto_{$cliente->nombre}_{$presupuesto->id}.pdf";
        $pdfPath = "public/presupuestos/{$pdfName}";

        // Guarda el PDF en el servidor
        Storage::put($pdfPath, $output);

        if ($sendByEmail) {
            return $pdfPath; // Devuelve la ruta del PDF
        } else {
            // Envía el PDF al navegador para descarga
            return response()->stream(function () use ($output) {
                echo $output;
            }, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$pdfName}\"",
            ]);
        }
    }

    public function sendMail($presupuestoId)
    {
        $presupuesto = Presupuesto::findOrFail($presupuestoId);

        $pdfPath = $this->download($presupuesto, true);
        $clienteEmail = $presupuesto->cliente->email;

        try {
            // Enviar correo electrónico con el PDF adjunto
            Mail::to($clienteEmail)->send(new PresupuestoEnviado($presupuesto, Storage::path($pdfPath)));
            // Log the CSRF token from the session
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al enviar el correo electrónico'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presupuesto $presupuesto)
    {
        $presupuesto->update(['eliminado' => true]);
        return redirect()->back()->with('delete_presupuesto', 'Presupuesto eliminado correctamente.');
    }

}
