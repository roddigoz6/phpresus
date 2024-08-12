<x-default-layout>
    <div class="container">
        <div class="row my-3 align-items-center">
            <div class="col text-start">
                <h2>Presupuestos</h2>
            </div>
            <div class="col text-end">
                <a href="{{ route('presupuesto.create') }}" class="btn btn-light-primary">Nuevo presupuesto <i
                        class="fas fa-plus-circle"></i></a>
            </div>
        </div>

        <form action="{{ route('presupuesto.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Buscar por nombre de cliente">
                <button class="btn btn-light-primary" type="submit"><i class="fas fa-search"></i></button>
            </div>
        </form>

        <!-- Pestañas de navegación -->
        <ul class="nav nav-tabs" id="presupuestoTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab"
                    aria-controls="all" aria-selected="true">Todos</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="not-accepted-tab" data-bs-toggle="tab" href="#not-accepted" role="tab"
                    aria-controls="not-accepted" aria-selected="false">No Aceptados</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="accepted-tab" data-bs-toggle="tab" href="#accepted" role="tab"
                    aria-controls="accepted" aria-selected="false">Aceptados</a>
            </li>
        </ul>

        <div class="tab-content mt-3" id="presupuestoTabsContent">
            <!-- Todos los presupuestos -->
            <div class="tab-pane fade {{ $tab == 'all' ? 'show active' : '' }}" id="all" role="tabpanel"
                aria-labelledby="all-tab">
                <table class="table table-light text-center table-hover rounded-table">
                    <thead class="table-dark">
                        <tr class="align-middle">
                            <th class="icon-table">Id</th>
                            <th class="icon-table">Cliente</th>
                            <th class="icon-table">Precio total</th>
                            <th class="icon-table">Estado de presupuesto</th>
                            <th class="icon-table">Fecha de creación</th>
                            <th class="icon-table">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($presupuestos->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">No hay presupuestos creados.</td>
                            </tr>
                        @else
                            @foreach ($presupuestos as $presupuesto)
                                <tr>
                                    <td class="align-middle">
                                        <button class="btn btn-light-info" data-bs-toggle="modal"
                                            data-bs-target="#detallePresupuestoModal"
                                            data-presupuesto-id="{{ $presupuesto->id }}" data-bs-toggle="popover"
                                            title="Ver detalle de presupuesto">
                                            {{ $presupuesto->id }}
                                        </button>
                                    </td>
                                    <td class="align-middle">{{ $presupuesto->cliente->nombre }}</td>
                                    <td class="align-middle">{{ $presupuesto->precio_total }}</td>
                                    <td class="align-middle">
                                        @if ($presupuesto->aceptado == 0)
                                            Presupuesto no aceptado aún
                                        @else
                                            Presupuesto aceptado
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ $presupuesto->created_at }}</td>
                                    <td class="align-middle">

                                        <a href="{{ route('presupuesto.edit', $presupuesto->id) }}"
                                            class="btn btn-light-primary" data-bs-toggle="popover"
                                            title="Editar presupuesto"><i class="fa-solid fa-pen-to-square"></i></a>

                                        <a href="" class="btn btn-light-success create-order-btn"
                                            data-presupuesto-id="{{ $presupuesto->id }}" data-bs-toggle="popover"
                                            title="Crear orden"><i class="fa-solid fa-check"></i></a>

                                        <form action="{{ route('presupuesto.destroy', $presupuesto->id) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="page"
                                                value="{{ $presupuestos->currentPage() }}">
                                            <button type="button" class="btn btn-light-danger delete-btn"
                                                data-presupuesto-id="{{ $presupuesto->id }}" data-bs-toggle="popover"
                                                title="Eliminar presupuesto"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                @php
                    $totalPages = $presupuestos->lastPage();
                    $currentPage = $presupuestos->currentPage();
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
                                <a class="page-link" href="{{ $presupuestos->url(1) }}&tab=all">1</a>
                            </li>
                            @if ($startPage > 2)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endif

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item {{ $presupuestos->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $presupuestos->url($i) }}&tab=all">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($endPage < $totalPages)
                            @if ($endPage < $totalPages - 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $categorias->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                            </li>
                        @endif
                    </ul>
                </div>

            </div>

            <!-- Presupuestos no aceptados -->
            <div <div class="tab-pane fade {{ $tab == 'not-accepted' ? 'show active' : '' }}" id="not-accepted"
                role="tabpanel" aria-labelledby="not-accepted-tab">
                <table class="table table-light text-center table-hover rounded-table">
                    <thead class="table-dark">
                        <tr class="align-middle">
                            <th class="icon-table">Id</th>
                            <th class="icon-table">Cliente</th>
                            <th class="icon-table">Precio total</th>
                            <th class="icon-table">Estado de presupuesto</th>
                            <th class="icon-table">Fecha de creación</th>
                            <th class="icon-table">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($presupuestos->where('aceptado', 0)->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">No hay presupuestos no aceptados.</td>
                            </tr>
                        @else
                            @foreach ($presupuestos->where('aceptado', 0) as $presupuesto)
                                <tr>
                                    <td class="align-middle">
                                        <button class="btn btn-light-info" data-bs-toggle="modal"
                                            data-bs-target="#detallePresupuestoModal"
                                            data-presupuesto-id="{{ $presupuesto->id }}" data-bs-toggle="popover"
                                            title="Ver detalle de presupuesto">
                                            {{ $presupuesto->id }}
                                        </button>
                                    </td>
                                    <td class="align-middle">{{ $presupuesto->cliente->nombre }}</td>
                                    <td class="align-middle">{{ $presupuesto->precio_total }}</td>
                                    <td class="align-middle">presupuesto no aceptado aún</td>
                                    <td class="align-middle">{{ $presupuesto->created_at }}</td>
                                    <td class="align-middle">
                                        <a href="" class="btn btn-light-primary" data-bs-toggle="popover"
                                            title="Editar presupuesto"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="" class="btn btn-light-success create-order-btn"
                                            data-presupuesto-id="{{ $presupuesto->id }}" data-bs-toggle="popover"
                                            title="Crear orden"><i class="fa-solid fa-check"></i></a>
                                        <form id="delete-form-{{ $presupuesto->id }}"
                                            action="{{ route('presupuesto.destroy', $presupuesto->id) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="page"
                                                value="{{ $presupuestos->currentPage() }}">
                                            <button type="button" class="btn btn-light-danger delete-btn"
                                                data-presupuesto-id="{{ $presupuesto->id }}"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                @php
                    $totalPages = $presupuestos->lastPage();
                    $currentPage = $presupuestos->currentPage();
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
                                <a class="page-link" href="{{ $presupuestos->url(1) }}&tab=all">1</a>
                            </li>
                            @if ($startPage > 2)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endif

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item {{ $presupuestos->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $presupuestos->url($i) }}&tab=all">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($endPage < $totalPages)
                            @if ($endPage < $totalPages - 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $categorias->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Presupuestos aceptados -->
            <div class="tab-pane fade {{ $tab == 'accepted' ? 'show active' : '' }}" id="accepted" role="tabpanel"
                aria-labelledby="accepted-tab">
                <table class="table table-light text-center table-hover rounded-table">
                    <thead class="table-dark">
                        <tr>
                            <th class="icon-table">Id</th>
                            <th class="icon-table">Cliente</th>
                            <th class="icon-table">Precio total</th>
                            <th class="icon-table">Estado de presupuesto</th>
                            <th class="icon-table">Fecha de creación</th>
                            <th class="icon-table">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($presupuestos->where('aceptado', 1)->isEmpty())
                            <tr>
                                <td colspan="6" class="text-center">No hay presupuestos aceptados.</td>
                            </tr>
                        @else
                            @foreach ($presupuestos->where('aceptado', 1) as $presupuesto)
                                <tr>
                                    <td class="align-middle">
                                        <button class="btn btn-light-info" data-bs-toggle="modal"
                                            data-bs-target="#detallePresupuestoModal"
                                            data-presupuesto-id="{{ $presupuesto->id }}" data-bs-toggle="popover"
                                            title="Ver detalle de presupuesto">
                                            {{ $presupuesto->id }}
                                        </button>
                                    </td class="align-middle">
                                    <td class="align-middle">{{ $presupuesto->cliente->nombre }}</td>
                                    <td class="align-middle">{{ $presupuesto->precio_total }}</td>
                                    <td class="align-middle">Presupuesto aceptado</td>
                                    <td class="align-middle">{{ $presupuesto->created_at }}</td>
                                    <td class="align-middle">
                                        <a href="" class="btn btn-light-primary" data-bs-toggle="popover"
                                            title="Editar presupuesto"><i class="fa-solid fa-pen-to-square"></i></a>
                                        <a href="" class="btn btn-light-success create-order-btn"
                                            data-presupuesto-id="{{ $presupuesto->id }}" data-bs-toggle="popover"
                                            title="Crear orden"><i class="fa-solid fa-check"></i></a>
                                        <form id="delete-form-{{ $presupuesto->id }}"
                                            action="{{ route('presupuesto.destroy', $presupuesto->id) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="page"
                                                value="{{ $presupuestos->currentPage() }}">
                                            <button type="button" class="btn btn-light-danger delete-btn"
                                                data-presupuesto-id="{{ $presupuesto->id }}"><i
                                                    class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                @php
                    $totalPages = $presupuestos->lastPage();
                    $currentPage = $presupuestos->currentPage();
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
                                <a class="page-link" href="{{ $presupuestos->url(1) }}&tab=all">1</a>
                            </li>
                            @if ($startPage > 2)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endif

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item {{ $presupuestos->currentPage() == $i ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $presupuestos->url($i) }}&tab=all">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($endPage < $totalPages)
                            @if ($endPage < $totalPages - 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $categorias->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                            </li>
                        @endif
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal para ver el presupuesto -->
    <div class="modal fade" id="detallePresupuestoModal" tabindex="-1"
        aria-labelledby="detallePresupuestoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div id="detallePresupuestoContent"></div>
                <div class="modal-footer">
                    <!-- Contenedor para los botones -->
                    <div id="modalButtonsContainer"></div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success_pres'))
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
                    title: "Presupuesto creado"
                });
            });
        </script>
    @endif

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
                    title: "Presupuesto actualizado"
                });
            });
        </script>
    @endif

    @if (session('delete_presupuesto'))
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
                    title: "Presupuesto eliminado"
                });
            });
        </script>
    @endif

    @if (session('orden_prod_elim'))
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
                    icon: "error",
                    title: "{{ session('orden_prod_elim') }}"
                });
            });
        </script>
    @endif

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Evento clic en el botón "Eliminar"
                $('.delete-btn').click(function() {
                    var presupuestoId = $(this).data('presupuesto-id');

                    Swal.fire({
                        title: "¿Estás seguro?",
                        text: "No podrás revertir esto",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Eliminar",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $('#delete-form-' + presupuestoId).submit();
                        }
                    });
                });


                // Realizar la solicitud AJAX para enviar el correo
                $('#modalButtonsContainer').on('click', '.btn-send-to-client', function(e) {
                    e.preventDefault();

                    // Obtener el presupuestoId del atributo data
                    var presupuestoId = $(this).data('presupuesto-id');
                    console.log(presupuestoId);
                    // console.log("Stop");
                    // return;

                    // Realizar la solicitud AJAX para enviar el correo
                    $.ajax({
                        url: 'presupuesto/send-mail/' + presupuestoId,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        xhrFields: {
                            withCredentials: true // Enviar cookies con la petición
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
                                title: 'Correo electrónico enviado correctamente al cliente.'
                            });
                            $('#detallePresupuestoModal').modal('hide');
                        },
                        error: function(xhr, status, error) {
                            //alert('Error al enviar el correo electrónico.');
                            console.log(xhr.responseJSON.message);
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
                                icon: "error",
                                title: "Error al enviar correo electrónico."
                            });
                        }
                    });
                });

                // Evento al mostrar el modal para cargar detalles del presupuesto
                $('#detallePresupuestoModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var presupuestoId = button.data('presupuesto-id');

                    $.ajax({
                        url: 'presupuesto/' + presupuestoId,
                        method: 'GET',
                        success: function(response) {
                            $('#detallePresupuestoContent').html(response);

                            var clienteEmail = response.cliente ? response.cliente.email : null;

                            $('#modalButtonsContainer').html(`
                                <a href="presupuesto/${presupuestoId}/download" class="btn btn-light-primary"><i class="fa-solid fa-circle-down"></i> Descargar PDF</a>

                                <button type="submit" class="btn btn-light-success btn-send-to-client" data-cliente-email="${clienteEmail}" data-presupuesto-id="${presupuestoId}">
                                    <i class="fa-solid fa-envelope"></i> Enviar a Cliente
                                </button>
                            `);
                        },
                        error: function(xhr, status, error) {
                            alert('Error al obtener los detalles del presupuesto.');
                            console.error(error);
                        }
                    });
                });

                // Evento clic en el botón "Crear Orden"
                $('.create-order-btn').click(function(event) {
                    event.preventDefault();
                    var presupuestoId = $(this).data('presupuesto-id');
                    Swal.fire({
                        title: "Nueva orden",
                        text: "¿Deseas crear una orden para este presupuesto?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#28a745",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Crear",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '{{ route('orden.store') }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    presupuesto_id: presupuestoId
                                },
                                success: function(response) {
                                    var orden = response.orden;
                                    var message =
                                        "<div style='white-space: pre-line;'>Datos de la orden\n";
                                    message += "Id de orden: <strong>" + orden.id +
                                        "</strong>\n";
                                    message += "Fecha de creación: <strong>" + orden
                                        .created_at + "</strong>\n";
                                    message += "Productos en orden:\n";
                                    //DEV
                                    //console.log("");
                                    //DEV
                                    orden.productos.forEach(function(producto) {
                                        message += "Producto ID: <strong>" +
                                            producto.producto_id +
                                            "</strong>, Cantidad: <strong>" +
                                            producto.cantidad +
                                            "</strong>, Precio: <strong>" + producto
                                            .precio + "</strong>\n";
                                    });
                                    message += "</div>";
                                    //DEV
                                    //console.log(message);
                                    //DEV
                                    Swal.fire({
                                        title: '¡Órden creada!',
                                        html: message,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.href =
                                            '{{ route('orden.index') }}';
                                    });
                                },
                                error: function(xhr, status, error) {
                                    if (xhr.status === 400) {
                                        var errorMessage = xhr.responseJSON.message;
                                        var messageProdElim = xhr.responseJSON
                                            .message_prod_elim;
                                        var messageProdStock = xhr.responseJSON
                                            .message_prod_stock;
                                        var allowForceCreate = xhr.responseJSON
                                            .allow_force_create;

                                        if (messageProdElim) {
                                            Swal.fire({
                                                title: 'Advertencia',
                                                text: messageProdElim,
                                                icon: 'warning',
                                                showCancelButton: false,
                                                confirmButtonColor: "#28a745",
                                                confirmButtonText: "Cerrar"
                                            });
                                        } else if (messageProdStock) {
                                            Swal.fire({
                                                title: 'Advertencia',
                                                text: messageProdStock,
                                                icon: 'warning',
                                                showCancelButton: false,
                                                confirmButtonColor: "#28a745",
                                                confirmButtonText: "Cerrar"
                                            });
                                        } else if (allowForceCreate) {
                                            Swal.fire({
                                                title: 'Advertencia',
                                                text: errorMessage,
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: "#28a745",
                                                cancelButtonColor: "#3085d6",
                                                confirmButtonText: "Crear de todos modos",
                                                cancelButtonText: "Cancelar"
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Realiza la solicitud AJAX nuevamente con force_create
                                                    $.ajax({
                                                        url: '{{ route('orden.store') }}',
                                                        method: 'POST',
                                                        data: {
                                                            _token: '{{ csrf_token() }}',
                                                            presupuesto_id: presupuestoId,
                                                            force_create: true
                                                        },
                                                        success: function(
                                                            response) {
                                                            var orden =
                                                                response
                                                                .orden;
                                                            var message =
                                                                "<div style='white-space: pre-line;'>Datos de la orden\n";
                                                            message +=
                                                                "Id de orden: <strong>" +
                                                                orden
                                                                .id +
                                                                "</strong>\n";
                                                            message +=
                                                                "Fecha de creación: <strong>" +
                                                                orden
                                                                .created_at +
                                                                "</strong>\n";
                                                            message +=
                                                                "Productos en orden:\n";
                                                            //DEV
                                                            //console.log("lsdfglkj");
                                                            //DEV
                                                            orden
                                                                .productos
                                                                .forEach(
                                                                    function(
                                                                        producto
                                                                    ) {
                                                                        message
                                                                            +=
                                                                            "Producto ID: <strong>" +
                                                                            producto
                                                                            .producto_id +
                                                                            "</strong>, Cantidad: <strong>" +
                                                                            producto
                                                                            .cantidad +
                                                                            "</strong>, Precio: <strong>" +
                                                                            producto
                                                                            .precio +
                                                                            "</strong>\n";
                                                                    });
                                                            message +=
                                                                "</div>";
                                                            //DEV
                                                            //console.log(message);
                                                            //DEV
                                                            Swal.fire({
                                                                title: '¡Órden creada!',
                                                                html: message,
                                                                icon: 'success',
                                                                confirmButtonText: 'OK'
                                                            }).then(
                                                                () => {
                                                                    window
                                                                        .location
                                                                        .href =
                                                                        '{{ route('orden.index') }}';
                                                                });
                                                        },
                                                        error: function(xhr,
                                                            status,
                                                            error) {
                                                            // Loguea el error en la consola
                                                            console
                                                                .error(
                                                                    xhr
                                                                    .status +
                                                                    ': ' +
                                                                    xhr
                                                                    .statusText
                                                                );
                                                            if (xhr
                                                                .responseJSON
                                                            ) {
                                                                console
                                                                    .error(
                                                                        'Detalles del error:',
                                                                        xhr
                                                                        .responseJSON
                                                                    );
                                                            }
                                                            // Verifica si hay un mensaje de error específico en la respuesta
                                                            var errorMessage =
                                                                '';
                                                            if (xhr
                                                                .responseJSON
                                                            ) {
                                                                if (xhr
                                                                    .responseJSON
                                                                    .message
                                                                ) {
                                                                    errorMessage
                                                                        =
                                                                        xhr
                                                                        .responseJSON
                                                                        .message;
                                                                } else if (
                                                                    xhr
                                                                    .responseJSON
                                                                    .message_prod_elim
                                                                ) {
                                                                    errorMessage
                                                                        =
                                                                        xhr
                                                                        .responseJSON
                                                                        .message_prod_elim;
                                                                } else if (
                                                                    xhr
                                                                    .responseJSON
                                                                    .message_prod_stock
                                                                ) {
                                                                    errorMessage
                                                                        =
                                                                        xhr
                                                                        .responseJSON
                                                                        .message_prod_stock;
                                                                }
                                                            }
                                                            // Muestra un mensaje de alerta con el mensaje de error específico
                                                            Swal.fire({
                                                                title: 'Error',
                                                                html: '<div>' +
                                                                    errorMessage +
                                                                    '.</div>',
                                                                icon: 'error',
                                                                confirmButtonText: 'OK'
                                                            });
                                                        }

                                                    });
                                                }
                                            });
                                        } else {
                                            Swal.fire({
                                                title: 'Advertencia',
                                                text: errorMessage,
                                                icon: 'warning',
                                                showCancelButton: false,
                                                confirmButtonColor: "#28a745",
                                                confirmButtonText: "Cerrar"
                                            });
                                        }
                                    } else {
                                        // Loguea el error en la consola
                                        console.error(xhr.status + ': ' + xhr.statusText);
                                        if (xhr.responseText) {
                                            console.error('Detalles del error:', xhr
                                                .responseText);
                                        }
                                        Swal.fire({
                                            title: 'Error',
                                            text: 'No se pudo crear la orden.',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }
                                }
                            });
                        }
                    });
                });

                // Manejo de las pestañas con URL params
                const urlParams = new URLSearchParams(window.location.search);
                const tab = urlParams.get('tab');

                if (tab) {
                    const tabElement = document.querySelector(`#${tab}-tab`);
                    const tabContent = document.querySelector(`#${tab}`);

                    if (tabElement && tabContent) {
                        // Activar la pestaña y el contenido correspondiente
                        document.querySelector('.nav-link.active').classList.remove('active');
                        document.querySelector('.tab-pane.show.active').classList.remove('show', 'active');
                        tabElement.classList.add('active');
                        tabContent.classList.add('show', 'active');
                    }
                }
            });
        </script>
    @endpush
</x-default-layout>
