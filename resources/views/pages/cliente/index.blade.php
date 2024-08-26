<x-default-layout>
@section('title')
    Clientes
@endsection
<div class="container">
    <div class="row my-3 align-items-center">
        <div class="col text-start">
            <h2>Clientes</h2>
        </div>
        <div class="col text-end">
            <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#crearClienteModalIndex" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Crear nuevo cliente">
               Agregar cliente <i class="fas fa-plus-circle"></i>
            </button>
        </div>
    </div>

    <!--Modal para agregar clientes-->
    <div class="modal fade" id="crearClienteModalIndex" tabindex="-1" aria-labelledby="crearClienteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{ route('cliente.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <div class="header-modal">
                                    <h4>Datos del cliente</span></h4>
                                    <input type="hidden" name="context" value="index">
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="">
                                            <label for="nombre">Nombre</label> <strong class="required"></strong>
                                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="">
                                            <label for="apellido">Apellido</label> <strong class="required"></strong>
                                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="">
                                            <label for="dni">DNI</label> <strong class="required"></strong>
                                            <input type="text" class="form-control" id="dni" name="dni" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div>
                                            <label for="movil">Móvil</label> <strong class="required"></strong>
                                            <input type="text" class="form-control" id="movil" name="movil" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <label for="email">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email">
                                </div>
                                <div class="">
                                    <label for="direccion">Direccion</label> <strong class="required"></strong>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required>
                                </div>
                                <div class="">
                                    <label for="cp">Código postal</label> <strong class="required"></strong>
                                    <input type="text" class="form-control" id="cp" name="cp" required>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="">
                                            <label for="poblacion">Población</label> <strong class="required"></strong>
                                            <input type="text" class="form-control" id="poblacion" name="poblacion" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="">
                                            <label for="provincia">Provincia</label> <strong class="required"></strong>
                                            <input type="text" class="form-control" id="provincia" name="provincia" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="">
                                            <label for="fax">Fax</label>
                                            <input type="text" class="form-control" id="fax" name="fax">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div>
                                            <label for="cargo">Cargo</label>
                                            <input type="text" class="form-control" id="cargo" name="cargo">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="header-modal">
                                    <h4>Datos de envío</h4>
                                </div>
                                <div class="">
                                    <label for="contacto">Contacto</label>
                                    <input type="text" class="form-control" id="contacto" name="contacto">
                                </div>
                                <div class="">
                                    <label for="titular_nom">Nombre de titular</label>
                                    <input type="text" class="form-control" id="titular_nom" name="titular_nom">
                                </div>
                                <div class="">
                                    <label for="titular_ape">Apellido de titular</label>
                                    <input type="text" class="form-control" id="titular_ape" name="titular_ape">
                                </div>
                                <div class="">
                                    <label for="direccion_envio">Dirección de envío</label>
                                    <input type="text" class="form-control" id="direccion_envio" name="direccion_envio">
                                </div>
                                <div class="">
                                    <label for="cp_envio">Código postal de dirección de envío</label>
                                    <input type="text" class="form-control" id="cp_envio" name="cp_envio">
                                </div>
                                <div class="">
                                    <label for="poblacion_envio">Población de dirección de envío</label>
                                    <input type="text" class="form-control" id="poblacion_envio" name="poblacion_envio">
                                </div>
                                <div class="">
                                    <label for="provincia_envio">Provincia de dirección de envío</label>
                                    <input type="text" class="form-control" id="provincia_envio" name="provincia_envio">
                                </div>

                            </div>
                            <div class="header-modal">
                                <h4>Pago</h4>
                            </div>
                            <div class="">
                                <label for="pago">Forma de pago</label>
                                <select class="form-select" id="pago" name="pago">
                                    <option value="Ver condiciones">Ver condiciones</option>
                                    <option value="50% inicio, 50% fin">50% inicio, 50% fin</option>
                                    <option value="50% termino de obra, resto a 90 dias">50% termino de obra, resto a 90 días</option>
                                    <option value="50% comienzo de obra, resto a convenir">50% comienzo de obra, resto a convenir</option>
                                    <option value="Certificaciones quincenales">Certificaciones quincenales</option>
                                    <option value="Como siempre">Como siempre</option>
                                    <option value="Contado termino de obra">Contado termino de obra</option>
                                    <option value="Convenir">Convenir</option>
                                    <option value="Fin de ejercicio, 15 de diciembre">Fin de ejercicio, 15 de diciembre</option>
                                    <option value="Letra de 90 dias">Letra de 90 días</option>
                                    <option value="Letra a la vista">Letra a la vista</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-3">Los campos <strong class="required"></strong> son requeridos.</div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-light-primary mt-3">Guardar <i class="fas fa-check-circle"></i></button>
                        </div>
                    </form>
                    @if (session('success_cli'))
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
                                    title: "Cliente agregado."
                                });
                            });
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('cliente.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Buscar cliente">
            <button class="btn btn-light-primary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <!-- Pestañas de navegación -->
    <ul class="nav nav-tabs" id="clienteTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="all-tab" data-bs-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true">Todos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="stablished-tab" data-bs-toggle="tab" href="#stablished" role="tab" aria-controls="stablished" aria-selected="false">Establecidos</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="not-stablished-tab" data-bs-toggle="tab" href="#not-stablished" role="tab" aria-controls="not-stablished" aria-selected="false">No establecidos</a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="clienteTabsContent">
        <!-- Todos los clientes -->
        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">Nombre</th>
                        <th class="icon-table">Apellido</th>
                        <th class="icon-table">DNI</th>
                        <th class="icon-table">Correo</th>
                        <th class="icon-table">Número móvil</th>
                        <th class="icon-table">Establecido</th>
                        <th class="icon-table">Cliente desde</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($clientes->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">No hay clientes.</td>
                        </tr>
                    @else
                    @foreach ($clientes as $cliente)
                        <tr>
                            <td class="align-middle">
                                <button class="btn btn-light-info" data-bs-toggle="modal" data-bs-target="#detalleClienteModal" data-cliente-id="{{ $cliente->id }}" data-bs-toggle="popover" title="Ver detalle de cliente">
                                    {{ $cliente->id }}
                                </button>
                            </td>

                            <td class="align-middle">{{ $cliente->nombre }}</td>
                            <td class="align-middle">{{ $cliente->apellido }}</td>
                            <td class="align-middle">{{ $cliente->dni }}</td>

                            <td class="align-middle">
                            @if ($cliente->email===null)
                                No hay email registrado.
                            @else
                                {{ $cliente->email }}
                            @endif
                            </td>

                            <td class="align-middle">{{ $cliente->movil }}</td>
                            <td class="align-middle">
                                @if ($cliente->establecido == 0)
                                    Cliente no establecido
                                @else
                                    Cliente establecido
                                @endif
                            </td>
                            <td class="align-middle">{{ $cliente->created_at->format('d/m/Y H:i') }}</td>
                            <td class="align-middle">
                                <!-- Botón para abrir el modal de edición -->
                                <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#editarClienteModal{{ $cliente->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>

                                <form id="delete-form-{{ $cliente->id }}" action="{{ route('cliente.destroy', $cliente->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-light-danger delete-btn" data-cliente-id="{{ $cliente->id }}" data-nombre="{{ $cliente->nombre }}" data-has-presupuestos="{{ $cliente->presupuestos()->exists() ? 'true' : 'false' }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            @php
            $totalPages = $clientes->lastPage();
            $currentPage = $clientes->currentPage();
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
                            <a class="page-link" href="{{ $clientes->url(1) }}&tab=all">1</a>
                        </li>
                        @if ($startPage > 2)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                    @endif

                    @for ($i = $startPage; $i <= $endPage; $i++)
                        <li class="page-item {{ ($clientes->currentPage() == $i) ? 'active' : '' }}">
                            <a class="page-link" href="{{ $clientes->url($i) }}&tab=all">{{ $i }}</a>
                        </li>
                    @endfor

                    @if ($endPage < $totalPages)
                        @if ($endPage < $totalPages - 1)
                            <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        <li class="page-item">
                            <a class="page-link" href="{{ $clientes->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        <!-- Clientes establecidos -->
        <div class="tab-pane fade" id="stablished" role="tabpanel" aria-labelledby="stablished-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">Nombre</th>
                        <th class="icon-table">Apellido</th>
                        <th class="icon-table">DNI</th>
                        <th class="icon-table">Correo</th>
                        <th class="icon-table">Número móvil</th>
                        <th class="icon-table">Cliente desde</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($clientes->where('establecido', 1)->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">No hay clientes establecidos.</td>
                        </tr>
                    @else
                    @foreach ($clientes->where('establecido', 1) as $cliente)
                        <tr>
                            <td class="align-middle">
                                <button class="btn btn-light-info" data-bs-toggle="modal" data-bs-target="#detalleClienteModal" data-cliente-id="{{ $cliente->id }}" data-bs-toggle="popover" title="Ver detalle de cliente">
                                    {{ $cliente->id }}
                                </button>
                            </td>

                            <td class="align-middle">{{ $cliente->nombre }}</td>
                            <td class="align-middle">{{ $cliente->apellido }}</td>
                            <td class="align-middle">{{ $cliente->dni }}</td>

                            <td class="align-middle">
                                @if ($cliente->email===null)
                                    No hay email registrado.
                                @else
                                    {{ $cliente->email }}
                                @endif
                            </td>

                            <td class="align-middle">{{ $cliente->movil }}</td>
                            <td class="align-middle">{{ $cliente->created_at->format('d/m/Y H:i') }}</td>
                            <td class="align-middle">
                                <!-- Botón para abrir el modal de edición -->
                                <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#editarClienteModal{{ $cliente->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form id="delete-form-{{ $cliente->id }}" action="{{ route('cliente.destroy', $cliente->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-light-danger delete-btn" data-cliente-id="{{ $cliente->id }}" data-nombre="{{ $cliente->nombre }}" data-has-presupuestos="{{ $cliente->presupuestos()->exists() ? 'true' : 'false' }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            @if($tab == 'stablished')
                @php
                $totalPages = $clientes->lastPage();
                $currentPage = $clientes->currentPage();
                $maxPagesToShow = 5;

                $startPage = max($currentPage - floor($maxPagesToShow / 2), 1);
                $endPage = min($startPage + $maxPagesToShow - 1, $totalPages);

                if ($endPage - $startPage + 1 < $maxPagesToShow) {
                    $startPage = max($endPage - $maxPagesToShow + 1, 1);
                }
                @endphp

                <div class="d-flex justify-content-center">
                    <ul class="pagination">
                        @if ($startPage > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $clientes->url(1) }}&tab=stablished">1</a>
                            </li>
                            @if ($startPage > 2)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endif

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item {{ ($clientes->currentPage() == $i) ? 'active' : '' }}">
                                <a class="page-link" href="{{ $clientes->url($i) }}&tab=stablished">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($endPage < $totalPages)
                            @if ($endPage < $totalPages - 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $clientes->url($totalPages) }}&tab=stablished">{{ $totalPages }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>

        <!-- Clientes no establecidos -->
        <div class="tab-pane fade" id="not-stablished" role="tabpanel" aria-labelledby="not-stablished-tab">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr class="align-middle">
                        <th class="icon-table">Cliente</th>
                        <th class="icon-table">Nombre</th>
                        <th class="icon-table">Apellido</th>
                        <th class="icon-table">DNI</th>
                        <th class="icon-table">Correo</th>
                        <th class="icon-table">Número móvil</th>
                        <th class="icon-table">Cliente desde</th>
                        <th class="icon-table">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($clientes->where('establecido', 0)->isEmpty())
                        <tr>
                            <td colspan="9" class="text-center">No hay clientes no establecidos.</td>
                        </tr>
                    @else
                    @foreach ($clientes->where('establecido', 0) as $cliente)
                        <tr>
                            <td class="align-middle">
                                <button class="btn btn-light-info" data-bs-toggle="modal" data-bs-target="#detalleClienteModal" data-cliente-id="{{ $cliente->id }}" data-bs-toggle="popover" title="Ver detalle de cliente">
                                    {{ $cliente->id }}
                                </button>
                            </td>

                            <td class="align-middle">{{ $cliente->nombre }}</td>
                            <td class="align-middle">{{ $cliente->apellido }}</td>
                            <td class="align-middle">{{ $cliente->dni }}</td>

                            <td class="align-middle">
                                @if ($cliente->email===null)
                                    No hay email registrado.
                                @else
                                    {{ $cliente->email }}
                                @endif
                            </td>

                            <td class="align-middle">{{ $cliente->movil }}</td>
                            <td class="align-middle">{{ $cliente->created_at->format('d/m/Y H:i') }}</td>
                            <td class="align-middle">
                                <!-- Botón para abrir el modal de edición -->
                                <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#editarClienteModal{{ $cliente->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form id="delete-form-{{ $cliente->id }}" action="{{ route('cliente.destroy', $cliente->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-light-danger delete-btn" data-cliente-id="{{ $cliente->id }}" data-nombre="{{ $cliente->nombre }}" data-has-presupuestos="{{ $cliente->presupuestos()->exists() ? 'true' : 'false' }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
            @if($tab == 'not-stablished')
                @php
                $totalPages = $clientes->lastPage();
                $currentPage = $clientes->currentPage();
                $maxPagesToShow = 5;

                $startPage = max($currentPage - floor($maxPagesToShow / 2), 1);
                $endPage = min($startPage + $maxPagesToShow - 1, $totalPages);

                if ($endPage - $startPage + 1 < $maxPagesToShow) {
                    $startPage = max($endPage - $maxPagesToShow + 1, 1);
                }
                @endphp

                <div class="d-flex justify-content-center">
                    <ul class="pagination">
                        @if ($startPage > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $clientes->url(1) }}&tab=not-stablished">1</a>
                            </li>
                            @if ($startPage > 2)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endif

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item {{ ($clientes->currentPage() == $i) ? 'active' : '' }}">
                                <a class="page-link" href="{{ $clientes->url($i) }}&tab=not-stablished">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($endPage < $totalPages)
                            @if ($endPage < $totalPages - 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $clientes->url($totalPages) }}&tab=not-stablished">{{ $totalPages }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para ver el cliente -->
