<x-default-layout>
    @section('title')
        Proyectos
    @endsection
<div class="container">

    <div class="row my-3 align-items-center">
        <div class="col text-start">
            <h2>Proyectos</h2>
        </div>
    </div>

    <form action="{{ route('proyecto.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Buscar por nombre de cliente">
            <button class="btn btn-light-primary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <!-- Pestañas de navegación -->
    <ul class="nav nav-tabs" id="proyectoTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $tab == 'all' ? 'active' : '' }}" id="all-tab" href="{{ route('proyecto.index', ['tab' => 'all', 'page' => 1]) }}" role="tab" aria-controls="all" aria-selected="{{ $tab == 'all' ? 'true' : 'false' }}">Todos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $tab == 'abiertos' ? 'active' : '' }}" id="abiertos-tab" href="{{ route('proyecto.index', ['tab' => 'abiertos', 'page' => 1]) }}" role="tab" aria-controls="abiertos" aria-selected="{{ $tab == 'abiertos' ? 'true' : 'false' }}">Abiertos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $tab == 'cerrados' ? 'active' : '' }}" id="cerrados-tab" href="{{ route('proyecto.index', ['tab' => 'cerrados', 'page' => 1]) }}" role="tab" aria-controls="cerrados" aria-selected="{{ $tab == 'cerrados' ? 'true' : 'false' }}">Cerrados</a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="proyectoTabsContent">

        <!-- Todos los proyectos -->
        <div class="tab-pane fade {{ $tab == 'all' ? 'show active' : '' }}" id="all" role="tabpanel" aria-labelledby="all-tab">
            <table class="table text-center table-hover rounded-table">
                <thead class="bg-secondary">
                    <tr class="align-middle">
                        <th class="icon-table">Proyecto</th>
                        <th class="icon-table">Presupuesto</th>
                        <th class="icon-table">Título / Serie de referencia</th>
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">Precio total</th>
                        <th class="icon-table">Forma de pago</th>
                        <th class="icon-table">Visita asignada</th>
                        <th class="icon-table">Fecha de creación</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($proyectos->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">No hay proyectos creados.</td>
                        </tr>
                    @else
                        @foreach ($proyectos as $proyecto)
                            <tr class="text-center">
                                @switch($proyecto->estado)
                                    @case('abierto')
                                        <td class="align-middle">
                                            <a href="#"
                                            class="btn btn-light-secondary"
                                            data-presupuesto-id="{{ $proyecto->proyecto_id }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detallesProyectoModal"
                                            data-proyecto-id="{{ $proyecto->proyecto_id }}"
                                            title="Ver detalle del proyecto">
                                            {{ $proyecto->proyecto_id }}
                                            <span class="badge badge-info">A</span>
                                            </a>
                                        </td>
                                        @break

                                    @case('cerrado')
                                        <td class="align-middle">
                                            <a href="#"
                                            class="btn btn-light-secondary"
                                            data-presupuesto-id="{{ $proyecto->proyecto_id }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detallesProyectoModal"
                                            data-proyecto-id="{{ $proyecto->proyecto_id }}"
                                            title="Ver detalle del proyecto">
                                            {{ $proyecto->proyecto_id }}
                                            <span class="badge badge-secondary">C</span>
                                            </a>
                                        </td>
                                        @break

                                    @default
                                        <td class="align-middle">Estado desconocido</td>
                                @endswitch
                                @if ($proyecto->presupuestos->isEmpty())
                                    <td class="align-middle">No hay presupuestos.</td>
                                @else
                                    <td class="align-middle">{{$proyecto->presupuestos->count()}} presupuestos.</td>
                                @endif
                                <td class="align-middle"> {{ $proyecto->serie_ref ?? 'No registrado' }} - {{ $proyecto->num_ref ?? 'No registrado' }} </td>
                                <td class="align-middle">
                                    <a
                                        class="item-link"
                                        type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#clienteProyectoModal"
                                        data-nombre="{{ $proyecto->cliente->nombre }}"
                                        data-apellido="{{ $proyecto->cliente->apellido }}"
                                        data-dni="{{ $proyecto->cliente->dni }}"
                                        data-email="{{ $proyecto->cliente->email }}"
                                        data-movil="{{ $proyecto->cliente->movil }}"
                                        data-contacto="{{ $proyecto->cliente->contacto }}"
                                        data-direccion="{{ $proyecto->cliente->direccion }}"
                                        data-cp="{{ $proyecto->cliente->cp }}"
                                        data-poblacion="{{ $proyecto->cliente->poblacion }}"
                                        data-provincia="{{ $proyecto->cliente->provincia }}"
                                        data-fax="{{ $proyecto->cliente->fax }}"
                                        data-cargo="{{ $proyecto->cliente->cargo }}"
                                        data-titular-nom="{{ $proyecto->cliente->titular_nom }}"
                                        data-titular-ape="{{ $proyecto->cliente->titular_ape }}"
                                        data-direccion-envio="{{ $proyecto->cliente->direccion_envio }}"
                                        data-cp-envio="{{ $proyecto->cliente->cp_envio }}"
                                        data-poblacion-envio="{{ $proyecto->cliente->poblacion_envio }}"
                                        data-provincia-envio="{{ $proyecto->cliente->provincia_envio }}"
                                        data-pago="{{ $proyecto->cliente->pago }}"
                                        data-establecido="{{ $proyecto->cliente->establecido }}">
                                        {{ $proyecto->cliente->nombre }} {{ $proyecto->cliente->apellido }}
                                    </a>
                                </td>
                                @if ($proyecto->presupuestos->isEmpty())
                                    <td class="align-middle">No hay presupuestos</td>
                                @else
                                    <td class="align-middle">-</td>
                                @endif
                                <td class="align-middle">{{ $proyecto->pago }}</td>

                                <td class="align-middle">
                                    @if($proyecto->visitas->isEmpty())
                                        No hay visitas
                                    @else
                                        <a href="{{route('visita.index')}}" class="btn btn-light-primary">Sí, ir a visitas</a>
                                    @endif
                                </td>

                                <td class="align-middle">{{ $proyecto->created_at->format('d/m/Y H:i') }}</td>

                                <td class="align-middle">
                                    <div class="card-toolbar">
                                        <button type="button" class="btn btn-sm btn-icon btn-light-primary me-n3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end"><i class="fa-solid fa-bars"></i></button>
                                        @include('partials/menus/_acciones_proyecto', ['proyecto' => $proyecto])
                                    </div>
                                </td>
                            </tr>
                            @foreach ($proyecto->presupuestos->filter(function($presupuesto) {
                                return !$presupuesto->eliminado;
                                }) as $presupuesto)
                                <tr>
                                    <td>-</td>
                                    @switch($presupuesto->estado)
                                        @case('presupuestado')
                                        <td class="align-middle">
                                            {{$presupuesto->nom_pres ?? 'No registrado'}}
                                            <span class="badge badge-warning">P</span>
                                        </td>
                                            @break
                                        @case('presupuesto_aceptado')
                                            <td class="align-middle">
                                                {{$presupuesto->nom_pres ?? 'No registrado'}}
                                                <span class="badge badge-primary">A</span>
                                            </td>
                                                @break

                                        @case('por_cobrar')
                                            <td class="align-middle">
                                                {{$presupuesto->nom_pres ?? 'No registrado'}}
                                                <span class="badge badge-success">C</span>
                                            </td>
                                                @break
                                        @default

                                    @endswitch
                                    <td class="align-middle">-</td>
                                    <td class="align-middle">-</td>
                                    <td class="align-middle">€{{$presupuesto->precio_total}}</td>
                                    <td class="align-middle">-</td>
                                    <td class="align-middle">-</td>
                                    <td class="align-middle">{{$presupuesto->created_at->format('d/m/Y H:i')}}</td>
                                    <td class="align-middel">
                                        <div class="card-toolbar">
                                            <button type="button" class="btn btn-sm btn-icon btn-light-primary me-n3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end"><i class="fa-solid fa-bars"></i></button>
                                            @include('partials/menus/_acciones_presupuesto', ['proyecto' => $proyecto])
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endif
                </tbody>
            </table>

            @php
                $totalPages = $proyectos->lastPage();
                $currentPage = $proyectos->currentPage();
                $maxPagesToShow = 5; // Número máximo de enlaces de página a mostrar

                $startPage = max($currentPage - floor($maxPagesToShow / 2), 1);
                $endPage = min($startPage + $maxPagesToShow - 1, $totalPages);

                // Ajuste para cuando hay menos de 10 páginas a mostrar al principio o al final
                if ($endPage - $startPage + 1 < $maxPagesToShow) {
                    $startPage = max($endPage - $maxPagesToShow + 1, 1);
                }
            @endphp

            <div class="d-flex justify-content-center">
                <ul class="pagination">
                    @if ($startPage > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $proyectos->url(1) }}&tab=all">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $proyectos->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $proyectos->url($i) }}&tab=all">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ $proyectos->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>


        <!-- Abiertos -->
        <div class="tab-pane fade {{ $tab == 'abiertos' ? 'show active' : '' }}" id="abiertos" role="tabpanel" aria-labelledby="abiertos-tab">
            <table class="table text-center table-hover rounded-table">
                <thead class="bg-secondary">
                    <tr class="align-middle">
                        <th class="icon-table">Proyecto</th>
                        <th class="icon-table">Título / Serie de referencia</th>
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">Forma de pago</th>
                        <th class="icon-table">Visita asignada</th>
                        <th class="icon-table">Fecha de creación</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($proyectosAbiertos->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">No hay proyectos abiertos.</td>
                        </tr>
                    @else
                    @foreach ($proyectosAbiertos as $proyecto)
                        <tr class="text-center">
                            <td class="align-middle">
                                <a href="#"
                                    class="btn btn-light-secondary"
                                    data-presupuesto-id="{{ $proyecto->proyecto_id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detallesProyectoModal"
                                    data-proyecto-id="{{ $proyecto->proyecto_id }}"
                                    title="Ver detalle del proyecto">
                                    {{ $proyecto->proyecto_id }}
                                    <span class="badge badge-primary">A</span>
                                </a>
                            </td>

                            <td class="align-middle">{{ $proyecto->serie_ref ?? 'No registrado' }} - {{ $proyecto->num_ref ?? 'No registrado' }}</td>
                            <td class="align-middle">
                                <a
                                    class="item-link"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#clienteProyectoModal"
                                    data-nombre="{{ $proyecto->cliente->nombre }}"
                                    data-apellido="{{ $proyecto->cliente->apellido }}">
                                    {{ $proyecto->cliente->nombre }} {{ $proyecto->cliente->apellido }}
                                </a>
                            </td>
                            <td class="align-middle">{{ $proyecto->pago }}</td>
                            <td class="align-middle">{{ $proyecto->created_at->format('d/m/Y H:i') }}</td>

                            <td class="align-middle">
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-sm btn-icon btn-light-primary me-n3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end"><i class="fa-solid fa-bars"></i></button>
                                    @include('partials/menus/_acciones_proyecto', ['proyecto' => $proyecto])
                                </div>
                            </td>
                        </tr>

                        @foreach ($proyecto->presupuestos->filter(function($presupuesto) {
                            return !$presupuesto->eliminado;
                            }) as $presupuesto)
                            <tr>
                                <td>-</td>
                                <td class="align-middle">{{ $presupuesto->nom_pres ?? 'No registrado' }} <span class="badge badge-warning">{{ $presupuesto->estado }}</span></td>
                                <td class="align-middle">-</td>
                                <td class="align-middle">€{{ $presupuesto->precio_total }}</td>
                                <td class="align-middle">{{ $presupuesto->created_at->format('d/m/Y H:i') }}</td>
                                <td class="align-middle">
                                    <div class="card-toolbar">
                                        <button type="button" class="btn btn-sm btn-icon btn-light-primary me-n3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end"><i class="fa-solid fa-bars"></i></button>
                                        @include('partials/menus/_acciones_presupuesto', ['presupuesto' => $presupuesto]) <!-- Cambiado para pasar el presupuesto -->
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach

                    @endif
                </tbody>
            </table>

            @php
                $totalPages = $proyectosAbiertos->lastPage();
                $currentPage = $proyectosAbiertos->currentPage();
                $maxPagesToShow = 5; // Número máximo de enlaces de página a mostrar

                $startPage = max($currentPage - floor($maxPagesToShow / 2), 1);
                $endPage = min($startPage + $maxPagesToShow - 1, $totalPages);

                // Ajuste para cuando hay menos de 10 páginas a mostrar al principio o al final
                if ($endPage - $startPage + 1 < $maxPagesToShow) {
                    $startPage = max($endPage - $maxPagesToShow + 1, 1);
                }
            @endphp

            <div class="d-flex justify-content-center">
                <ul class="pagination">
                    @if ($startPage > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $proyectosAbiertos->url(1) }}&tab=abiertos">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $proyectosAbiertos->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $proyectosAbiertos->url($i) }}&tab=abiertos">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ $proyectosAbiertos->url($totalPages) }}&tab=abiertos">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Cerrados -->
        <div class="tab-pane fade {{ $tab == 'cerrados' ? 'show active' : '' }}" id="cerrados" role="tabpanel"
        aria-labelledby="cerrados-tab">
            <table class="table text-center table-hover rounded-table">
                <thead class="bg-secondary">
                    <tr class="align-middle">
                        <th class="icon-table">Proyecto</th>
                        <th class="icon-table">Título / Serie de referencia</th>
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">Forma de pago</th>
                        <th class="icon-table">Visita asignada</th>
                        <th class="icon-table">Fecha de creación</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($proyectosCerrados->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">No hay proyectos creados.</td>
                        </tr>
                    @else
                    @foreach ($proyectosCerrados as $proyecto)
                        <tr class="text-center">
                            <td class="align-middle">
                                <a href="#"
                                    class="btn btn-light-secondary"
                                    data-presupuesto-id="{{ $proyecto->proyecto_id }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#detallesProyectoModal"
                                    data-proyecto-id="{{ $proyecto->proyecto_id }}"
                                    title="Ver detalle del proyecto">
                                    {{ $proyecto->proyecto_id }}
                                    <span class="badge badge-secondary">C</span>
                                </a>
                            </td>

                            <td class="align-middle">{{ $proyecto->serie_ref ?? 'No registrado' }} - {{ $proyecto->num_ref ?? 'No registrado' }}</td>
                            <td class="align-middle">
                                <a
                                    class="item-link"
                                    type="button"
                                    data-bs-toggle="modal"
                                    data-bs-target="#clienteProyectoModal"
                                    data-nombre="{{ $proyecto->cliente->nombre }}"
                                    data-apellido="{{ $proyecto->cliente->apellido }}">
                                    {{ $proyecto->cliente->nombre }} {{ $proyecto->cliente->apellido }}
                                </a>
                            </td>
                            <td class="align-middle">{{ $proyecto->pago }}</td>
                            <td class="align-middle">{{ $proyecto->created_at->format('d/m/Y H:i') }}</td>

                            <td class="align-middle">
                                <div class="card-toolbar">
                                    <button type="button" class="btn btn-sm btn-icon btn-light-primary me-n3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end"><i class="fa-solid fa-bars"></i></button>
                                    @include('partials/menus/_acciones_proyecto', ['proyecto' => $proyecto])
                                </div>
                            </td>
                        </tr>

                        @foreach ($proyecto->presupuestos->filter(function($presupuesto) {
                                return !$presupuesto->eliminado;
                            }) as $presupuesto)
                            <tr>
                                <td>-</td>
                                <td class="align-middle">{{ $presupuesto->nom_pres ?? 'No registrado' }} <span class="badge badge-warning">{{ $presupuesto->estado }}</span></td>
                                <td class="align-middle">-</td>
                                <td class="align-middle">€{{ $presupuesto->precio_total }}</td>
                                <td class="align-middle">{{ $presupuesto->created_at->format('d/m/Y H:i') }}</td>
                                <td class="align-middle">
                                    <div class="card-toolbar">
                                        <button type="button" class="btn btn-sm btn-icon btn-light-primary me-n3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end"><i class="fa-solid fa-bars"></i></button>
                                        @include('partials/menus/_acciones_presupuesto', ['presupuesto' => $presupuesto]) <!-- Cambiado para pasar el presupuesto -->
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach

                    @endif
                </tbody>
            </table>

            @php
                $totalPages = $proyectosCerrados->lastPage();
                $currentPage = $proyectosCerrados->currentPage();
                $maxPagesToShow = 5; // Número máximo de enlaces de página a mostrar

                $startPage = max($currentPage - floor($maxPagesToShow / 2), 1);
                $endPage = min($startPage + $maxPagesToShow - 1, $totalPages);

                // Ajuste para cuando hay menos de 10 páginas a mostrar al principio o al final
                if ($endPage - $startPage + 1 < $maxPagesToShow) {
                    $startPage = max($endPage - $maxPagesToShow + 1, 1);
                }
            @endphp

            <div class="d-flex justify-content-center">
                <ul class="pagination">
                    @if ($startPage > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $proyectosCerrados->url(1) }}&tab=cerrados">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $proyectosCerrados->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $proyectosCerrados->url($i) }}&tab=cerrados">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ $proyectosCerrados->url($totalPages) }}&tab=cerrados">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

    </div>
