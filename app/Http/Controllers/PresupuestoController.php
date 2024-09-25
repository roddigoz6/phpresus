<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Mail\Saludo;
//use App\Mail\PresupuestoEnviado;
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

        return view('pages.presupuesto.create', compact('cliente', ));
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
            // Validar los datos de entrada
            $validatedData = $request->validate([
                'proyecto_id' => 'required|exists:TProyectos,proyecto_id',
                'precio_total' => 'required|numeric|min:0',
                'lista_productos' => 'required|json',
            ]);

            // Crear un nuevo presupuesto asociado al proyecto
            $presupuesto = new Presupuesto();
            $presupuesto->proyecto_id = $validatedData['proyecto_id'];
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
            return response()->json(['success' => false, 'message' => $e], 500);
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
        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:tclientes,id',
            'precio_total' => 'required|numeric|min:0',
            'lista_productos' => 'required|json',
            'serie_ref' => 'string|max:255|nullable',
            'num_ref' => 'string|max:255|nullable',
            'pago' => 'string|nullable'
        ]);

        $presupuesto->update([
            'cliente_id' => $validatedData['cliente_id'],
            'precio_total' => $validatedData['precio_total'],
        ]);

        $presupuesto->proyecto->update([
            'cliente_id' => $validatedData['cliente_id'],
            'serie_ref' => $validatedData['serie_ref'],
            'num_ref' => $validatedData['num_ref'],
            'pago' => $validatedData['pago']
        ]);

        $presupuesto->productoPresupuestos()->delete();

        $productos = json_decode($validatedData['lista_productos'], true);

        foreach ($productos as $producto) {
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

            if (isset($presupuestoProducto->producto_id)) {
                $productoModel = Producto::find($presupuestoProducto->producto_id);

                if ($productoModel) {
                    $productoModel->precio = $producto['precio'];
                    $productoModel->save();
                }
            }
        }

        return redirect()->route('proyecto.index')->with('update_pres', 'Proyecto actualizado.')->with('clear_storage', true);
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
