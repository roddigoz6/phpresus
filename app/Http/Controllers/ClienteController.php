<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sortBy = $request->input('sort_by');
        $tab = $request->input('tab', 'all');

        $query = Cliente::where('eliminado', false);

        if ($search) {
            $query->where('nombre', 'like', "%$search%");
        }

        if ($sortBy) {
            switch ($sortBy) {
                case 'name':
                    $query->orderBy('nombre');
                    break;
                case 'date':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'established':
                    $query->where('establecido', true);
                    break;
                default:
                    $query->orderBy('nombre');
                    break;
            }
        }

        $query->orderBy('id', 'desc');
        $clientes = $query->paginate(15);

        return view('pages.cliente.index', compact('clientes', 'tab'));
    }

    public function getClientesData()
    {
        // Obtener todos los clientes que no están eliminados
        $clientes = Cliente::where('eliminado', false)->get();

        // Mapear los datos para que select2 pueda usarlos
        $clientesData = $clientes->map(function ($cliente) {
            return [
                'id' => $cliente->id,
                'text' => $cliente->nombre . ' ' . $cliente->apellido,
                'contacto' => $cliente->contacto,
                'pago' => $cliente->pago,
            ];
        });

        return response()->json($clientesData);
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
        // Obtener la URL del referer
        $context = $request->input('context');

        // Validar los datos del formulario
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:9',
            'email' => 'nullable|string|max:255',
            'movil' => 'nullable|string|max:20',
            'contacto' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'cp' => 'nullable|string|max:9',
            'poblacion' => 'nullable|string|max:255',
            'provincia' => 'nullable|string|max:255',
            'fax' => 'nullable|string|max:9',
            'cargo' => 'nullable|string|max:255',
            'titular_nom' => 'nullable|string|max:255',
            'titular_ape' => 'nullable|string|max:255',
            'direccion_envio' => 'nullable|string|max:255',
            'cp_envio' => 'nullable|string|max:255',
            'poblacion_envio' => 'nullable|string|max:255',
            'provincia_envio' => 'nullable|string|max:255',
        ]);

        // Crear el nuevo cliente en la base de datos
        $cliente = new Cliente();
        $cliente->fill($validated);
        $cliente->save();

        if ($context === 'index') {
            // Redirigir con mensaje de éxito
            return redirect()->back()->with('success_cli', 'Cliente agregado con éxito.');
        } else {
            // Devolver la respuesta JSON con los detalles del cliente
            return response()->json($cliente);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $cliente = Cliente::with('presupuestos')->findOrFail($id);
        $countPresupuestos = $cliente->presupuestos()->where('eliminado', false)->count();
        $countPresupuestosAceptados = $cliente->presupuestos()->where('eliminado', false)->where('aceptado', true)->count();
        $countPresupuestosNoAceptados = $cliente->presupuestos()->where('eliminado', false)->where('aceptado', false)->count();

        return view('pages.cliente.show', compact(
            'cliente',
            'countPresupuestos',
            'countPresupuestosAceptados',
            'countPresupuestosNoAceptados'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:9',
            'email' => 'nullable|string|max:255',
            'movil' => 'required|string|max:20',
            'contacto' => 'nullable|string|max:255',
            'direccion' => 'required|string|max:255',
            'cp' => 'required|string|max:9',
            'poblacion' => 'required|string|max:255',
            'provincia' => 'required|string|max:255',
            'fax' => 'nullable|string|max:9',
            'cargo' => 'nullable|string|max:255',
            'titular_nom' => 'nullable|string|max:255',
            'titular_ape' => 'nullable|string|max:255',
            'direccion_envio' => 'nullable|string|max:255',
            'cp_envio' => 'nullable|string|max:255',
            'poblacion_envio' => 'nullable|string|max:255',
            'provincia_envio' => 'nullable|string|max:255',
            'pago' => 'required|string|max:255',
        ]);

        // Actualizar los datos del cliente
        $cliente->nombre = $request->nombre;
        $cliente->apellido = $request->apellido;
        $cliente->dni = $request->dni;
        $cliente->email = $request->email;
        $cliente->movil = $request->movil;
        $cliente->contacto = $request->contacto;
        $cliente->direccion = $request->direccion;
        $cliente->cp = $request->cp;
        $cliente->poblacion = $request->poblacion;
        $cliente->provincia = $request->provincia;
        $cliente->fax = $request->fax;
        $cliente->cargo = $request->cargo;
        $cliente->titular_nom = $request->titular_nom;
        $cliente->titular_ape = $request->titular_ape;
        $cliente->direccion_envio = $request->direccion_envio;
        $cliente->cp_envio = $request->cp_envio;
        $cliente->poblacion_envio = $request->poblacion_envio;
        $cliente->provincia_envio = $request->provincia_envio;
        $cliente->pago = $request->pago;

        $cliente->save();

        // Redireccionar con mensaje de éxito
        return redirect()->back()->with('update_cli', 'Cliente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        // Verificar y eliminar presupuestos relacionados que no estén marcados como eliminados
        $presupuestosActivos = $cliente->presupuestos()->where('eliminado', false)->get();
        if ($presupuestosActivos->isNotEmpty()) {
            foreach ($presupuestosActivos as $presupuesto) {
                app(PresupuestoController::class)->destroy($presupuesto);
            }
        }

        // Verificar y desasociar órdenes relacionadas
        if ($cliente->ordenes()->exists()) {
            $cliente->ordenes()->update(['cliente_id' => null, 'presupuesto_id' => null]);
        }

        // Marcar al cliente como eliminado
        $cliente->update(['eliminado' => true]);

        return redirect()->back()->with('delete_cli', 'Cliente eliminado.');
    }

}
