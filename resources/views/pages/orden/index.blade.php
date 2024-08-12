<x-default-layout>

<div class="container">
    <div class="row my-3 align-items-center">
        <div class="col text-start">
            <h2>Ordenes</h2>
        </div>
    </div>

    <form action="{{ route('orden.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Buscar por nombre de cliente">
            <button class="btn btn-primary" type="submit">Buscar</button>
        </div>
    </form>

    <!-- Pestañas de navegación -->
    <ul class="nav nav-tabs" id="ordenTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">Todos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="non-charged-tab" data-bs-toggle="tab" href="#non-charged" role="tab" aria-controls="non-charged" aria-selected="false">No Cobrados</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="charged-tab" data-bs-toggle="tab" href="#charged" role="tab" aria-controls="charged" aria-selected="false">Cobrados</a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="ordenTabsContent">
        <!-- Todas los ordenes -->
        <div class="tab-pane fade {{ $tab == 'all' ? 'show active' : '' }}" id="all" role="tabpanel" aria-labelledby="all-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Orden</th>
                        <th class="icon-table">Presupuesto</th>
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">DNI Cliente</th>
                        <th class="icon-table">Precio total</th>
                        <th class="icon-table">Fecha de creación</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($ordenes->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center">No hay ordenes.</td>
                        </tr>
                    @else
                    @foreach ($ordenes as $orden)
                        <tr>
                            <td class="align-middle">
                                <button class="btn btn-light-info" data-bs-toggle="modal" data-bs-target="#detalleOrdenModal" data-orden-id="{{ $orden->id }}" data-bs-toggle="popover" title="Ver detalle de la orden">
                                    {{ $orden->id }}
                                </button>
                            </td>
                            <td class="align-middle">
                                @if ($orden->presupuesto_id === null)
                                    Presupuesto eliminado
                                @else
                                    {{ $orden->presupuesto_id }}
                                @endif
                            </td>
                            <td class="align-middle">{{ $orden->cliente_nombre }} {{ $orden->cliente_apellido }}</td>
                            <td class="align-middle">{{ $orden->cliente_dni }}</td>
                            <td class="align-middle">{{ $orden->precio_total }}</td>
                            <td class="align-middle">{{ $orden->created_at }}</td>
                            <td class="align-middle">
                                <a href="" class="btn btn-light-success" data-orden-id="{{ $orden->id }}" data-bs-toggle="popover" title="Generar factura"><i class="fa-solid fa-receipt"></i></a>
                                <form id="delete-form-{{ $orden->id }}" action="{{ route('orden.destroy', $orden->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="page" value="{{ $ordenes->currentPage() }}">
                                    <button type="button" class="btn btn-light-danger delete-btn" data-orden-id="{{ $orden->id }}" data-bs-toggle="popover" title="Cancelar orden"><i class="fa-solid fa-xmark"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

            @php
            $totalPages = $ordenes->lastPage();
            $currentPage = $ordenes->currentPage();
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
                            <a class="page-link" href="{{ $ordenes->url(1) }}&tab=all">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ ($ordenes->currentPage() == $i) ? 'active' : '' }}">
                            <a class="page-link" href="{{ $ordenes->url($i) }}&tab=all">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ $ordenes->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Ordener no cobradas -->
        <div <div class="tab-pane fade {{ $tab == 'non-charged' ? 'show active' : '' }}" id="non-charged" role="tabpanel" aria-labelledby="non-charged-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Orden</th>
                        <th class="icon-table">Presupuesto</th>
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">DNI Cliente</th>
                        <th class="icon-table">Precio total</th>
                        <th class="icon-table">Fecha de creación</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($ordenes->where('cobrado', 0)->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center">No hay ordenes por cobrar.</td>
                        </tr>
                    @else
                    @foreach ($ordenes->where('aceptado', 0) as $orden)
                    <tr>
                        <td class="align-middle">
                            <button class="btn btn-light-info" data-bs-toggle="modal" data-bs-target="#detallePresupuestoModal" data-presupuesto-id="{{ $orden->id }}" data-bs-toggle="popover" title="Ver detalle de presupuesto">
                                {{ $orden->id }}
                            </button>
                        </td>
                        <td class="align-middle">
                            @if ($orden->presupuesto_id === null)
                                Presupuesto eliminado
                            @else
                                {{ $orden->presupuesto_id }}
                            @endif
                        </td>
                        <td class="align-middle">{{ $orden->cliente_nombre }} {{ $orden->cliente_apellido }}</td>
                        <td class="align-middle">{{ $orden->cliente_dni }}</td>
                        <td class="align-middle">{{ $orden->precio_total }}</td>
                        <td class="align-middle">{{ $orden->created_at }}</td>
                        <td class="align-middle">
                            <a href="" class="btn btn-light-success create-order-btn" data-presupuesto-id="{{ $orden->id }}" data-bs-toggle="popover" title="Crear orden"><i class="fa-solid fa-check"></i></a>
                            <form id="delete-form-{{ $orden->id }}" action="{{ route('orden.destroy', $orden->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="page" value="{{ $ordenes->currentPage() }}">
                                <button type="button" class="btn btn-light-danger delete-btn" data-presupuesto-id="{{ $orden->id }}" data-bs-toggle="popover" title="Eliminar presupuesto"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

            @php
            $totalPages = $ordenes->lastPage();
            $currentPage = $ordenes->currentPage();
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
                            <a class="page-link" href="{{ $ordenes->url(1) }}&tab=all">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ ($ordenes->currentPage() == $i) ? 'active' : '' }}">
                            <a class="page-link" href="{{ $ordenes->url($i) }}&tab=all">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ $ordenes->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>

        <!-- Ordenes cobradas -->
        <div class="tab-pane fade {{ $tab == 'charged' ? 'show active' : '' }}" id="charged" role="tabpanel" aria-labelledby="charged-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Orden</th>
                        <th class="icon-table">Presupuesto</th>
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">DNI Cliente</th>
                        <th class="icon-table">Precio total</th>
                        <th class="icon-table">Fecha de creación</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($ordenes->where('cobrado', 1)->isEmpty())
                        <tr>
                            <td colspan="7" class="text-center">Todas las ordenes han sido cobradas.</td>
                        </tr>
                    @else
                    @foreach ($ordenes->where('aceptado', 1) as $orden)
                    <tr>
                        <td class="align-middle">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#detallePresupuestoModal" data-presupuesto-id="{{ $orden->id }}" data-bs-toggle="popover" title="Ver detalle de presupuesto">
                                {{ $orden->id }}
                            </button>
                        </td>
                        <td class="align-middle">
                            @if ($orden->presupuesto_id === null)
                                Presupuesto eliminado.
                            @else
                                {{ $orden->presupuesto_id }}
                            @endif
                        </td>
                        <td class="align-middle">{{ $orden->cliente_nombre }} {{ $orden->cliente_apellido }}</td>
                        <td class="align-middle">{{ $orden->cliente_dni }}</td>
                        <td class="align-middle">{{ $orden->precio_total }}</td>
                        <td class="align-middle">{{ $orden->created_at }}</td>
                        <td class="align-middle">
                            <a href="" class="btn btn-light-success create-order-btn" data-presupuesto-id="{{ $orden->id }}" data-bs-toggle="popover" title="Crear orden"><i class="fa-solid fa-check"></i></a>
                            <form id="delete-form-{{ $orden->id }}" action="{{ route('orden.destroy', $orden->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="page" value="{{ $ordenes->currentPage() }}">
                                <button type="button" class="btn btn-light-danger delete-btn" data-presupuesto-id="{{ $orden->id }}" data-bs-toggle="popover" title="Eliminar presupuesto"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>

            @php
            $totalPages = $ordenes->lastPage();
            $currentPage = $ordenes->currentPage();
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
                            <a class="page-link" href="{{ $ordenes->url(1) }}&tab=all">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ ($ordenes->currentPage() == $i) ? 'active' : '' }}">
                            <a class="page-link" href="{{ $ordenes->url($i) }}&tab=all">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ $ordenes->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>
    </div>

     <!-- Modal para ver la orden -->
    <div class="modal fade" id="detalleOrdenModal" tabindex="-1" aria-labelledby="detalleOrdenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="detalleOrdenContent"></div>
                <div class="modal-footer">
                    <!-- Contenedor para los botones -->
                    <div id="modalButtonsContainer"></div>
                </div>
            </div>
        </div>
    </div>

