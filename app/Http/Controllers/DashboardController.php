<?php

namespace App\Http\Controllers;
use App\Traits\ProyectoDetailsTrait;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Visita;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use ProyectoDetailsTrait;

    public function index(Request $request)
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        $user = Auth::user();
        $proyectoDetails = null;

        if ($request->has('proyecto_id')) {
            $proyectoId = $request->input('proyecto_id');
            $proyectoDetails = $this->getProyectoDetails($proyectoId);
        }

        // Proyectos
        $proyectos = Proyecto::where('eliminado', false)
            ->count();

        $proyectoPresu = Proyecto::where('eliminado', false)
            ->where('estado', 'presupuestado')
            ->count();

        $proyectoAcept = Proyecto::where('eliminado', false)
            ->where('estado', 'presupuesto_aceptado')
            ->count();

        $proyectoPorFac = Proyecto::where('eliminado', false)
            ->where('estado', 'por_facturar')
            ->count();

        $proyectoPorCobr = Proyecto::where('eliminado', false)
            ->where('estado', 'facturado_pendiente_cobro')
            ->count();

        $proyectoCobr = Proyecto::where('eliminado', false)
            ->where('estado', 'factura_cobrada')
            ->count();

        $proyectoCerrado = Proyecto::where('eliminado', false)
            ->where('cerrado', true)
            ->count();

        // Productos
        $productosDisponiblesCount = Producto::where('eliminado', false)->sum('stock');
        $productosMasPopulares = Producto::select('TProductos.*')
            ->leftJoin('TProd_Pres', 'TProductos.id', '=', 'TProd_Pres.producto_id')
            ->leftJoin('TPresupuestos', 'TProd_Pres.presupuesto_id', '=', 'TPresupuestos.id')
            ->where('TProductos.eliminado', false)
            ->where('TPresupuestos.eliminado', false)
            ->selectRaw('COUNT(TProd_Pres.id) as presupuestos_count')
            ->groupBy('TProductos.id', 'TProductos.nombre', 'TProductos.leyenda', 'TProductos.stock', 'TProductos.precio')
            ->orderBy('presupuestos_count', 'desc')
            ->with(['TProd_Pres.presupuesto' => function ($query) {
                $query->where('eliminado', false);
            }])
            ->take(5)
            ->get();

        // Clientes
        $clientes = Cliente::where('eliminado', false)->get();
        $clientesEstablecidos = Cliente::where('establecido', true)->where('eliminado', false)->count();
        $clientesNoEstablecidos = Cliente::where('establecido', false)->where('eliminado', false)->count();

        // Configuración para visitas de la semana
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();

        $rangoSemana = $inicioSemana->format('d M') . ' al ' . $finSemana->format('d M');

        return view('pages.dashboards.index', compact(
            'user',
            'proyectos',
            'proyectoPresu',
            'proyectoAcept',
            'proyectoPorFac',
            'proyectoPorCobr',
            'proyectoCobr',
            'proyectoCerrado',
            'productosMasPopulares',
            'productosDisponiblesCount',
            'clientes',
            'clientesEstablecidos',
            'clientesNoEstablecidos',
            'proyectoDetails',
            'rangoSemana'
        ));
    }

    public function getVisitasSemana(Request $request)
    {
        $inicioSemana = Carbon::now()->startOfWeek();
        $finSemana = Carbon::now()->endOfWeek();

        $visitas = Visita::whereBetween('fecha_inicio', [$inicioSemana, $finSemana])
                        ->where('eliminado', false)
                        ->paginate(4);

        return view('partials.visitas_semana', compact('visitas'));
    }


    public function getProductosBajoStock(Request $request)
    {
        $productosBajoStock = Producto::where('stock', '<', 6)
                                    ->where('eliminado', false)
                                    ->paginate(5);

        return view('partials.productos_bajo_stock', compact('productosBajoStock'));
    }

}
