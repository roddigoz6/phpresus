<!-- Contenido del presupuesto para el modal -->
<div id="orden" class="container"
    style="font-family: Arial, sans-serif; margin: 0; padding: 0; width: 100%; margin: auto; background-color: white; padding: 20px; box-sizing: border-box;">
    <div class="header"
        style="background-color:#212529; color:white; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid black; padding: 10px; margin-bottom: 10px; border-radius:10px;">
        <h1 class="m-0" style="margin: 0; color:white; !important">PhPresus</h1>
        <p class="date" style="margin: 0;">Fecha actual: {{ date('d/m/Y') }}</p>
    </div>

    <div class="details" style="display: flex; justify-content: space-between; ">
        <div class="col">
            <strong>Datos de la orden</strong>
            <p>
                Orden:
                <strong>
                    {{ $orden->id }}
                </strong>

                Presupuesto:
                <strong>
                @if ($orden->presupuesto===null)
                    Presupuesto eliminado.
                @else
                    {{ $orden->presupuesto->id }}
                @endif
                </strong>

                Fecha de orden:
                <strong>
                    {{ $orden->created_at->format('d/m/Y') }}
                </strong>

                Fecha de presupuesto:
                <strong>
                @if ($orden->presupuesto===null)
                    Presupuesto eliminado.
                @else
                    {{ $orden->presupuesto->created_at->format('d/m/Y') }}
                @endif
                </strong>
            </p>

            <strong>Datos del cliente</strong>
            <p>
                Cliente:
                <strong>
                    {{ $orden->cliente_nombre }} {{ $orden->cliente_apellido }}
                </strong>

                DNI/NIE:
                <strong>
                    {{ $orden->cliente_dni }}
                </strong>

                Email:
                <strong>
                    @if ($orden->cliente === null)
                        No registrado
                    @elseif ($orden->cliente->email === null)
                        Cliente no tiene email registrado
                    @else
                        {{ $orden->cliente->email }}
                    @endif
                </strong>

                Móvil:
                <strong>
                    @if ($orden->cliente===null)
                        No registrado
                    @elseif ($orden->cliente->movil===null)
                        Cliente no tiene móvil registrado
                    @else
                        {{ $orden->cliente->movil }}
                    @endif
                </strong>

                Código Postal (C.P.):
                <strong>
                    @if ($orden->cliente===null)
                        No registrado
                    @elseif ($orden->cliente->cp===null)
                        No registrado.
                    @else
                        {{ $orden->cliente->cp }}
                    @endif
                </strong>

                Tipo de pago:
                <strong>
                    @if ($orden->cliente===null)
                        No registrado
                    @elseif ($orden->cliente->pago===null)
                        No registrado.
                    @else
                        {{ $orden->cliente->pago }}
                    @endif
                </strong>

            </p>
        </div>
    </div>

        <p><strong>Productos en orden</strong></p>
            <div class="table-responsive" style="width: 100%; overflow-x: auto; border-radius: 10px;">
                <table class="table table-light text-center table-hover rounded-table" style="width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden;">
                    <thead class="table-dark" style="background-color: #212529; color: white;">
                        <tr style="margin-top: 8px; margin-bottom: 8px;">
                            <th>Id</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Precio Total</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center;">
                        @if (isset($productos_print))
                            @foreach ($productos_print as $productoOrden)
                                <tr style="margin-top: 8px; margin-bottom: 8px;">
                                    <td>{{ $productoOrden->producto->id }}</td>
                                    <td>{{ $productoOrden->producto->nombre }}</td>
                                    <td>{{ $productoOrden->cantidad }}</td>
                                    <td>{{ $productoOrden->precio }}</td>
                                    <td>{{ $productoOrden->cantidad * $productoOrden->precio}}</td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($orden->productoOrden as $productoOrden)
                                <tr>
                                    <td>
                                        {{ $productoOrden->producto->id }}</td>
                                    <td>
                                        {{ $productoOrden->producto->nombre }}</td>
                                    <td>
                                        {{ $productoOrden->cantidad }}</td>
                                    <td>
                                        {{ $productoOrden->precio }}</td>
                                        <td>{{ $productoOrden->cantidad * $productoOrden->precio}}</td>
                                </tr>
                            @endforeach
                        @endif
                        <tr style="border-top:1px solid black; margin-top: 8px; margin-bottom: 8px;">
                            <td><strong>Total</strong></td>
                            <td colspan="3"></td>
                            <td><strong>€ {{ $orden->precio_total }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
</div>
