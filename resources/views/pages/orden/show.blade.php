<!-- Contenido del presupuesto para el modal -->
<div id="orden" class="container my-3"
    style="font-family: Arial, sans-serif; margin: 0; padding: 0; width: 100%; margin: auto; background-color: white; padding: 20px; box-sizing: border-box;">
    <div class="header"
        style="background-color:#212529; color:white; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid black; padding: 10px; margin-bottom: 10px; border-radius:10px;">
        <h1 class="m-0" style="margin: 0; color:white; !important">PhPresus</h1>
        <p class="date" style="margin: 0;">Fecha actual: {{ date('d-m-Y') }}</p>
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
                    {{ $orden->created_at->format('d-m-Y') }}
                </strong>

                Fecha de presupuesto:
                <strong>
                @if ($orden->presupuesto===null)
                    Presupuesto eliminado.
                @else
                    {{ $orden->presupuesto->created_at->format('d-m-Y') }}
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

    <style>
        .brd{
            border-radius:10px;
        }
    </style>

    <div class="">
        <p><strong>Productos en orden</strong></p>
        <div class="" style="padding: 0;">
            <div class="table-responsive brd" style="width: 100%; overflow-x: auto;">
                <table class="table table-bordered rounded-table" style="width: 100%; border-collapse: collapse;">
                    <thead style="background-color: #212529; color: white;">
                        <tr>
                            <th style="border: 1px solid black; padding: 8px; text-align: left; color:white;">Id</th>
                            <th style="border: 1px solid black; padding: 8px; text-align: left; color:white;">Producto
                            </th>
                            <th style="border: 1px solid black; padding: 8px; text-align: left; color:white;">Cantidad
                            </th>
                            <th style="border: 1px solid black; padding: 8px; text-align: left; color:white;">Precio
                                Unitario</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($productos_print))
                            @foreach ($productos_print as $productoOrden)
                                <tr>
                                    <td style="border: 1px solid black; padding: 8px; text-align: left;">
                                        {{ $productoOrden->producto->id }}</td>
                                    <td style="border: 1px solid black; padding: 8px; text-align: left;">
                                        {{ $productoOrden->producto->nombre }}</td>
                                    <td style="border: 1px solid black; padding: 8px; text-align: left;">
                                        {{ $productoOrden->cantidad }}</td>
                                    <td style="border: 1px solid black; padding: 8px; text-align: left;">
                                        {{ $productoOrden->precio }}</td>
                                </tr>
                            @endforeach
                        @else
                            @foreach ($orden->productoOrden as $productoOrden)
                                <tr>
                                    <td style="border: 1px solid black; padding: 8px; text-align: left;">
                                        {{ $productoOrden->producto->id }}</td>
                                    <td style="border: 1px solid black; padding: 8px; text-align: left;">
                                        {{ $productoOrden->producto->nombre }}</td>
                                    <td style="border: 1px solid black; padding: 8px; text-align: left;">
                                        {{ $productoOrden->cantidad }}</td>
                                    <td style="border: 1px solid black; padding: 8px; text-align: left;">
                                        {{ $productoOrden->precio }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="total" style="display: flex; justify-content: space-between;">
                <p>Precio Total:</p>
                <p><strong>€ {{ $orden->precio_total }}</strong></p>
            </div>
        </div>
    </div>
</div>