</div>

@if (session('update_pres'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "success",
                title: @json(session('update_pres'))
            });
        });
    </script>
@endif

@if (session('success_visita_cerrar'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            const message = @json(session('success_visita_cerrar'));
            Toast.fire({
                icon: "success",
                title: message
            });
        });
    </script>
@endif


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtonsProyecto = document.querySelectorAll('.delete-btn-proyecto');

    deleteButtonsProyecto.forEach(button => {
        button.addEventListener('click', function() {
            const proyectoId = button.getAttribute('data-proyecto-id');
            const row = button.closest('tr'); // Encuentra la fila más cercana

            // Primero, muestra un mensaje sobre objetos relacionados
            Swal.fire({
                title: 'Advertencia',
                text: "Este proyecto tiene objetos relacionados que también serán eliminados. ¿Deseas continuar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si el usuario confirma, muestra el mensaje de confirmación para eliminar el proyecto
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "No podrás revertir esto.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Eliminar',
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('proyecto.destroy', ['id' => ':proyectoId']) }}'.replace(':proyectoId', proyectoId),
                                type: 'POST',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    _method: 'DELETE',
                                },
                                success: function(response) {
                                    if (response.success) {
                                        row.remove();
                                        const Toast = Swal.mixin({
                                            toast: true,
                                            position: "top-end",
                                            showConfirmButton: false,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            didOpen: (toast) => {
                                                toast.onmouseenter = Swal.stopTimer;
                                                toast.onmouseleave = Swal.resumeTimer;
                                            }
                                        });
                                        Toast.fire({
                                            icon: "success",
                                            title: response.message
                                        });
                                    } else {
                                        Swal.fire('Error', response.message || 'Hubo un problema al eliminar el proyecto.', 'error');
                                    }
                                },
                                error: function(xhr) {
                                    console.error('Error details:', xhr);
                                    Swal.fire('Error', 'Hubo un problema al eliminar el proyecto.', 'error');
                                }
                            });
                        }
                    });
                }
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const deleteButtonsPresupuesto = document.querySelectorAll('.delete-btn-presupuesto');

    deleteButtonsPresupuesto.forEach(button => {
        button.addEventListener('click', function() {
            const presupuestoId = button.getAttribute('data-presupuesto-id');
            const row = button.closest('tr'); // Encuentra la fila más cercana

            // Primero, muestra un mensaje sobre objetos relacionados
            Swal.fire({
                title: 'Advertencia',
                text: "Este presupuesto tiene objetos relacionados que también serán eliminados. ¿Deseas continuar?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'OK',
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Mensaje de confirmación para eliminar el presupuesto
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "No podrás revertir esto.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Eliminar',
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('presupuesto.destroy', ['id' => ':presupuestoId']) }}'.replace(':presupuestoId', presupuestoId),
                                type: 'POST',
                                data: {
                                    _token: $('meta[name="csrf-token"]').attr('content'),
                                    _method: 'DELETE',
                                },
                                success: function(response) {
                                    if (response.success) {
                                        row.remove();
                                        const Toast = Swal.mixin({
                                            toast: true,
                                            position: "top-end",
                                            showConfirmButton: false,
                                            timer: 3000,
                                            timerProgressBar: true,
                                            didOpen: (toast) => {
                                                toast.onmouseenter = Swal.stopTimer;
                                                toast.onmouseleave = Swal.resumeTimer;
                                            }
                                        });
                                        Toast.fire({
                                            icon: "success",
                                            title: response.message
                                        });
                                    } else {
                                        Swal.fire('Error', response.message || 'Hubo un problema al eliminar el presupuesto.', 'error');
                                    }
                                },
                                error: function(xhr) {
                                    console.error('Error details:', xhr);
                                    Swal.fire('Error', 'Hubo un problema al eliminar el presupuesto.', 'error');
                                }
                            });
                        }
                    });
                }
            });
        });
    });
});


