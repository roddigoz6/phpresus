<x-default-layout>
@section('title')
    Visitas
@endsection
<div class="container">
    <div class="row my-3 align-items-center">
        <div class="col text-start">
            <h2>Visitas</h2>
        </div>
    </div>

    <form action="{{ route('proyecto.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Buscar por nombre de cliente">
            <button class="btn btn-light-primary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <!-- Pestañas de navegación -->
    <ul class="nav nav-tabs" id="visitaTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"
                aria-controls="all" aria-selected="true">Todas</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="alta-tab" data-bs-toggle="tab" href="#alta" role="tab"
                aria-controls="alta" aria-selected="false">En prioridad alta
                <i class="fa fa-star text-warning"></i>
                <i class="fa fa-star text-warning"></i>
                <i class="fa fa-star text-warning"></i>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="media-tab" data-bs-toggle="tab" href="#media" role="tab"
                aria-controls="media" aria-selected="false">En prioridad media
                <i class="fa fa-star text-warning"></i>
                <i class="fa fa-star text-warning"></i>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="baja-tab" data-bs-toggle="tab" href="#baja" role="tab"
                aria-controls="baja" aria-selected="false">En prioridad baja
                <i class="fa fa-star text-warning"></i>
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="historial-tab" data-bs-toggle="tab" href="#historial" role="tab"
                aria-controls="historial" aria-selected="false">Historial de visitas
            </a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="visitaTabsContent">

        <!-- Todos las visitas -->
        <div class="tab-pane fade {{ $tab == 'all' ? 'show active' : '' }}" id="all" role="tabpanel"
            aria-labelledby="all-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Proyecto a visitar</th>
                        <th class="icon-table">Motivo y Cliente</th>
                        <th class="icon-table">Fecha de visita</th>
                        <th class="icon-table">Fin de visita</th>
                        <th class="icon-table">Contacto</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($visitas->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">No hay visitas pendientes.</td>
                        </tr>
                    @else
                        @foreach ($visitas as $visita)
                            @php
                                $fechaVisita = \Carbon\Carbon::parse($visita->fecha_inicio);
                                $dentroDeTresDias = $fechaVisita->between($today, $threeDaysFromNow);
                            @endphp
                            <tr class="text-center {{ $dentroDeTresDias ? 'highlight' : '' }}">
                                <!-- Contenido de la fila para la visita general -->
                                <td class="align-middle">
                                    <button class="btn btn-light-{{ $visita->prioridad == 'Alta' ? 'danger' : ($visita->prioridad == 'Media' ? 'warning' : 'success') }}"
                                        data-presupuesto-id="{{ $visita->proyecto_id }}"
                                        data-bs-toggle="popover"
                                        data-bs-trigger="hover"
                                        title="Móvil: {{ $visita->proyecto->cliente->movil }}&#10;Dirección: {{ $visita->proyecto->cliente->direccion }}&#10;Provincia: {{ $visita->proyecto->cliente->provincia }}">
                                        {{ $visita->proyecto_id }}, {{ $visita->proyecto->serie_ref ?? 'No registrado.' }}
                                    </button>
                                </td>
                                <td class="align-middle">{{ $visita->descripcion }} {{ $visita->proyecto->cliente->nombre }} {{ $visita->proyecto->cliente->apellido }}</td>
                                <td class="align-middle">{{ $visita->fecha_inicio }} a las {{ $visita->hora_inicio }}</td>

                                @if ($visita->fecha_fin == null && $visita->hora_fin == null)
                                    <td class="align-middle">Fecha de fin no registrada.</td>
                                @else
                                    <td class="align-middle">{{ $visita->fecha_fin }} a las {{ $visita->hora_fin }}</td>
                                @endif

                                <td class="align-middle">{{ $visita->contacto_visita }}</td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-sm btn-icon btn-light-primary me-n3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end"><i class="fa-solid fa-bars"></i></button>
                                    @include('partials/menus/_acciones_visita', ['visita' => $visita])
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>


            </table>

            @php
                $totalPages = $visitas->lastPage();
                $currentPage = $visitas->currentPage();
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
                            <a class="page-link" href="{{ $visitas->url(1) }}&tab=all">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $visitas->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $visitas->url($i) }}&tab=all">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ $visitas->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Prioridad alta -->
        <div class="tab-pane fade {{ $tab == 'alta' ? 'show active' : '' }}" id="alta" role="tabpanel"
            aria-labelledby="alta-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Proyecto a visitar</th>
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">Fecha de visita</th>
                        <th class="icon-table">Fin de visita</th>
                        <th class="icon-table">Contacto</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($visitasAlta->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">No hay visitas en alta prioridad.</td>
                        </tr>
                    @else
                        @foreach ($visitasAlta as $visita)
                            @php
                                $fechaVisita = \Carbon\Carbon::parse($visita->fecha_inicio);
                                $dentroDeTresDias = $fechaVisita->between($today, $threeDaysFromNow);
                            @endphp
                            <tr class="text-center {{ $dentroDeTresDias ? 'highlight' : '' }}">
                                <!-- Contenido de la fila para la visita general -->
                                <td class="align-middle">
                                    <button class="btn btn-light-danger"
                                        data-presupuesto-id="{{ $visita->proyecto_id }}"
                                        data-bs-toggle="popover"
                                        data-bs-trigger="hover"
                                        title="Móvil: {{ $visita->proyecto->cliente->movil }}&#10;Dirección: {{ $visita->proyecto->cliente->direccion }}&#10;Provincia: {{ $visita->proyecto->cliente->provincia }}">
                                        {{ $visita->proyecto_id }}, {{ $visita->proyecto->serie_ref ?? 'No registrado.' }}
                                    </button>
                                </td>
                                <td class="align-middle">{{ $visita->proyecto->cliente->nombre }} {{ $visita->proyecto->cliente->apellido }}</td>
                                <td class="align-middle">{{ $visita->fecha_inicio }} a las {{ $visita->hora_inicio }}</td>

                                @if ($visita->fecha_fin == null && $visita->hora_fin == null)
                                    <td class="align-middle">Fecha de fin no registrada.</td>
                                @else
                                    <td class="align-middle">{{ $visita->fecha_fin }} a las {{ $visita->hora_fin }}</td>
                                @endif

                                <td class="align-middle">{{ $visita->contacto_visita }}</td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-sm btn-icon btn-light-primary me-n3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end"><i class="fa-solid fa-bars"></i></button>
                                    @include('partials/menus/_acciones_visita', ['visita' => $visita])
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>

            </table>

            @php
                $totalPages = $visitasAlta->lastPage();
                $currentPage = $visitasAlta->currentPage();
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
                            <a class="page-link" href="{{ $visitasAlta->url(1) }}&tab=alta">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $visitasAlta->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $visitasAlta->url($i) }}&tab=alta">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ $visitasAlta->url($totalPages) }}&tab=alta">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Prioridad media -->
        <div class="tab-pane fade {{ $tab == 'media' ? 'show active' : '' }}" id="media" role="tabpanel"
            aria-labelledby="media-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Proyecto a visitar</th>
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">Fecha de visita</th>
                        <th class="icon-table">Fin de visita</th>
                        <th class="icon-table">Contacto</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($visitasMedia->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">No hay visitas en media prioridad.</td>
                        </tr>
                    @else
                        @foreach ($visitasMedia as $visita)
                            @php
                                $fechaVisita = \Carbon\Carbon::parse($visita->fecha_inicio);
                                $dentroDeTresDias = $fechaVisita->between($today, $threeDaysFromNow);
                            @endphp
                            <tr class="text-center {{ $dentroDeTresDias ? 'highlight' : '' }}">
                                <!-- Contenido de la fila para la visita general -->
                                <td class="align-middle">
                                    <button class="btn btn-light-warning"
                                        data-presupuesto-id="{{ $visita->proyecto_id }}"
                                        data-bs-toggle="popover"
                                        data-bs-trigger="hover"
                                        title="Móvil: {{ $visita->proyecto->cliente->movil }}&#10;Dirección: {{ $visita->proyecto->cliente->direccion }}&#10;Provincia: {{ $visita->proyecto->cliente->provincia }}">
                                        {{ $visita->proyecto_id }}, {{ $visita->proyecto->serie_ref ?? 'No registrado.' }}
                                    </button>
                                </td>
                                <td class="align-middle">{{ $visita->proyecto->cliente->nombre }} {{ $visita->proyecto->cliente->apellido }}</td>
                                <td class="align-middle">{{ $visita->fecha_inicio }} a las {{ $visita->hora_inicio }}</td>

                                @if ($visita->fecha_fin == null && $visita->hora_fin == null)
                                    <td class="align-middle">Fecha de fin no registrada.</td>
                                @else
                                    <td class="align-middle">{{ $visita->fecha_fin }} a las {{ $visita->hora_fin }}</td>
                                @endif

                                <td class="align-middle">{{ $visita->contacto_visita }}</td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-sm btn-icon btn-light-primary me-n3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end"><i class="fa-solid fa-bars"></i></button>
                                    @include('partials/menus/_acciones_visita', ['visita' => $visita])
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>

            </table>

            @php
                $totalPages = $visitasMedia->lastPage();
                $currentPage = $visitasMedia->currentPage();
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
                            <a class="page-link" href="{{ $visitasMedia->url(1) }}&tab=media">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $visitasMedia->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $visitasMedia->url($i) }}&tab=media">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ $visitasMedia->url($totalPages) }}&tab=media">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Prioridad baja -->
        <div class="tab-pane fade {{ $tab == 'baja' ? 'show active' : '' }}" id="baja" role="tabpanel"
            aria-labelledby="baja-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Proyecto a visitar</th>
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">Fecha de visita</th>
                        <th class="icon-table">Fin de visita</th>
                        <th class="icon-table">Contacto</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($visitasBaja->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">No hay visitas en baja prioridad.</td>
                        </tr>
                    @else
                        @foreach ($visitasBaja as $visita)
                            @php
                                $fechaVisita = \Carbon\Carbon::parse($visita->fecha_inicio);
                                $dentroDeTresDias = $fechaVisita->between($today, $threeDaysFromNow);
                            @endphp
                            <tr class="text-center {{ $dentroDeTresDias ? 'highlight' : '' }}">
                                <!-- Contenido de la fila para la visita general -->
                                <td class="align-middle">
                                    <button class="btn btn-light-success"
                                        data-presupuesto-id="{{ $visita->proyecto_id }}"
                                        data-bs-toggle="popover"
                                        data-bs-trigger="hover"
                                        title="Móvil: {{ $visita->proyecto->cliente->movil }}&#10;Dirección: {{ $visita->proyecto->cliente->direccion }}&#10;Provincia: {{ $visita->proyecto->cliente->provincia }}">
                                        {{ $visita->proyecto_id }}, {{ $visita->proyecto->serie_ref ?? 'No registrado.' }}
                                    </button>
                                </td>
                                <td class="align-middle">{{ $visita->proyecto->cliente->nombre }} {{ $visita->proyecto->cliente->apellido }}</td>
                                <td class="align-middle">{{ $visita->fecha_inicio }} a las {{ $visita->hora_inicio }}</td>

                                @if ($visita->fecha_fin == null && $visita->hora_fin == null)
                                    <td class="align-middle">Fecha de fin no registrada.</td>
                                @else
                                    <td class="align-middle">{{ $visita->fecha_fin }} a las {{ $visita->hora_fin }}</td>
                                @endif

                                <td class="align-middle">{{ $visita->contacto_visita }}</td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-sm btn-icon btn-light-primary me-n3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end"><i class="fa-solid fa-bars"></i></button>
                                    @include('partials/menus/_acciones_visita', ['visita' => $visita])
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>

            </table>

            @php
                $totalPages = $visitasBaja->lastPage();
                $currentPage = $visitasBaja->currentPage();
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
                            <a class="page-link" href="{{ $visitasBaja->url(1) }}&tab=baja">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $visitasBaja->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $visitasBaja->url($i) }}&tab=baja">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ $visitasBaja->url($totalPages) }}&tab=baja">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Historial -->
        <div class="tab-pane fade {{ $tab == 'historial' ? 'show active' : '' }}" id="historial" role="tabpanel"
            aria-labelledby="historial-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Proyecto a visitar</th>
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">Fecha de visita</th>
                        <th class="icon-table">Fin de visita</th>
                        <th class="icon-table">Contacto</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($visitasAntiguas->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">Historial de visitas vacío.</td>
                        </tr>
                    @else
                        @foreach ($visitasAntiguas as $visita)
                            @php
                                $fechaVisita = \Carbon\Carbon::parse($visita->fecha_inicio);
                                $dentroDeTresDias = $fechaVisita->between($today, $threeDaysFromNow);
                            @endphp
                            <tr class="text-center {{ $dentroDeTresDias ? 'highlight' : '' }}">
                                <!-- Contenido de la fila para la visita general -->
                                <td class="align-middle">
                                    <button class="btn btn-light-secondary"
                                        data-presupuesto-id="{{ $visita->proyecto_id }}"
                                        data-bs-toggle="popover"
                                        data-bs-trigger="hover"
                                        title="Móvil: {{ $visita->proyecto->cliente->movil }}&#10;Dirección: {{ $visita->proyecto->cliente->direccion }}&#10;Provincia: {{ $visita->proyecto->cliente->provincia }}">
                                        {{ $visita->proyecto_id }}, {{ $visita->proyecto->serie_ref ?? 'No registrado.' }}
                                    </button>
                                </td>
                                <td class="align-middle">{{ $visita->proyecto->cliente->nombre }} {{ $visita->proyecto->cliente->apellido }}</td>
                                <td class="align-middle">{{ $visita->fecha_inicio }} a las {{ $visita->hora_inicio }}</td>

                                @if ($visita->fecha_fin == null && $visita->hora_fin == null)
                                    <td class="align-middle">Fecha de fin no registrada.</td>
                                @else
                                    <td class="align-middle">{{ $visita->fecha_fin }} a las {{ $visita->hora_fin }}</td>
                                @endif

                                <td class="align-middle">{{ $visita->contacto_visita }}</td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-sm btn-icon btn-light-primary me-n3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end"><i class="fa-solid fa-bars"></i></button>
                                    @include('partials/menus/_acciones_visita', ['visita' => $visita])
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>

            </table>

            @php
                $totalPages = $visitasAntiguas->lastPage();
                $currentPage = $visitasAntiguas->currentPage();
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
                            <a class="page-link" href="{{ $visitasAntiguas->url(1) }}&tab=historial">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $visitasAntiguas->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $visitasAntiguas->url($i) }}&tab=historial">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ $visitasAntiguas->url($totalPages) }}&tab=historial">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

    </div>
