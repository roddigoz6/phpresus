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
            <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"
                aria-controls="all" aria-selected="true">Todos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="presupuestos-tab" data-bs-toggle="tab" href="#presupuestos" role="tab"
                aria-controls="presupuestos" aria-selected="false">Prespuestados</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="visita-tab" data-bs-toggle="tab" href="#visita" role="tab"
                aria-controls="visita" aria-selected="false">Visita Asignada</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="realizado-tab" data-bs-toggle="tab" href="#realizado" role="tab"
                aria-controls="realizado" aria-selected="false">Realizando</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="finalizado-tab" data-bs-toggle="tab" href="#finalizado" role="tab"
                aria-controls="finalizado" aria-selected="false">Finalizados</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="cobrado-tab" data-bs-toggle="tab" href="#cobrado" role="tab"
                aria-controls="cobrado" aria-selected="false">Cobrados</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="cerrado-tab" data-bs-toggle="tab" href="#cerrado" role="tab"
                aria-controls="cerrado" aria-selected="false">Cerrados</a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="proyectoTabsContent">

        <!-- Todos los proyectos -->
        <div class="tab-pane fade {{ $tab == 'all' ? 'show active' : '' }}" id="all" role="tabpanel"
            aria-labelledby="all-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Id</th>
                        <th class="icon-table">Serie de referencia</th>
                        <th class="icon-table">Número de referencia</th>
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">Estado de proyecto</th>
                        <th class="icon-table">Precio total</th>
                        <th class="icon-table">Forma de pago</th>
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
                                <td class="align-middle">
                                    <button class="btn btn-light-info"
                                        data-presupuesto-id="{{ $proyecto->proyecto_id }}" data-bs-toggle="popover"
                                        title="Ver detalle de presupuesto">
                                        {{ $proyecto->proyecto_id }}
                                    </button>
                                </td>
                                <td class="align-middle">{{ $proyecto->serie_ref ?? 'No registrado'}}</td>
                                <td class="align-middle">{{ $proyecto->num_ref ?? 'No registrado' }}</td>
                                <td class="align-middle">{{ $proyecto->cliente->nombre }} {{ $proyecto->cliente->apellido }}</td>

                                @switch($proyecto->estado)
                                    @case('Presupuestado')
                                        <td class="align-middle">
                                            <button class="btn btn-light-info">
                                                {{ $proyecto->estado }}
                                            </button>
                                        </td>
                                        @break

                                    @case('Visita')
                                        <td class="align-middle">
                                            <button class="btn btn-light-warning">
                                                {{ $proyecto->estado }}
                                            </button>
                                        </td>
                                        @break

                                    @case('Realizado')
                                        <td class="align-middle">
                                            <button class="btn btn-light-primary">
                                                {{ $proyecto->estado }}
                                            </button>
                                        </td>
                                        @break

                                    @case('Finalizado')
                                        <td class="align-middle">
                                            <button class="btn btn-light-secondary">
                                                {{ $proyecto->estado }}
                                            </button>
                                        </td>
                                        @break

                                    @case('Cobrado')
                                        <td class="align-middle">
                                            <button class="btn btn-light-success">
                                                {{ $proyecto->estado }}
                                            </button>
                                        </td>
                                        @break

                                    @case('Cerrado')
                                        <td class="align-middle">
                                            <button class="btn btn-light-dark">
                                                {{ $proyecto->estado }}
                                            </button>
                                        </td>
                                        @break

                                    @default
                                        <td class="align-middle">
                                            <button class="btn btn-light-danger">
                                                Estado desconocido
                                            </button>
                                        </td>
                                @endswitch

                                <td class="align-middle">{{ $proyecto->presupuesto->precio_total }}</td>
                                <td class="align-middle">{{ $proyecto->pago }}</td>
                                <td class="align-middle">{{ $proyecto->created_at->format('d/m/Y H:i') }}</td>

                                <td class="align-middle">
                                    <div class="card-toolbar">
                                        <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n3" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-end">{!! getIcon('setting-3', 'fs-2') !!}</button>
                                        @include('partials/menus/_acciones_proyecto')
                                    </div>
                                </td>
                            </tr>
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

        <!-- Proyectos presupuestados -->
        <div <div class="tab-pane fade {{ $tab == 'presupuestos' ? 'show active' : '' }}" id="presupuestos"
            role="tabpanel" aria-labelledby="presupuestos-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Id</th>
                        <th class="icon-table">Serie de referencia</th>
                        <th class="icon-table">Número de referencia</th>
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">Precio total</th>
                        <th class="icon-table">Forma de pago</th>
                        <th class="icon-table">Fecha de creación</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($proyectos->where('estado', 'Presupuestado')->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center">No hay proyectos en estado de presupuestado.</td>
                        </tr>
                    @else
                        @foreach ($proyectos->where('estado', 'Presupuestado') as $proyecto)
                            <tr>
                                <td class="align-middle">
                                    <button class="btn btn-light-info"
                                        data-presupuesto-id="{{ $proyecto->proyecto_id }}" data-bs-toggle="popover"
                                        title="Ver detalle de presupuesto">
                                        {{ $proyecto->proyecto_id }}
                                    </button>
                                </td>
                                <td class="align-middle">{{ $proyecto->serie_ref ?? 'No registrado' }}</td>
                                <td class="align-middle">{{ $proyecto->num_ref ?? 'No registrado' }}</td>
                                <td class="align-middle">{{ $proyecto->cliente->nombre }} {{ $proyecto->cliente->apellido }}</td>
                                <td class="align-middle">{{ $proyecto->presupuesto->precio_total }}</td>
                                <td class="align-middle">{{ $proyecto->pago }}</td>
                                <td class="align-middle">{{ $proyecto->created_at->format('d/m/Y H:i') }}</td>

                                <td class="align-middle">

                                    <a href="{{ route('presupuesto.edit', $proyecto->presupuesto->id) }}"
                                        class="btn btn-light-primary" data-bs-toggle="popover"
                                        title="Editar presupuesto"><i class="fa-solid fa-pen-to-square"></i></a>

                                    <a href="" class="btn btn-light-success"
                                        data-presupuesto-id="{{ $proyecto->proyecto_id }}" data-bs-toggle="popover"
                                        title="Generar factura"><i class="fa-solid fa-receipt"></i>
                                    </a>

                                    <a href="{{ route('visita.store') }}" class="btn btn-light-warning"
                                        data-presupuesto-id="{{ $proyecto->proyecto_id }}" data-bs-toggle="popover"
                                        title="Generar visita"><i class="fa-solid fa-calendar-check"></i>
                                    </a>

                                </td>

                            </tr>
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

        <!-- Visitas asignadas -->
        <div <div class="tab-pane fade {{ $tab == 'visita' ? 'show active' : '' }}" id="visita"
            role="tabpanel" aria-labelledby="visita-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Id</th>
                        <th class="icon-table">Serie de referencia</th>
                        <th class="icon-table">Número de referencia</th>
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">Precio total</th>
                        <th class="icon-table">Forma de pago</th>
                        <th class="icon-table">Fecha de creación</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($proyectos->where('estado', 'Visita')->isEmpty())
                        <tr>
                            <td colspan="8" class="text-center">No hay proyectos en estado de presupuestado.</td>
                        </tr>
                    @else
                        @foreach ($proyectos->where('estado', 'Presupuestado') as $proyecto)
                            <tr>
                                <td class="align-middle">
                                    <button class="btn btn-light-info"
                                        data-presupuesto-id="{{ $proyecto->proyecto_id }}" data-bs-toggle="popover"
                                        title="Ver detalle de presupuesto">
                                        {{ $proyecto->proyecto_id }}
                                    </button>
                                </td>
                                <td class="align-middle">{{ $proyecto->serie_ref }}</td>
                                <td class="align-middle">{{ $proyecto->num_ref }}</td>
                                <td class="align-middle">{{ $proyecto->cliente->nombre }} {{ $proyecto->cliente->apellido }}</td>
                                <td class="align-middle">{{ $proyecto->created_at->format('d/m/Y H:i') }}</td>

                                <td class="align-middle">

                                    <a href="{{ route('presupuesto.edit', $proyecto->presupuesto->id) }}"
                                        class="btn btn-light-primary" data-bs-toggle="popover"
                                        title="Editar presupuesto"><i class="fa-solid fa-pen-to-square"></i></a>

                                    <a href="" class="btn btn-light-success"
                                        data-presupuesto-id="{{ $proyecto->proyecto_id }}" data-bs-toggle="popover"
                                        title="Generar factura"><i class="fa-solid fa-receipt"></i>
                                    </a>

                                    <a href="{{ route('visita.store') }}" class="btn btn-light-warning"
                                        data-presupuesto-id="{{ $proyecto->proyecto_id }}" data-bs-toggle="popover"
                                        title="Generar visita"><i class="fa-solid fa-calendar-check"></i>
                                    </a>

                                </td>

                            </tr>
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

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-btn');

    deleteButtons.forEach(button => {
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
                                url: `/proyecto/${encodeURIComponent(proyectoId)}`, // Asegúrate de codificar el ID
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
                                    console.error(xhr.responseText);
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


</script>
@endpush
</x-default-layout>