document.addEventListener('DOMContentLoaded', function() {
    var clienteModal = document.getElementById('clienteProyectoModal');

    clienteModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;

        var establecido = button.getAttribute('data-establecido') == '1' ? 'Establecido' : 'No establecido';

        var clienteContent = `
            <div class="row mt-3 mx-3">
                <div class="col">
                    <p><strong>Nombre:</strong> ${button.getAttribute('data-nombre') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>Apellido:</strong> ${button.getAttribute('data-apellido') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>DNI:</strong> ${button.getAttribute('data-dni') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>Email:</strong> ${button.getAttribute('data-email') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>Número Móvil:</strong> ${button.getAttribute('data-movil') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>Contacto:</strong> ${button.getAttribute('data-contacto') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                </div>
                <div class="col">
                    <p><strong>Dirección:</strong> ${button.getAttribute('data-direccion') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>Código Postal:</strong> ${button.getAttribute('data-cp') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>Población:</strong> ${button.getAttribute('data-poblacion') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>Provincia:</strong> ${button.getAttribute('data-provincia') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>Fax:</strong> ${button.getAttribute('data-fax') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>Cargo:</strong> ${button.getAttribute('data-cargo') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                </div>
            </div>
            <div class="row mt-3 mx-3">
                <div class="col">
                    <p><strong>Titular Nombre:</strong> ${button.getAttribute('data-titular-nom') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>Titular Apellido:</strong> ${button.getAttribute('data-titular-ape') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>Dirección de Envío:</strong> ${button.getAttribute('data-direccion-envio') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                </div>
                <div class="col">
                    <p><strong>Código Postal de Envío:</strong> ${button.getAttribute('data-cp-envio') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>Población de Envío:</strong> ${button.getAttribute('data-poblacion-envio') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                    <p><strong>Provincia de Envío:</strong> ${button.getAttribute('data-provincia-envio') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                </div>
            </div>
            <div class="row mt-3 mx-3">
                <div class="col">
                    <p><strong>Forma de Pago:</strong> ${button.getAttribute('data-pago') || "<span class='badge px-4 fs-7 badge-light-warning'>No registrado</span>"}</p>
                </div>
                <div class="col">
                    <p><strong>Establecido:</strong> ${establecido}</p>
                </div>
            </div>
        `;

        var clienteContentDiv = clienteModal.querySelector('#clienteContent');
        clienteContentDiv.innerHTML = clienteContent;
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    $(document).on('click', '.cerrar-proyecto-btn', function(event) {
        event.preventDefault();

        var proyectoId = $(this).data('proyecto-id');
        console.log(proyectoId);
        $.ajax({
            url: '{{ route('proyecto.cerrar', ['id' => ':proyectoId']) }}'.replace(':proyectoId', proyectoId),
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                    Toast.fire({
                        icon: "success",
                        title: "Proyecto cerrado.",
                        timer: 3000
                    });
                } else {
                    Toast.fire({
                        icon: "error",
                        title: "No se pudo cerrar el proyecto.",
                        timer: 3000
                    });
                }
            },
            error: function(xhr, status, error) {
                Toast.fire({
                    icon: "error",
                    title: error,
                    timer: 3000
                });
            }
        });
    });

    $(document).on('click', '.aceptar-presupuesto-btn', function(event) {
        event.preventDefault();

        var presupuestoId = $(this).data('presupuesto-id');
        console.log(presupuestoId);
        $.ajax({
            url: '{{ route('presupuesto.aceptar', ['id' => ':presupuestoId']) }}'.replace(':presupuestoId', presupuestoId),
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                    Toast.fire({
                        icon: "success",
                        title: "Presupuesto aceptado.",
                        timer: 3000
                    });
                } else {
                    Toast.fire({
                        icon: "error",
                        title: "No se pudo aceptar el presupuesto.",
                        timer: 3000
                    });
                }
            },
            error: function(xhr, status, error) {
                Toast.fire({
                    icon: "error",
                    title: error,
                    timer: 3000
                });
            }
        });
    });

    $(document).on('click', '.enviar-presupuesto-btn', function(event) {
        event.preventDefault();

        var proyectoId = $(this).data('proyecto-id');

        $.ajax({
            url: '{{ route('proyecto.sendMail', ['id' => ':proyectoId']) }}'.replace(':proyectoId', proyectoId),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                Toast.fire({
                    icon: 'success',
                    title: 'PDF simple enviado.',
                    timer: 3000
                });
            },
            error: function(xhr, status, error) {
                Toast.fire({
                    icon: 'error',
                    title: 'Error',
                    timer: 3000
                });
            }
        });
    });

    $(document).on('click', '.enviar-proforma-btn', function(event) {
        event.preventDefault();

        var proyectoId = $(this).data('proyecto-id');

        $.ajax({
            url: '{{ route('proyecto.sendMailBudget', ['id' => ':proyectoId']) }}'.replace(':proyectoId', proyectoId),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                Toast.fire({
                    icon: 'success',
                    title: 'Proforma enviada.',
                    timer: 3000
                });
            },
            error: function(xhr, status, error) {
                Toast.fire({
                    icon: 'error',
                    title: 'Error',
                    timer: 3000
                });
            }
        });
    });

    $(document).on('click', '.facturar-presupuesto-btn', function(event) {
        event.preventDefault();

        var presupuestoId = $(this).data('presupuesto-id');

        $.ajax({
            url: '{{ route('presupuesto.facturar', ['id' => ':presupuestoId']) }}'.replace(':presupuestoId', presupuestoId),
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                Toast.fire({
                    icon: 'success',
                    title: 'Presupuesto facturado.',
                    timer: 3000
                });
            },
            error: function(xhr, status, error) {
                Toast.fire({
                    icon: 'error',
                    title: 'Error',
                    timer: 3000
                });
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-bs-target="#detallesProyectoModal"]').forEach(button => {
        button.addEventListener('click', function () {
            var proyectoId = this.getAttribute('data-proyecto-id');

            if (proyectoId) {
                fetch(`/proyecto/${proyectoId}/details`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Red no está disponible.');
                        }
                        return response.text();
                    })
                    .then(html => {
                        if (this.getAttribute('data-bs-target') === '#detallesProyectoModal') {
                            document.getElementById('modalBody').innerHTML = html;
                        }
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                console.error('ID de proyecto no válido o no proporcionado.');
            }
        });
    });
});

