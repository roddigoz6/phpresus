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
    </ul>

    <div class="tab-content mt-3" id="visitaTabsContent">

        <!-- Todos las visitas -->
        <div class="tab-pane fade {{ $tab == 'all' ? 'show active' : '' }}" id="all" role="tabpanel"
            aria-labelledby="all-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Proyecto a visitar</th>
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

                            @switch($visita->prioridad)
                                    @case('Baja')
                                    <tr class="text-center">
                                        <td class="align-middle">
                                            <button class="btn btn-light-success"
                                                data-presupuesto-id="{{ $visita->proyecto_id }}" data-bs-toggle="popover"
                                                title="Ver detalle de presupuesto">
                                                {{ $visita->proyecto_id }}, {{$visita->proyecto->serie_ref ?? 'No registrado.'}}
                                            </button>
                                        </td>
                                        <td class="align-middle">{{ $visita->fecha_inicio }} a las {{ $visita->hora_inicio }}</td>
                                        <td class="align-middle">{{ $visita->fecha_fin }} a las {{ $visita->hora_fin }}</td>
                                        <td class="align-middle">{{ $visita->contacto_visita }}</td>
                                        <td class="align-middle">
                                            <form id="delete-form-{{ $visita->id }}" action="{{ route('visita.destroy', $visita->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-light-danger delete-btn" data-visita-id="{{ $visita->id }}" data-bs-toggle="popover" title="Eliminar visita">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>


                                    </tr>
                                        @break

                                    @case('Media')
                                    <tr class="text-center">
                                        <td class="align-middle">
                                            <button class="btn btn-light-warning"
                                                data-presupuesto-id="{{ $visita->proyecto_id }}" data-bs-toggle="popover"
                                                title="Ver detalle de presupuesto">
                                                {{ $visita->proyecto_id }}, {{$visita->proyecto->serie_ref ?? 'No registrado.'}}
                                            </button>
                                        </td>
                                        <td class="align-middle">{{ $visita->fecha_inicio }} a las {{ $visita->hora_inicio }}</td>
                                        <td class="align-middle">{{ $visita->fecha_fin }} a las {{ $visita->hora_fin }}</td>
                                        <td class="align-middle">{{ $visita->contacto_visita }}</td>
                                        <td class="align-middle">
                                            <form id="delete-form-{{ $visita->id }}" action="{{ route('visita.destroy', $visita->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-light-danger delete-btn" data-visita-id="{{ $visita->id }}" data-bs-toggle="popover" title="Eliminar visita">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>


                                    </tr>
                                        @break

                                    @case('Alta')
                                    <tr class="text-center">
                                        <td class="align-middle">
                                            <button class="btn btn-light-danger"
                                                data-presupuesto-id="{{ $visita->proyecto_id }}" data-bs-toggle="popover"
                                                title="Ver detalle de presupuesto">
                                                {{ $visita->proyecto_id }}, {{$visita->proyecto->serie_ref ?? 'No registrado.'}}
                                            </button>
                                        </td>
                                        <td class="align-middle">{{ $visita->fecha_inicio }} a las {{ $visita->hora_inicio }}</td>
                                        <td class="align-middle">{{ $visita->fecha_fin }} a las {{ $visita->hora_fin }}</td>
                                        <td class="align-middle">{{ $visita->contacto_visita }}</td>
                                        <td class="align-middle">
                                            <form id="delete-form-{{ $visita->id }}" action="{{ route('visita.destroy', $visita->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-light-danger delete-btn" data-visita-id="{{ $visita->id }}" data-bs-toggle="popover" title="Eliminar visita">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>


                                    </tr>
                                        @break

                                    @default
                                        <td class="align-middle">
                                            <button class="btn btn-light-danger">
                                                Estado desconocido
                                            </button>
                                        </td>
                                @endswitch
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

        <!-- Baja prioridad -->
        <div <div class="tab-pane fade {{ $tab == 'baja' ? 'show active' : '' }}" id="baja"
            role="tabpanel" aria-labelledby="baja-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Proyecto a visitar</th>
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
                    @foreach ($visitasBaja as $visita)
                    <tr class="text-center bg-success">
                        <td class="align-middle">
                            <button class="btn btn-light-success"
                                data-presupuesto-id="{{ $visita->proyecto_id }}" data-bs-toggle="popover"
                                title="Ver detalle de presupuesto">
                                {{ $visita->proyecto_id }}, {{$visita->proyecto->serie_ref ?? 'No registrado.'}}
                            </button>
                        </td>
                        <td class="align-middle">{{ $visita->fecha_inicio }} a las {{ $visita->hora_inicio }}</td>
                        <td class="align-middle">{{ $visita->fecha_fin }} a las {{ $visita->hora_fin }}</td>
                        <td class="align-middle">{{ $visita->contacto_visita }}</td>
                        <td class="align-middle">
                            <form id="delete-form-{{ $visita->id }}" action="{{ route('visita.destroy', $visita->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-light-danger delete-btn" data-visita-id="{{ $visita->id }}" data-bs-toggle="popover" title="Eliminar visita">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
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
                            <a class="page-link" href="{{ $visitasBaja->url(1) }}&tab=all">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $visitasBaja->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $visitasBaja->url($i) }}&tab=all">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ $visitasBaja->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>

        <!-- Prioridad media -->
        <div <div class="tab-pane fade {{ $tab == 'media' ? 'show active' : '' }}" id="media"
            role="tabpanel" aria-labelledby="media-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Proyecto a visitar</th>
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
                    @foreach ($visitasMedia as $visita)
                    <tr class="text-center bg-success">
                        <td class="align-middle">
                            <button class="btn btn-light-warning"
                                data-presupuesto-id="{{ $visita->proyecto_id }}" data-bs-toggle="popover"
                                title="Ver detalle de presupuesto">
                                {{ $visita->proyecto_id }}, {{$visita->proyecto->serie_ref ?? 'No registrado.'}}
                            </button>
                        </td>
                        <td class="align-middle">{{ $visita->fecha_inicio }} a las {{ $visita->hora_inicio }}</td>
                        <td class="align-middle">{{ $visita->fecha_fin }} a las {{ $visita->hora_fin }}</td>
                        <td class="align-middle">{{ $visita->contacto_visita }}</td>
                        <td class="align-middle">
                            <form id="delete-form-{{ $visita->id }}" action="{{ route('visita.destroy', $visita->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-light-danger delete-btn" data-visita-id="{{ $visita->id }}" data-bs-toggle="popover" title="Eliminar visita">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
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
                            <a class="page-link" href="{{ $visitasMedia->url(1) }}&tab=all">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ $visitasMedia->currentPage() == $i ? 'active' : '' }}">
                            <a class="page-link"
                                href="{{ $visitasMedia->url($i) }}&tab=all">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link"
                                href="{{ $visitasMedia->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Prioridad alta -->
        <div class="tab-pane fade {{ $tab == 'alta' ? 'show active' : '' }}" id="alta"
        role="tabpanel" aria-labelledby="alta-tab">
        <table class="table table-light text-center table-hover rounded-table">
            <thead class="table-dark">
                <tr class="align-middle">
                    <th class="icon-table">Proyecto a visitar</th>
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
                @foreach ($visitasAlta as $visita)
                <tr class="text-center">
                    <td class="align-middle">
                        <button class="btn btn-light-danger"
                            data-presupuesto-id="{{ $visita->proyecto_id }}" data-bs-toggle="popover"
                            title="Ver detalle de presupuesto">
                            {{ $visita->proyecto_id }}, {{$visita->proyecto->serie_ref ?? 'No registrado.'}}
                        </button>
                    </td>
                    <td class="align-middle">{{ $visita->fecha_inicio }} a las {{ $visita->hora_inicio }}</td>
                    <td class="align-middle">{{ $visita->fecha_fin }} a las {{ $visita->hora_fin }}</td>
                    <td class="align-middle">{{ $visita->contacto_visita }}</td>
                    <td class="align-middle">
                        <form id="delete-form-{{ $visita->id }}" action="{{ route('visita.destroy', $visita->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-light-danger delete-btn" data-visita-id="{{ $visita->id }}" data-bs-toggle="popover" title="Eliminar visita">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
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
                        <a class="page-link" href="{{ $visitasAlta->url(1) }}&tab=all">1</a>
                    </li>
                    @if ($startPage > 2)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                @endif

                @for ($i = $startPage; $i <= $endPage; $i++)
                    <li class="page-item {{ $visitasAlta->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link"
                            href="{{ $visitasAlta->url($i) }}&tab=all">{{ $i }}</a>
                    </li>
                @endfor

                @if ($endPage < $totalPages)
                    @if ($endPage < $totalPages - 1)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                    <li class="page-item">
                        <a class="page-link"
                            href="{{ $visitasAlta->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                    </li>
                @endif
            </ul>
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
</script>
@endpush
</x-default-layout>
