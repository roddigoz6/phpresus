<!-- Contenido del presupuesto para el modal -->
<div id="orden" class="container"
    style="font-family: Arial, sans-serif; margin: 0; padding: 0; width: 100%; margin: auto; background-color: white; padding: 20px; box-sizing: border-box;">
    <div class="header"
        style="background-color:#212529; color:white; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid black; padding: 10px; margin-bottom: 10px; border-radius:10px;">
        <h1 class="m-0" style="margin: 0; color:white;">Kasier</h1>
        <p class="date" style="margin: 0;">Fecha actual: {{ date('d/m/Y') }}</p>
    </div>

    <div class="details" style="display: flex; justify-content: space-between; ">
        <div class="col">
            <strong>Datos del proyecto</strong>
            <p>
                Proyecto:
                <strong>
                    {{ $proyecto->proyecto_id }}
                </strong>

                Fecha de creación:
                <strong>
                </strong>

            </p>

            <strong>Datos del cliente</strong>
            <p>
                Cliente:
                <strong>
                    {{ $cliente->nombre }} {{ $cliente->apellido }}
                </strong>

                DNI/NIE:
                <strong>
                    {{ $cliente->dni }}
                </strong>

                Email:
                <strong>
                    @if ($cliente->email === null)
                        Cliente no tiene email registrado
                    @else
                        {{ $cliente->email }}
                    @endif
                </strong>

                Móvil:
                <strong>
                    @if ($cliente->movil === null)
                        Cliente no tiene móvil registrado
                    @else
                        {{ $cliente->movil }}
                    @endif
                </strong>

                Código Postal (C.P.):
                <strong>
                    @if ($cliente->cp === null)
                        No registrado.
                    @else
                        {{ $cliente->cp }}
                    @endif
                </strong>

                Tipo de pago:
                <strong>
                    @if ($proyecto->pago === null)
                        No registrado.
                    @else
                        {{ $proyecto->pago }}
                    @endif
                </strong>

            </p>
        </div>
    </div>

    <p><strong>Productos</strong></p>

    <div class="table-responsive" style="width: 100%; overflow-x: auto; border-radius: 10px;">
        <table class="table table-light text-center table-hover rounded-table" style="width: 100%; border-collapse: collapse; border-radius: 10px; overflow: hidden;">
            <thead class="table-dark" style="background-color: #252129; color: white;">
                <tr style="margin-top: 8px; margin-bottom: 8px;">
                    <th>Id</th>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Precio Total</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                @foreach ($productoPresupuestos as $productoPresupuesto)
                    <tr style="margin-top: 8px; margin-bottom: 8px;">
                        @switch($productoPresupuesto->tipo)
                        @case('linea')
                            <td>{{ $productoPresupuesto->id }}</td>
                            <td>{{ $productoPresupuesto->nombre }}</td>
                            <td>{{ $productoPresupuesto->descripcion }}</td>
                            <td>{{ $productoPresupuesto->cantidad }}</td>
                            <td>{{ $productoPresupuesto->precio }}</td>
                            <td>{{ $productoPresupuesto->cantidad * $productoPresupuesto->precio }}</td>
                            @break

                        @case('capitulo')
                            <td colspan="2"><strong>{{ $productoPresupuesto->titulo }}</strong></td>
                            <td colspan="2">{{ $productoPresupuesto->descripcion }}</td>
                            @break

                        @default
                            <td colspan="6">Tipo de producto no reconocido</td>
                    @endswitch
                    </tr>
                @endforeach
                <tr style="border-top:1px solid black; margin-top: 8px; margin-bottom: 8px;">
                    <td><strong>Total</strong></td>
                    <td colspan="4"></td>
                    <td><strong>€ {{ $productoPresupuestos->sum(function ($pp) { return $pp->cantidad * $pp->precio; }) }}</strong></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