document.addEventListener('click', function(event) {
    const button = event.target.closest('[data-bs-target="#visitaModal"]');
    if (button) {
        const visitaModal = document.getElementById('visitaModal');
        const proyectoId = button.getAttribute('data-proyecto-id');
        const serieRef = button.getAttribute('data-serie-ref');
        const contacto = button.getAttribute('data-contacto');

        const modalTitle = visitaModal.querySelector('.modal-title strong');
        const proyectoInput = visitaModal.querySelector('input[name="proyecto_id"]');
        const contactoInput = visitaModal.querySelector('input[name="contacto_visita"]');

        modalTitle.textContent = `${proyectoId} - ${serieRef}`;
        proyectoInput.value = proyectoId;
        contactoInput.value = contacto;
    }
});

/*
EDITAR
document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'editProyectoForm') {
            e.preventDefault();

            const formData = new FormData(e.target);
            fetch(e.target.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-Token': formData.get('_token')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Proyecto actualizado correctamente');
                    window.location.href = "{{ route('proyecto.index') }}";
                } else {
                    alert('Error al actualizar el proyecto. Por favor, inténtalo de nuevo.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error. Por favor, inténtalo de nuevo.');
            });
        }
    });
});
*/

</script>
@endpush
@include('partials.modals._asignar-visita')
@if (!isset($proyectos) || empty($proyectos))
    @include('partials/modals/_proyecto-editar')
    @include('partials/modals/_detalles-proyecto')
    @include('partials/modals/_cliente-proyecto')
@endif
</x-default-layout>