<div class="modal fade" id="detalleClienteModal" tabindex="-1" aria-labelledby="detalleClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div id="detalleClienteContent"></div>
        </div>
    </div>
</div>

<!-- Modal para editar clientes -->
@foreach ($clientes as $cliente)
    <div class="modal fade" id="editarClienteModal{{ $cliente->id }}" tabindex="-1" aria-labelledby="editarClienteModalLabel{{ $cliente->id }}" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{ route('cliente.update', $cliente->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col">
                                <div class="header-modal">
                                    <h4>Datos de {{ $cliente->nombre }}</h4>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="">
                                            <label for="edit-nombre{{ $cliente->id }}">Nombre</label>
                                            <input type="text" class="form-control" id="edit-nombre{{ $cliente->id }}" name="nombre" value="{{ $cliente->nombre }}" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="">
                                            <label for="edit-apellido{{ $cliente->id }}">Apellido</label>
                                            <input type="text" class="form-control" id="edit-apellido{{ $cliente->id }}" name="apellido" value="{{ $cliente->apellido }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="">
                                            <label for="edit-dni{{ $cliente->id }}">DNI</label>
                                            <input type="text" class="form-control" id="edit-dni{{ $cliente->id }}" name="dni" value="{{ $cliente->dni }}" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="">
                                            <label for="edit-movil{{ $cliente->id }}">Móvil</label>
                                            <input type="text" class="form-control" id="edit-movil{{ $cliente->id }}" name="movil" value="{{ $cliente->movil }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="">
                                    <label for="edit-email{{ $cliente->id }}">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="edit-email{{ $cliente->id }}" name="email" value="{{ $cliente->email }}">
                                </div>
                                <div class="">
                                    <label for="edit-direccion{{ $cliente->id }}">Dirección</label>
                                    <input type="text" class="form-control" id="edit-direccion{{ $cliente->id }}" name="direccion" value="{{ $cliente->direccion }}" required>
                                </div>
                                <div class="">
                                    <label for="edit-cp{{ $cliente->id }}">Código postal</label>
                                    <input type="text" class="form-control" id="edit-cp{{ $cliente->id }}" name="cp" value="{{ $cliente->cp }}" required>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="">
                                            <label for="edit-poblacion{{ $cliente->id }}">Población</label>
                                            <input type="text" class="form-control" id="edit-poblacion{{ $cliente->id }}" name="poblacion" value="{{ $cliente->poblacion }}" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="">
                                            <label for="edit-provincia{{ $cliente->id }}">Provincia</label>
                                            <input type="text" class="form-control" id="edit-provincia{{ $cliente->id }}" name="provincia" value="{{ $cliente->provincia }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="">
                                            <label for="edit-fax{{ $cliente->id }}">Fax</label>
                                            <input type="text" class="form-control" id="edit-fax{{ $cliente->id }}" name="fax" value="{{ $cliente->fax }}">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="">
                                            <label for="edit-cargo{{ $cliente->id }}">Cargo</label>
                                            <input type="text" class="form-control" id="edit-cargo{{ $cliente->id }}" name="cargo" value="{{ $cliente->cargo }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="header-modal">
                                    <h4>Datos de envío</h4>
                                </div>
                                <div class="">
                                    <label for="edit-contacto{{ $cliente->id }}">Contacto</label>
                                    <input type="text" class="form-control" id="edit-contacto{{ $cliente->id }}" name="contacto" value="{{ $cliente->contacto }}">
                                </div>
                                <div class="">
                                    <label for="edit-titular_nom{{ $cliente->id }}">Nombre de titular</label>
                                    <input type="text" class="form-control" id="edit-titular_nom{{ $cliente->id }}" name="titular_nom" value="{{ $cliente->titular_nom }}">
                                </div>
                                <div class="">
                                    <label for="edit-titular_ape{{ $cliente->id }}">Apellido de titular</label>
                                    <input type="text" class="form-control" id="edit-titular_ape{{ $cliente->id }}" name="titular_ape" value="{{ $cliente->titular_ape }}">
                                </div>
                                <div class="">
                                    <label for="edit-direccion_envio{{ $cliente->id }}">Dirección de envío</label>
                                    <input type="text" class="form-control" id="edit-direccion_envio{{ $cliente->id }}" name="direccion_envio" value="{{ $cliente->direccion_envio }}">
                                </div>
                                <div class="">
                                    <label for="edit-cp_envio{{ $cliente->id }}">Código postal de dirección de envío</label>
                                    <input type="text" class="form-control" id="edit-cp_envio{{ $cliente->id }}" name="cp_envio" value="{{ $cliente->cp_envio }}">
                                </div>
                                <div class="">
                                    <label for="edit-poblacion_envio{{ $cliente->id }}">Población de dirección de envío</label>
                                    <input type="text" class="form-control" id="edit-poblacion_envio{{ $cliente->id }}" name="poblacion_envio" value="{{ $cliente->poblacion_envio }}">
                                </div>
                                <div class="">
                                    <label for="edit-provincia_envio{{ $cliente->id }}">Provincia de dirección de envío</label>
                                    <input type="text" class="form-control" id="edit-provincia_envio{{ $cliente->id }}" name="provincia_envio" value="{{ $cliente->provincia_envio }}">
                                </div>
                            </div>

                            <div class="header-modal">
                                <h4>Pago</h4>
                            </div>
                            <div class="">
                                <label for="edit-pago{{ $cliente->id }}">Forma de pago</label>
                                <select class="form-select" id="pago" name="pago">
                                    <option value="Ver condiciones">Ver condiciones</option>
                                    <option value="50% inicio, 50% fin">50% inicio, 50% fin</option>
                                    <option value="50% termino de obra, resto a 90 dias">50% termino de obra, resto a 90 días</option>
                                    <option value="50% comienzo de obra, resto a convenir">50% comienzo de obra, resto a convenir</option>
                                    <option value="Certificaciones quincenales">Certificaciones quincenales</option>
                                    <option value="Como siempre">Como siempre</option>
                                    <option value="Contado termino de obra">Contado termino de obra</option>
                                    <option value="Convenir">Convenir</option>
                                    <option value="Fin de ejercicio, 15 de diciembre">Fin de ejercicio, 15 de diciembre</option>
                                    <option value="Letra de 90 dias">Letra de 90 días</option>
                                    <option value="Letra a la vista">Letra a la vista</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-light-primary mt-3">Guardar cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

@if (session('update_cli'))
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
                title: "Cliente actualizado."
            });
        });
    </script>
