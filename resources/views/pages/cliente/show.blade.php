<!-- Contenido del presupuesto para el modal -->
<div id="cliente" class="container my-3">

    <div class="header-modal">
        <h5 class="modal-title">Datos del cliente</h5>
    </div>
    <div class="row mt-3">
        <div class="col">
            <p><strong>Nombre:</strong> {{ $cliente->nombre ?? 'No registrado' }}</p>
            <p><strong>Apellido:</strong> {{ $cliente->apellido ?? 'No registrado' }}</p>
            <p><strong>DNI:</strong> {{ $cliente->dni ?? 'No registrado' }}</p>
            <p><strong>Email:</strong> {{ $cliente->email ?? 'No registrado' }}</p>
            <p><strong>Número Móvil:</strong> {{ $cliente->movil ?? 'No registrado' }}</p>
            <p><strong>Contacto:</strong> {{ $cliente->contacto ?? 'No registrado' }}</p>
        </div>
        <div class="col">
            <p><strong>Dirección:</strong> {{ $cliente->direccion ?? 'No registrado' }}</p>
            <p><strong>Código Postal:</strong> {{ $cliente->cp ?? 'No registrado' }}</p>
            <p><strong>Población:</strong> {{ $cliente->poblacion ?? 'No registrado' }}</p>
            <p><strong>Provincia:</strong> {{ $cliente->provincia ?? 'No registrado' }}</p>
            <p><strong>Fax:</strong> {{ $cliente->fax ?? 'No registrado' }}</p>
            <p><strong>Cargo:</strong> {{ $cliente->cargo ?? 'No registrado' }}</p>
        </div>
    </div>

    <div class="header-modal">
        <h5 class="modal-title">Datos del envío</h5>
    </div>
    <div class="row mt-3">
        <div class="col">
            <p><strong>Titular Nombre:</strong> {{ $cliente->titular_nom ?? 'No registrado' }}</p>
            <p><strong>Titular Apellido:</strong> {{ $cliente->titular_ape ?? 'No registrado' }}</p>
            <p><strong>Dirección de Envío:</strong> {{ $cliente->direccion_envio ?? 'No registrado' }}</p>
        </div>
        <div class="col">
            <p><strong>Código Postal de Envío:</strong> {{ $cliente->cp_envio ?? 'No registrado' }}</p>
            <p><strong>Población de Envío:</strong> {{ $cliente->poblacion_envio ?? 'No registrado' }}</p>
            <p><strong>Provincia de Envío:</strong> {{ $cliente->provincia_envio ?? 'No registrado' }}</p>
        </div>
    </div>


    <div class="header-modal">
        <h5 class="modal-title">Pagos y tipo de cliente</h5>
    </div>
    <div class="row mt-3">
        <div class="col">
            <p><strong>Forma de Pago:</strong> {{ $cliente->pago }}</p>
        </div>
        <div class="col">
            <p><strong>Establecido:</strong> {{ $cliente->establecido ? 'Sí' : 'No' }}</p>
        </div>
    </div>
    <hr>

    <!-- Tabla de Presupuestos -->
    <h5>Presupuestos de <strong>{{$cliente->nombre}}</strong> : <strong>{{$countPresupuestos}}</strong></h5>

    @if ($countPresupuestos!=0)
    <p>
        Aceptados:
        <strong> {{ $countPresupuestosAceptados }}</strong>
        No aceptados:
        <strong> {{ $countPresupuestosNoAceptados }}</strong>
    </p>
    @endif

    <table class="table table-light text-center table-hover rounded-table">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Precio Total</th>
                <th>Aceptado</th>
            </tr>
        </thead>
        <tbody>
            @if ($cliente->presupuestos->isEmpty())
                <tr>
                    <td colspan="4">No hay presupuestos registrados para este cliente.</td>
                </tr>
            @else
            @foreach ($cliente->presupuestos as $presupuesto)
            <tr>
                <td>{{ $presupuesto->id }}</td>
                <td>{{ $presupuesto->created_at->format('d-m-Y') }}</td>
                <td>{{ $presupuesto->precio_total }}</td>
                <td>{{ $presupuesto->aceptado ? 'Sí' : 'No' }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

    <!-- Tabla de Órdenes -->
    <h5>Órdenes de <strong>{{$cliente->nombre}}</strong> : <strong>{{$countOrdenes}}</strong></h5>
    @if ($countOrdenes!=0)
    <p>
        Cobradas:
        <strong> {{ $countOrdenesCobradas }}</strong>
        Por cobrar:
        <strong> {{ $countOrdenesNoCobradas }}</strong>
    </p>
    @endif

    <table class="table table-light text-center table-hover rounded-table">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Precio Total</th>
                <th>Cobrado</th>
            </tr>
        </thead>
        <tbody>
            @if ($cliente->ordenes->isEmpty())
            <tr>
                <td colspan="4">No hay ordenes registradas para este cliente.</td>
            </tr>
            @else
            @foreach ($cliente->ordenes as $orden)
            <tr>
                <td>{{ $orden->id }}</td>
                <td>{{ $orden->created_at->format('d-m-Y') }}</td>
                <td>{{ $orden->precio_total }}</td>
                <td>{{ $orden->cobrado ? 'Sí' : 'No' }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>
