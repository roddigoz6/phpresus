<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\Orden;
use App\Models\Producto;
use App\Models\Cliente;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        //Presupuestos
        $presupuestosAceptados = Presupuesto::where('aceptado', true)->where('eliminado', false)->count();
        $presupuestosNoAceptados = Presupuesto::where('aceptado', false)->where('eliminado', false)->count();
        $presupuestosCount = Presupuesto::where('eliminado', false)->count();
        $porcentajeAceptados = $presupuestosCount > 0 ? ($presupuestosAceptados / $presupuestosCount) * 100 : 0;
        $clientesMasPresupuestos = Cliente::select('clientes.*')
            ->leftJoin('presupuestos', function($join) {
                $join->on('clientes.id', '=', 'presupuestos.cliente_id')
                    ->where('presupuestos.eliminado', false);
            })
            ->where('clientes.eliminado', false)
            ->selectRaw('COUNT(presupuestos.id) as presupuestos_count')
            ->groupBy('clientes.id')
            ->orderBy('presupuestos_count', 'desc')
            ->take(5)
            ->get();

        //Ordenes
        $ordenes = Orden::where('eliminado', false)->get();
        $ordenesCount = Orden::where('eliminado', false)->count();
        $ordenesCobradasCount = Orden::where('cobrado', true)->where('eliminado', false)->count();
        $ordenesSinCobrarCount = Orden::where('cobrado', false)->where('eliminado', false)->count();
        $clientesMasOrdenes = Cliente::select('clientes.*')
            ->leftJoin('ordenes', function($join) {
                $join->on('clientes.id', '=', 'ordenes.cliente_id')
                    ->where('ordenes.eliminado', false);
            })
            ->where('clientes.eliminado', false)
            ->selectRaw('COUNT(ordenes.id) as ordenes_count')
            ->groupBy('clientes.id')
            ->orderBy('ordenes_count', 'desc')
            ->take(5)
            ->get();

        //Productos
        $productosDisponiblesCount = Producto::where('eliminado', false)->sum('stock');

        //Clientes
        $clientes = Cliente::where('eliminado', false)->get();
        $clientesEstablecidos = Cliente::where('establecido', true)->where('eliminado', false)->count();
        $clientesNoEstablecidos = Cliente::where('establecido', false)->where('eliminado', false)->count();

        return view('pages/dashboards.index', compact(
            'presupuestosAceptados',
            'presupuestosNoAceptados',
            'porcentajeAceptados',
            'presupuestosCount',
            'clientesMasPresupuestos',
            'ordenes',
            'ordenesCount',
            'ordenesCobradasCount',
            'ordenesSinCobrarCount',
            'clientesMasOrdenes',
            'productosDisponiblesCount',
            'clientes',
            'clientesEstablecidos',
            'clientesNoEstablecidos'
        ));
    }

    public function getProductosBajoStock(Request $request)
    {
        $productosBajoStock = Producto::where('stock', '<', 5)
                                    ->where('eliminado', false)
                                    ->paginate(5);

        return view('partials.productos_bajo_stock', compact('productosBajoStock'));
    }

}
