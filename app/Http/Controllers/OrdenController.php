<?php

namespace App\Http\Controllers;

use App\Mail\OrdenEnviada;
use App\Models\Orden;
use App\Models\Presupuesto;
use App\Models\ProductoPresupuesto;
use App\Models\ProductoOrden;
use App\Models\Cliente;
use App\Models\Producto;
use App\Http\Controllers\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $search = $request->input('search');
        $tab = $request->input('tab', 'all');

        $query = Orden::where('eliminado', false);

        if ($search) {
            $query->whereHas('cliente', function($q) use ($search) {
                $q->where('nombre', 'like', "%$search%");
            });
        }
        $query->orderBy('created_at', 'desc');

        $ordenes = $query->paginate(15);
        return view('pages/orden.index', compact('ordenes', 'tab'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos del formulario
        $validatedData = $request->validate([
            'presupuesto_id' => 'required|exists:presupuestos,id',
        ]);

        $presupuesto = Presupuesto::findOrFail($validatedData['presupuesto_id']);

        // Verificar si ya existe una orden no eliminada para este presupuesto
        $ordenExistente = Orden::where('presupuesto_id', $presupuesto->id)
                            ->where('eliminado', false)
                            ->first();

        if ($ordenExistente && !$request->has('force_create')) {
            return response()->json([
                'message' => 'Este presupuesto ya tiene una orden, ¿deseas crear una nueva orden?',
                'allow_force_create' => true,
            ], 400);
        }

        // Obtener los productos relacionados con el presupuesto
        $productosPresupuesto = ProductoPresupuesto::where('presupuesto_id', $presupuesto->id)->get();

        // Verificar si alguno de los productos está marcado como eliminado
        foreach ($productosPresupuesto as $productoPresupuesto) {
            $producto = Producto::findOrFail($productoPresupuesto->producto_id);
            if ($producto->eliminado) {
                return response()->json(['message_prod_elim' => 'No se puede crear la orden. Uno de los productos está eliminado: ' . $producto->nombre], 400);
            }
            if($producto->stock == 0){
                return response()->json(['message_prod_stock'=>'No se puede crear la orden. El producto '. $producto->nombre .' no tiene stock'], 400);
            }
        }

        // Proceder a crear la orden
        $cliente = Cliente::findOrFail($presupuesto->cliente_id);
        $orden = new Orden([
            'presupuesto_id' => $presupuesto->id,
            'cliente_id' => $cliente->id,
            'cliente_nombre' => $cliente->nombre,
            'cliente_apellido' => $cliente->apellido,
            'cliente_dni' => $cliente->dni,
            'precio_total' => $presupuesto->precio_total,
            'cantidad' => $presupuesto->cantidad,
            'cobrado' => false,
            'eliminado' => false,
        ]);
        $orden->save();

        foreach ($productosPresupuesto as $productoPresupuesto) {
            ProductoOrden::create([
                'producto_id' => $productoPresupuesto->producto_id,
                'orden_id' => $orden->id,
                'precio' => $productoPresupuesto->precio,
                'cantidad' => $productoPresupuesto->cantidad,
            ]);

            $producto = Producto::findOrFail($productoPresupuesto->producto_id);
            $producto->stock -= $productoPresupuesto->cantidad;
            $producto->save();
        }

        if (!$cliente->establecido) {
            $cliente->establecido = true;
            $cliente->save();
        }

        $presupuesto->aceptado = true;
        $presupuesto->save();

        return response()->json([
            'message' => 'Orden creada correctamente',
            'orden' => [
                'id' => $orden->id,
                'created_at' => $orden->created_at->toDateTimeString(),
                'productos' => $productosPresupuesto->map(function($productoPresupuesto) {
                    return [
                        'producto_id' => $productoPresupuesto->producto_id,
                        'cantidad' => $productoPresupuesto->cantidad,
                        'precio' => $productoPresupuesto->precio,
                    ];
                })
            ]
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function show(Orden $orden)
    {
        // Cargar las relaciones necesarias
        $orden->load('cliente', 'productoOrden.producto');

        // Ordenar los productos por 'orden_prod' en orden ascendente
        $orden->setRelation('productoOrden', $orden->productoOrden->sortBy('orden_prod'));

        // Pasar los datos del presupuesto a la vista
        return view('pages/orden.show', compact('orden'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function edit(Orden $orden)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orden $orden)
    {
        // Validar los datos recibidos del formulario
        $validatedData = $request->validate([
            'cobrado' => 'required|boolean',
        ]);

        $orden->cobrado = $validatedData['cobrado'];
        $orden->save();

        // Redirigir a la página anterior con un mensaje de éxito
        return redirect()->back()->with('suc_cobrado', 'Orden cobrada');
    }

    public function download(Orden $orden, $sendByEmail = false)
    {

        $cliente = $orden->cliente;

        $productos_print = $orden->productoOrden()
            ->orderBy('orden_prod')
            ->get();

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view('pages/orden.show', compact('orden', 'productos_print'))->render();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        $pdfName = "orden_{$cliente->nombre}_{$orden->id}.pdf";
        $pdfPath = "public/ordenes/{$pdfName}";

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

    public function sendMail($ordenId)
    {
        $orden = Orden::findOrFail($ordenId);

        // Llamar al método download con la opción de enviar por correo
        $pdfPath = $this->download($orden, true);

        $clienteEmail = $orden->cliente->email;

        try {
            // Enviar correo electrónico con el PDF adjunto
            Mail::to($clienteEmail)->send(new OrdenEnviada($orden, Storage::path($pdfPath)));

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al enviar el correo electrónico'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orden  $orden
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orden $orden)
    {
        $orden->eliminado = true;
        $orden->save();

        $presupuesto = $orden->presupuesto;

        // Verificar si el presupuesto existe
        if ($presupuesto) {
            // Obtener los productos asociados al presupuesto a través de ProductoPresupuesto
            $productosPresupuesto = ProductoPresupuesto::where('presupuesto_id', $presupuesto->id)->get();

            // Recorrer los productos asociados al presupuesto
            foreach ($productosPresupuesto as $productoPresupuesto) {
                // Obtener el producto correspondiente
                $producto = Producto::findOrFail($productoPresupuesto->producto_id);

                // Devolver la cantidad de productos al stock del producto
                $producto->stock += $productoPresupuesto->cantidad;
                $producto->save();

                //dd($productoPresupuesto->cantidad);
            }
        }
        return redirect()->back()->with('del_ord', 'Orden cancelada correctamente');
    }
}