</div>

@if (session('suc_cobrado'))
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
            title: "Orden cobrada."
        });
    });
</script>
@endif

@if (session('del_ord'))
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
            title: "Orden cancelada y productos devueltos al stock."
        });
    });
</script>
@endif

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = sessionStorage.getItem('success_ord');
        if (successMessage) {
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
                title: successMessage
            });
            //Eliminar el mensaje de la sesión
            sessionStorage.removeItem('success_ord');
        }
    });

    $(document).ready(function() {
    // Manejar clic en el botón de cancelar orden
    $('.delete-btn').click(function() {
        var ordenId = $(this).data('orden-id');
        var formId = '#delete-form-' + ordenId;

        // Mostrar confirmación antes de enviar el formulario de eliminación
        Swal.fire({
            title: "¿Estás seguro?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Sí, cancelar orden",
            cancelButtonText: "Cancelar",
            html: `<p>Esta acción no se puede deshacer</p>
            <small>De cancelar la orden, los productos de esta orden se actualizarán con la cantidad de stock original</small>
            `,
        }).then((result) => {
            if (result.isConfirmed) {
                $(formId).submit();
            }
        });
    });

    // Evento al mostrar el modal detalles de la orden
    $('#detalleOrdenModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var ordenId = button.data('orden-id');

        $.ajax({
            url: 'orden/' + ordenId,
            method: 'GET',
            success: function(response) {
                $('#detalleOrdenContent').html(response);

                var clienteEmail = response.cliente ? response.cliente.email : null;

                $('#modalButtonsContainer').html(`
                    <a href="orden/${ordenId}/download" class="btn btn-light-primary"><i class="fa-solid fa-circle-down"></i> Descargar PDF</a>
                    <button type="button" class="btn btn-light-success btn-send-to-client" data-cliente-email="${clienteEmail}" data-orden-id="${ordenId}">
                        <i class="fa-solid fa-envelope"></i> Enviar a Cliente
                    </button>
                `);
            },
            error: function(xhr, status, error) {
                alert('Error al obtener los detalles de la orden.');
                console.error(status);
                console.error(xhr);
                console.error(error);
            }
        });
    });

    $('#modalButtonsContainer').on('click', '.btn-send-to-client', function(e) {
        e.preventDefault();

        // Obtener el presupuestoId del atributo data
        var ordenId = $(this).data('orden-id');
        console.log(ordenId);

        // Realizar la solicitud AJAX para enviar el correo
        $.ajax({
            url: 'orden/send-mail/' + ordenId,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                //alert('Correo electrónico enviado correctamente al cliente.');
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
                    title: 'Orden enviada correctamente al cliente.'
                });
                $('#detalleOrdenModal').modal('hide');
            },
            error: function(xhr, status, error) {
                //alert('Error al enviar el correo electrónico.');
                console.error(error);const Toast = Swal.mixin({
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
                icon: "error",
                title: "Error al enviar correo electrónico."
            });
            }
        });
    });

});
</script>
@endpush
</x-default-layout>