@endif

@if (session('delete_cli'))
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
                title: "Cliente eliminado."
            });
        });
    </script>
@endif

@push('scripts')
<script>
     $(document).ready(function() {
        $('.delete-btn').click(function() {
            var clienteId = $(this).data('cliente-id');
            var clienteNombre = $(this).data('nombre');
            var formId = '#delete-form-' + clienteId;

            // Mostrar confirmación antes de enviar el formulario de eliminación del cliente
            Swal.fire({
                title: "¿Estás seguro?",
                text: `Estás a punto de eliminar al cliente ${clienteNombre}. Esta acción no se puede deshacer.`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Verificar si el cliente tiene presupuestos asociados
                    var hasPresupuestos = $(this).data('has-presupuestos');

                    if (hasPresupuestos) {
                        // Mostrar segunda confirmación si hay presupuestos asociados
                        Swal.fire({
                            title: "¡Advertencia!",
                            html: `<p>El cliente <strong>${clienteNombre}</strong> tiene presupuestos asociados.
                                   Eliminar al cliente eliminará sus presupuestos también.</p>
                                   <p>¿Estás seguro de querer eliminarlo?</p>`,
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#3085d6",
                            confirmButtonText: "Sí, eliminar",
                            cancelButtonText: "Cancelar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $(formId).submit();
                            }
                        });
                    } else {
                        $(formId).submit();
                    }
                }
            });
        });

    //Mostrar el modal con la info del cliente
    $('#detalleClienteModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var clienteId = button.data('cliente-id');

        $.ajax({
            url: "{{ route('cliente.show', ':id') }}".replace(':id', clienteId),
            method: 'GET',
            success: function(response) {
                $('#detalleClienteContent').html(response);
            },
                error: function(xhr, status, error) {
                alert('Error al obtener los detalles del cliente.');
                console.error(error);
            }
        });
    });
});

</script>
@endpush
</x-default-layout>
