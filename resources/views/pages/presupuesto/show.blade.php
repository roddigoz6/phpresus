<!-- Contenido del presupuesto para el modal -->
<div id="orden" class="container"
    style="font-family: Arial, sans-serif; margin: 0; padding: 0; width: 100%; margin: auto; background-color: white; padding: 20px; box-sizing: border-box;">
    <div class="header"
        style="background-color:#212529; color:white; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid black; padding: 10px; margin-bottom: 10px; border-radius:10px;">
        <h1 class="m-0" style="margin: 0; color:white; !important">PhPresus</h1>
        <p class="date" style="margin: 0;">Fecha actual: {{ date('d-m-Y') }}</p>
    </div>

    <div class="details" style="display: flex; justify-content: space-between; ">
        <div class="col">
            <strong>Datos del presupuesto</strong>
            <p>
                Presupuesto:
                <strong>
                    {{ $presupuesto->id }}
                </strong>

                Fecha de presupuesto:
                <strong>
                    {{ $presupuesto->created_at->format('d-m-Y') }}
                </strong>

            </p>

            <strong>Datos del cliente</strong>
            <p>
                Cliente:
                <strong>
                    {{ $presupuesto->cliente->nombre }} {{ $presupuesto->cliente->apellido }}
                </strong>

                DNI/NIE:
                <strong>
                    {{ $presupuesto->cliente->dni }}
                </strong>

                Email:
                <strong>
                    @if ($presupuesto->cliente->email===null)
                        Cliente no tiene email registrado
                    @else
                        {{ $presupuesto->cliente->email }}
                    @endif
                </strong>

                Móvil:
                <strong>
                    @if ($presupuesto->cliente->movil ===null)
                        Cliente no tiene email registrado
                    @else
                        {{ $presupuesto->cliente->movil }}
                    @endif
                </strong>

                Código Postal (C.P.):
                <strong>
                    @if ($presupuesto->cliente->cp===null)
                        No registrado.
                    @else
                        {{ $presupuesto->cliente->cp }}
                    @endif
                </strong>

                Tipo de pago:
                <strong>
                    @if ($presupuesto->cliente->pago===null)
                        No registrado.
                    @else
                        {{ $presupuesto->cliente->pago }}
                    @endif
                </strong>

            </p>
        </div>
    </div>

    <p><strong>Productos en el presupuesto7</strong></p>

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
                    @foreach ($productos_print as $productoPresupuesto)
                        <tr style="margin-top: 8px; margin-bottom: 8px;">
                            <td>{{ $productoPresupuesto->producto->id }}</td>
                            <td>{{ $productoPresupuesto->producto->nombre }}</td>
                            <td>{{ $productoPresupuesto->cantidad }}</td>
                            <td>{{ $productoPresupuesto->precio }}</td>
                            <td>{{ $productoPresupuesto->cantidad * $productoPresupuesto->precio }}</td>
                        </tr>
                    @endforeach
                @else
                    @foreach ($presupuesto->productoPresupuestos as $productoPresupuesto)
                    <tr style="margin-top: 8px; margin-bottom: 8px;">
                        <td>{{ $productoPresupuesto->producto->id }}</td>
                        <td>{{ $productoPresupuesto->producto->nombre }}</td>
                        <td>{{ $productoPresupuesto->cantidad }}</td>
                        <td>{{ $productoPresupuesto->precio }}</td>
                        <td>{{ $productoPresupuesto->cantidad * $productoPresupuesto->precio }}</td>
                    </tr>
                    @endforeach
                @endif
                <tr style="border-top:1px solid black; margin-top: 8px; margin-bottom: 8px;">
                    <td><strong>Total</strong></td>
                    <td colspan="3"></td>
                    <td><strong>€ {{ $presupuesto->precio_total }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

