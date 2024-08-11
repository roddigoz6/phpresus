<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Categoria::where('eliminado', false);

        if ($search) {
            $query->where('nombre', 'like', "%$search%");
        }

        $categorias = $query->paginate(15);

        $productos = Producto::where('eliminado', false)->get();

        if ($categorias->count() == 0 && $categorias->lastPage() > 1) {
            return redirect()->route('categoria.index', ['page' => $categorias->lastPage() - 1]);
        }

        return view('pages/categoria.index', compact('categorias', 'productos'));
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
        //
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:50'
        ]);

        $categoria = new Categoria();
        $categoria->nombre = $validatedData['nombre'];
        $categoria->save();

        return redirect()->back()->with('success_cat', 'Categoría creada correctamente.')->with('clear_storage', true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categoria $categoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);

        // Verificar si la categoría es la categoría "General"
        if ($categoria->nombre === 'General') {
            return redirect()->back()->with('error_gen', 'No puedes eliminar la categoría "General".');
        }

        // Verificar si hay productos relacionados con la categoría
        if ($categoria->productos()->exists()) {
            // Actualizar los productos relacionados a una categoría general
            $categoriaGeneral = Categoria::where('nombre', 'General')->first();

            if (!$categoriaGeneral) {
                // Si no existe la categoría general, crearla
                $categoriaGeneral = Categoria::create([
                    'nombre' => 'General',
                    'eliminado' => false,  // Asumiendo que la categoría general nunca se elimina
                ]);
            }

            // Actualizar los productos relacionados
            $categoria->productos()->update(['categoria_id' => $categoriaGeneral->id]);
        }

        // Marcar la categoría como eliminada
        $categoria->update(['eliminado' => true]);

        return redirect()->back()->with('delete_cat', 'Categoría eliminada correctamente.');
    }

}
