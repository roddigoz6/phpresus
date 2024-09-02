<!-- Contenido del presupuesto para el modal -->
<div id="cliente" class="container my-3">

    <div class="header-modal">
        <h5 class="modal-title">Datos del cliente</h5>
    </div>
    <div class="row mt-3 mx-3">
        <div class="col">
            <p><strong>Nombre:</strong> {!! $cliente->nombre ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>Apellido:</strong> {!! $cliente->apellido ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>DNI:</strong> {!! $cliente->dni ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>Email:</strong> {!! $cliente->email ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>Número Móvil:</strong> {!! $cliente->movil ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>Contacto:</strong> {!! $cliente->contacto ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
        </div>
        <div class="col">
            <p><strong>Dirección:</strong> {!! $cliente->direccion ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>Código Postal:</strong> {!! $cliente->cp ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>Población:</strong> {!! $cliente->poblacion ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>Provincia:</strong> {!! $cliente->provincia ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>Fax:</strong> {!! $cliente->fax ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>Cargo:</strong> {!! $cliente->cargo ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
        </div>
    </div>

    <div class="header-modal">
        <h5 class="modal-title">Datos del envío</h5>
    </div>
    <div class="row mt-3 mx-3">
        <div class="col">
            <p><strong>Titular Nombre:</strong> {!! $cliente->titular_nom ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>Titular Apellido:</strong> {!! $cliente->titular_ape ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>Dirección de Envío:</strong> {!! $cliente->direccion_envio ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
        </div>
        <div class="col">
            <p><strong>Código Postal de Envío:</strong> {!! $cliente->cp_envio ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>Población de Envío:</strong> {!! $cliente->poblacion_envio ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
            <p><strong>Provincia de Envío:</strong> {!! $cliente->provincia_envio ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
        </div>
    </div>

    <div class="header-modal">
        <h5 class="modal-title">Pagos y tipo de cliente</h5>
    </div>
    <div class="row mt-3 mx-3">
        <div class="col">
            <p><strong>Forma de Pago:</strong> {!! $cliente->pago ?: "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>" !!}</p>
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
                <td><span class="badge px-4 fs-7 badge-light-info">{{ $presupuesto->id }}</span></td>
                <td>{{ $presupuesto->created_at->format('d/m/Y') }}</td>
                <td><strong>€{{ $presupuesto->precio_total }}</strong></td>
                <td>{{ $presupuesto->aceptado ? 'Sí' : 'No' }}</td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>

</div>
