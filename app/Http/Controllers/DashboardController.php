<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\Orden;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        $user = Auth::user();

        //Presupuestos
        $presupuestosAceptados = Presupuesto::where('aceptado', true)->where('eliminado', false)->count();
        $presupuestosNoAceptados = Presupuesto::where('aceptado', false)->where('eliminado', false)->count();
        $presupuestosCount = Presupuesto::where('eliminado', false)->count();
        $porcentajeAceptados = $presupuestosCount > 0 ? ($presupuestosAceptados / $presupuestosCount) * 100 : 0;

        //Ordenes
        $ordenes = Orden::where('eliminado', false)->get();
        $ordenesCount = Orden::where('eliminado', false)->count();
        $ordenesCobradasCount = Orden::where('cobrado', true)->where('eliminado', false)->count();
        $ordenesSinCobrarCount = Orden::where('cobrado', false)->where('eliminado', false)->count();
        $porcentajeCobradas = $ordenesCount > 0 ? ($ordenesCobradasCount / $ordenesSinCobrarCount) * 100 : 0;

        //Productos
        $productosDisponiblesCount = Producto::where('eliminado', false)->sum('stock');
        $productosMasPopulares = Producto::select('productos.*')
        ->leftJoin('producto_presupuestos', 'productos.id', '=', 'producto_presupuestos.producto_id')
        ->leftJoin('presupuestos', 'producto_presupuestos.presupuesto_id', '=', 'presupuestos.id')
        ->where('productos.eliminado', false)
        ->where('presupuestos.eliminado', false)
        ->selectRaw('COUNT(producto_presupuestos.id) as presupuestos_count')
        ->groupBy('productos.id', 'productos.nombre', 'productos.descripcion', 'productos.stock', 'productos.precio')
        ->orderBy('presupuestos_count', 'desc')
        ->with(['producto_presupuestos.presupuesto' => function($query) {
            $query->where('eliminado', false);
        }])
        ->take(5)
        ->get();


        //Clientes
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
            'ordenes',
            'ordenesCount',
            'ordenesCobradasCount',
            'ordenesSinCobrarCount',
            'porcentajeCobradas',
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