</div>

@if (session('success_vis'))
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
                title: "{{ session('success_vis') }}"
            });
        });
    </script>
@endif

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const currentTab = urlParams.get('tab');

    if (currentTab) {
        const tabElement = document.querySelector(`#${currentTab}_tab`);
        const tab = new bootstrap.Tab(tabElement);
        tab.show();
    }
});

document.addEventListener("DOMContentLoaded", function() {
    let rowsToHighlight = document.querySelectorAll('tr.highlight');

    rowsToHighlight.forEach(row => {
        let btn = row.querySelector('button.btn-light-danger, button.btn-light-warning, button.btn-light-success');

        if (btn) {
            btn.innerHTML += ` <i class="fa-solid fa-exclamation fa-beat"></i>`;
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const visitaId = button.getAttribute('data-visita-id');
            const row = button.closest('tr'); // Encuentra la fila más cercana

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
                        url: document.getElementById(`delete-form-${visitaId}`).action,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            _method: 'DELETE',
                        },
                        success: function(response) {
                            if (response.success) {
                                row.remove()
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
                                }).then(() => {
                                });
                            } else {
                                Swal.fire('Error', response.message || 'Hubo un problema al eliminar la visita.', 'error');
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            Swal.fire('Error', 'Hubo un problema al eliminar la visita.', 'error');
                        }
                    });
                }
            });
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var deleteButtons = document.querySelectorAll('.cerrar-btn');

    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var visitaId = this.getAttribute('data-visita-id');
            var visitaDescripcion = this.getAttribute('data-visita-descripcion');
            var proyectoId = this.getAttribute('data-proyecto-id');

            // Actualiza el contenido dinámico del modal con la información de la visita
            var form = document.getElementById('visitaCerrarForm');
            var formAction = form.getAttribute('action').replace(':id', visitaId);
            form.setAttribute('action', formAction);

            // Establece el ID de la visita en el input oculto
            document.getElementById('visita-id-input').value = visitaId;

            // Actualiza el título del modal con el ID de la visita y el proyecto
            document.querySelector('#visitaCerrarModalLabel strong').textContent = `#${visitaId} del proyecto ${proyectoId}`;

            // Actualiza la descripción de la visita en el modal
            document.getElementById('visitaDescripcion').textContent = visitaDescripcion;

            // Mostrar el modal
            var modalElement = document.getElementById('visitaCerrarModal');
            var modal = new bootstrap.Modal(modalElement);
            modal.show();
        });
    });
});

</script>
@endpush
@include('partials/modals/_nota-cerrar')
</x-default-layout>
