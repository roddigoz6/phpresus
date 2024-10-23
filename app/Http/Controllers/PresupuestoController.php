<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Mail\PresupuestoEnviado;
use App\Mail\ProformaEnviada;
use App\Models\ProductoPresupuesto;
use App\Models\Presupuesto;
use App\Models\Proyecto;
use App\Models\Producto;

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
    public function create($proyecto_id)
    {
        // Encuentra el proyecto por su ID
        $proyecto = Proyecto::findOrFail($proyecto_id);

        // Devuelve la vista con el proyecto
        return view('pages.presupuesto.create', compact('proyecto'));
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
            //
            $validatedData = $request->validate([
                'proyecto_id' => 'required|exists:TProyectos,proyecto_id',
                'nom_pres' => 'nullable|string|max:255',
                'precio_total' => 'required|numeric|min:0',
                'pago' => 'string|max:255|nullable',
                'iva' => 'string|max:255|nullable',
                'lista_productos' => 'required|json',
            ]);

            //
            $presupuesto = new Presupuesto();
            $presupuesto->proyecto_id = $validatedData['proyecto_id'];
            $presupuesto->nom_pres = $validatedData['nom_pres'];
            $presupuesto->precio_total = $validatedData['precio_total'];
            $presupuesto->pago = $validatedData['pago'];
            $presupuesto->iva = $validatedData['iva'];
            $presupuesto->estado = 'presupuestado';
            $presupuesto->save();

            $productos = json_decode($validatedData['lista_productos'], true);

            foreach ($productos as $producto) {
                if (isset($producto['tipo']) && $producto['tipo'] === 'linea') {
                    if ($producto['actualizarPrecio']) {
                        Producto::where('id', $producto['id'])
                            ->update(['precio' => $producto['precio']]);
                    }

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
                } elseif (isset($producto['tipo']) && $producto['tipo'] === 'capitulo') {
                    ProductoPresupuesto::create([
                        'presupuesto_id' => $presupuesto->id,
                        'capitulo_id' => $producto['capitulo_id'],
                        'cantidad' => null,
                        'precio' => null,
                        'orden' => $producto['orden'],
                        'titulo' => $producto['titulo'] ?? null,
                        'descripcion' => $producto['descripcion'] ?? null,
                        'tipo' => $producto['tipo'],
                    ]);
                }
            }

            return response()->json(['success' => true, 'message' => 'Presupuesto creado correctamente.']);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'La validación falló.', 'errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $th->getMessage()], 500);
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
        return view();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function edit(Presupuesto $presupuesto)
    {
        $presupuesto->load('productoPresupuestos.producto', 'proyecto');
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

        return view('pages/presupuesto.edit', compact('presupuesto', 'proyecto',  'productosArrastrados'));
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
        $validatedData = $request->validate([
            'proyecto_id' => 'required|exists:tproyectos,proyecto_id',
            'nom_pres' => 'nullable|string|max:255',
            'precio_total' => 'required|numeric|min:0',
            'pago' => 'string|max:255|nullable',
            'iva' => 'string|max:255|nullable',
            'lista_productos' => 'required|json',
        ]);

        //
        $presupuesto->update([
            'proyecto_id' => $validatedData['proyecto_id'],
            'precio_total' => $validatedData['precio_total'],
        ]);

        // Eliminar productos existentes asociados al presupuesto
        $presupuesto->productoPresupuestos()->delete();

        //
        $productos = json_decode($validatedData['lista_productos'], true);

        foreach ($productos as $producto) {
            if (isset($producto['tipo']) && $producto['tipo'] === 'linea') {
                // Verificamos si 'actualizarPrecio' existe antes de acceder a su valor
                if (isset($producto['actualizarPrecio']) && $producto['actualizarPrecio']) {
                    Producto::where('id', $producto['id'])
                        ->update(['precio' => $producto['precio']]);
                }

                $presupuestoProducto = new ProductoPresupuesto();
                $presupuestoProducto->presupuesto_id = $presupuesto->id;
                $presupuestoProducto->producto_id = $producto['id'] ?? null;
                $presupuestoProducto->capitulo_id = $producto['capitulo_id'] ?? null;
                $presupuestoProducto->cantidad = $producto['cantidad'] ?? null;
                $presupuestoProducto->precio = $producto['precio'] ?? null;
                $presupuestoProducto->orden = $producto['orden'] ?? null;
                $presupuestoProducto->titulo = $producto['titulo'] ?? null;
                $presupuestoProducto->descripcion = $producto['descripcion'] ?? null;
                $presupuestoProducto->tipo = $producto['tipo'];
                $presupuestoProducto->save();
            }
        }

        return redirect()->route('proyecto.index')->with('update_pres', 'Proyecto actualizado.')->with('clear_storage', true);
    }

    public function aceptar(Request $request, $id)
    {
        //
        $presupuesto = Presupuesto::with('productoPresupuestos')->find($id);

        if (!$presupuesto) {
            return response()->json(['success' => false, 'message' => 'Presupuesto no encontrado.'], 404);
        }

        try {

            $cliente = $presupuesto->proyecto->cliente;
            if ($cliente) {
                $presupuesto->estado = 'presupuesto_aceptado';
                $presupuesto->save();

                $cliente->establecido = true;
                $cliente->save();

                //
                foreach ($presupuesto->productoPresupuestos as $productoPres) {
                    if ($productoPres->producto_id) {
                        $producto = Producto::find($productoPres->producto_id);

                        if ($producto) {
                            $producto->stock -= $productoPres->cantidad;
                            $producto->save();
                        }
                    }
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Cliente no encontrado.'], 404);
            }

            return response()->json(['success' => true, 'message' => 'El proyecto y el presupuesto han sido aceptados correctamente.']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Hubo un problema al aceptar el presupuesto: ' . $e->getMessage()], 500);
        }
    }

    public function download($id, $sendByEmail = false)
    {
        $proyecto = Proyecto::find($id);

        // Verifica si el proyecto y el cliente existen
        if (!$proyecto || !$proyecto->cliente) {
            return response()->json(['success' => false, 'message' => 'Proyecto o cliente no encontrado.'], 404);
        }

        $cliente = $proyecto->cliente;

        // Si deseas incluir solo la información del proyecto, puedes omitir los productos
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', false);
        $options->set('defaultFont', 'Inter');
        $options->set('isBase64ImageEnabled', true);

        $dompdf = new Dompdf($options);

        // Renderizar la vista como HTML para el proyecto
        $html = view('pages/proyecto.show', compact('proyecto', 'cliente'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        $pdfName = "proyecto_{$cliente->nombre}_{$proyecto->proyecto_id}.pdf";
        $pdfPath = "public/proyectos/{$pdfName}";

        // Guarda el PDF en el servidor
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

    public function downloadBudget($id, $sendByEmail = false)
    {
        $presupuesto = Presupuesto::find($id);

        // Verifica si el presupuesto existe y obtiene el proyecto y el cliente
        if (!$presupuesto || !$presupuesto->proyecto || !$presupuesto->proyecto->cliente) {
            return response()->json(['success' => false, 'message' => 'Presupuesto, proyecto o cliente no encontrado.'], 404);
        }

        $proyecto = $presupuesto->proyecto;
        $cliente = $proyecto->cliente;

        // Obtiene los productos del presupuesto
        $productoPresupuestos = $presupuesto->productoPresupuestos->sortBy('orden');

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', false);
        $options->set('defaultFont', 'Inter');
        $options->set('isBase64ImageEnabled', true);

        $dompdf = new Dompdf($options);

        // Renderizar la vista como HTML para el presupuesto
        $html = view('pages/presupuesto.budget', compact('presupuesto', 'cliente', 'productoPresupuestos'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        $pdfName = "proforma_{$cliente->nombre}_{$presupuesto->id}.pdf";
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
        $presupuesto = Presupuesto::findOrFail($id);
        $cliente = $presupuesto->cliente;

        $pdfName = $this->download($id, true);
        $pdfUrl = url('/storage/presupuestos/' . $pdfName);
        $clienteEmail = $cliente->email;

        try {
            // Enviar correo electrónico con el PDF adjunto
            Mail::to($clienteEmail)->send(new PresupuestoEnviado($presupuesto, $pdfName));
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function sendMailBudget($id)
    {
        $presupuesto = Presupuesto::findOrFail($id);
        $cliente = $presupuesto->cliente;

        $pdfName = $this->downloadBudget($id, true);
        $pdfUrl = url('/storage/proformas/' . $pdfName);
        $clienteEmail = $cliente->email;

        try {
            // Enviar correo electrónico con el PDF adjunto
            Mail::to($clienteEmail)->send(new ProformaEnviada($presupuesto, $pdfName));
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function facturar($id)
    {
        try {
            //
            $presupuesto = Presupuesto::findOrFail($id);
            $proyecto = $presupuesto->proyecto;
            $cliente = $proyecto->cliente;

            $productoPres = $presupuesto->productoPresupuestos->sortBy('orden');

            //
            $ivaRate = $presupuesto->iva;
            $base = $presupuesto->precio_total;
            $ivaAmount = ($base * $ivaRate) / 100;
            $total = $base + $ivaAmount;

            //
            $response = [
                'invoice' => [
                    'recipient' => [
                        'irsId' => $cliente->dni ?? 'B00000000',
                        'name' => $cliente->nombre ?? 'ACME Inc.',
                        'country' => $cliente->poblacion ?? 'ES',
                    ],
                    'id' => [
                        'number' => $presupuesto->id,
                        'issuedTime' => now()->format('Y-m-d'),
                    ],
                    'description' => [
                        'text' => $presupuesto->nom_pres ?? 'Invoice description',
                        'operationDate' => now()->format('Y-m-d'),
                    ],
                    'type' => 'F1', // Tipo de factura
                    'vatLines' => [
                        [
                            'vatOperation' => 'S1',
                            'base' => $base,
                            'rate' => $ivaRate,
                            'amount' => $ivaAmount,
                            'vatKey' => '01',
                        ],
                    ],
                    'total' => $total,
                    'amount' => $ivaAmount,
                ]
            ];

            // Retornar el JSON
            return response()->json($response);

        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Hubo un problema al generar la factura: ' . $th->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presupuesto  $presupuesto
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $presupuesto = Presupuesto::findOrFail($id);

            // Verifica si el estado del presupuesto es 'presupuesto_aceptado'
            if ($presupuesto->estado === 'presupuesto_aceptado') {
                foreach ($presupuesto->productoPresupuestos as $productoPres) {
                    if ($productoPres->producto_id) {
                        $producto = Producto::find($productoPres->producto_id);

                        if ($producto) {
                            $producto->stock += $productoPres->cantidad; // Aumentar el stock
                            $producto->save(); // Guardar los cambios
                        }
                    }
                }
            }

            // Marcar el presupuesto como eliminado
            $presupuesto->update(['eliminado' => true]);

            // Responder con un JSON
            return response()->json(['success' => true, 'message' => 'Presupuesto eliminado correctamente.']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Hubo un problema al eliminar el presupuesto: ' . $th->getMessage()], 500);
        }
    }

}
