<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tab = $request->input('tab', 'todas');

        $query = Producto::where('eliminado', false);

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('id', $search)
                    ->orWhere('nombre', 'like', "%$search%");
            });
        }

        $productos = $query->paginate(15);

        if ($productos->count() == 0 && $productos->lastPage() > 1) {
            return redirect()->route('producto.index', [
                'page' => $productos->lastPage() - 1,
                'tab' => $tab,
                'search' => $search
            ]);
        }

        return view('pages/producto.index', compact('productos', 'tab', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Valida los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'tipo' => 'required|in:Artículo,Visita',
        ]);

        // Crea el nuevo producto en la base de datos
        $producto = new Producto();
        $producto->nombre = $validatedData['nombre'];
        $producto->precio = $validatedData['precio'];
        $producto->descripcion = $validatedData['descripcion'];
        $producto->stock = $validatedData['stock'];
        $producto->tipo = $validatedData['tipo'];
        $producto->save();

        // Ejecuta el script solo si la validación ha sido exitosa
        return redirect()->back()->with('success_prod', 'Producto creado.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $producto->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock,
            'tipo' => $request->tipo,
        ]);

        return redirect()->back()->with('update_prod', 'Producto actualizado.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producto  $producto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producto $producto)
    {
        $producto->update(['eliminado' => true]);
        return redirect()->back()->with('delete_prod', 'Producto eliminado correctamente.');
    }
}
