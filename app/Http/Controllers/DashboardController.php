<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        $user = Auth::user();

        // Presupuestos
        $presupuestosAceptados = Presupuesto::where('aceptado', true)->where('eliminado', false)->count();
        $presupuestosNoAceptados = Presupuesto::where('aceptado', false)->where('eliminado', false)->count();
        $presupuestosCount = Presupuesto::where('eliminado', false)->count();
        $porcentajeAceptados = $presupuestosCount > 0 ? ($presupuestosAceptados / $presupuestosCount) * 100 : 0;

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

        return view('pages.dashboards.index', compact(
            'user',
            'presupuestosAceptados',
            'presupuestosNoAceptados',
            'porcentajeAceptados',
            'presupuestosCount',
            'productosMasPopulares',
            'productosDisponiblesCount',
            'clientes',
            'clientesEstablecidos',
            'clientesNoEstablecidos'
        ));
    }

    public function getProductosBajoStock(Request $request)
    {
        $productosBajoStock = Producto::where('stock', '<', 6)
                                    ->where('eliminado', false)
                                    ->paginate(5);

        return view('partials.productos_bajo_stock', compact('productosBajoStock'));
    }

}
