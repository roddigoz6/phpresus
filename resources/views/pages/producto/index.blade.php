<x-default-layout>
    @section('title')
        Productos
    @endsection
<div class="container">
    <div class="row my-3 align-items-center">
        <div class="col text-start">
            <h2>Productos</h2>
        </div>
        <div class="col text-end">
            <a class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
                Ingresar nuevo producto <i class="fas fa-plus-circle"></i></a>
        </div>
    </div>

    <div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearProductoModalLabel">Nuevo producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('producto.store') }}" method="POST">
                        @csrf
                        <div class="">
                            <label for="nombre">Nombre del Producto</label> <strong class="required"></strong>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="">
                            <label for="precio">Precio</label> <strong class="required"></strong>
                            <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01" required>
                        </div>
                        <div class="">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                        </div>
                        <div class="">
                            <label for="stock">Stock</label> <strong class="required"></strong>
                            <input type="number" class="form-control" id="stock" name="stock" min="0" required>
                        </div>
                        <div class="">
                            <label for="tipo">Tipo</label> <strong class="required"></strong>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="Artículo">Artículo</option>
                                <option value="Visita">Visita</option>
                            </select>
                        </div>
                        <div class="mt-3">Los campos con <strong class="required"></strong> son requeridos.</div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-light-primary mt-3" id="CreaProd">Ingresar nuevo producto <i class="fas fa-check-circle"></i></button>
                        </div>
                    </form>
                    @if (session('success_prod'))
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
                                    title: "Producto agregado."
                                });
                            });
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('producto.index') }}" method="GET" class="mb-3">
        <input type="hidden" name="tab" value="{{ $tab }}">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Buscar por nombre de producto" value="{{ $search }}">
            <button class="btn btn-light-primary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <ul class="nav nav-tabs mt-3" id="categoriasTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link {{ $tab == 'todas' ? 'active' : '' }}" id="todas_tab" href="{{ route('producto.index', ['tab' => 'todas', 'search' => $search]) }}">Todos</a>
        </li>
    </ul>
    <!-- Contenido de las pestañas -->
    <div class="tab-content mt-3" id="categoriasTabContent">
        <div class="tab-pane fade show active" id="todas" role="tabpanel" aria-labelledby="todas_tab">
            <div class="table-responsive">
                <table class="table table-light text-center table-hover rounded-table">
                    <thead class="table-dark">
                        <tr class="align-middle">
                            <th class="icon-table">Id</th>
                            <th class="icon-table">Nombre</th>
                            <th class="icon-table">Descripción</th>
                            <th class="icon-table">Precio</th>
                            <th class="icon-table">Stock</th>
                            <th class="icon-table">Fecha de ingreso</th>
                            <th class="icon-table">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                            <tr>
                                <td class="align-middle"><span class="badge badge-light-info fs-base">{{ $producto->id }}</span></td>
                                <td class="align-middle">{{ $producto->nombre }}</td>
                                <td class="align-middle">{{ $producto->leyenda }}</td>
                                <td class="align-middle">{{ $producto->precio }}</td>
                                @if ($producto->stock<5)
                                    <td class="align-middle"><span class="badge badge-light-danger fs-base"> {{ $producto->stock }} </span></td>                                    </span></td>
                                @else
                                    <td class="align-middle">{{ $producto->stock }}</td>
                                @endif
                                <td class="align-middle">{{ $producto->created_at->format('d/m/Y H:i') }}</td>
                                <td class="align-middle">
                                    <a href="#" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#editarProductoModal{{ $producto->id }}" data-bs-toggle="popover" title="Editar producto"><i class="fa-solid fa-pen-to-square"></i></a>
                                    <form id="delete-form-{{ $producto->id }}" action="{{ route('producto.destroy', $producto->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-light-danger delete-btn" data-producto-id="{{ $producto->id }}" data-bs-toggle="popover" title="Eliminar producto"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
                <!-- Paginación para "Todos" -->
                @if($tab == 'todas')
                @php
                    $totalPages = $productos->lastPage();
                    $currentPage = $productos->currentPage();
                    $maxPagesToShow = 5;

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
                                <a class="page-link" href="{{ $productos->url(1) }}&tab=todas">1</a>
                            </li>
                            @if ($startPage > 2)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                        @endif

                        @for ($i = $startPage; $i <= $endPage; $i++)
                            <li class="page-item {{ ($productos->currentPage() == $i) ? 'active' : '' }}">
                                <a class="page-link" href="{{ $productos->url($i) }}&tab=todas">{{ $i }}</a>
                            </li>
                        @endfor

                        @if ($endPage < $totalPages)
                            @if ($endPage < $totalPages - 1)
                                <li class="page-item disabled"><span class="page-link">...</span></li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $productos->url($totalPages) }}&tab=todas">{{ $totalPages }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modales para editar producto -->
    @foreach($productos as $producto)
        <div class="modal fade" id="editarProductoModal{{ $producto->id }}" tabindex="-1" aria-labelledby="editarProductoModalLabel{{ $producto->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarProductoModalLabel{{ $producto->id }}">Editar producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('producto.update', $producto->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="nombre{{ $producto->id }}">Nombre del Producto</label>
                                <input type="text" class="form-control" id="nombre{{ $producto->id }}" name="nombre" value="{{ $producto->nombre }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="precio{{ $producto->id }}">Precio</label>
                                <input type="number" class="form-control" id="precio{{ $producto->id }}" name="precio" value="{{ $producto->precio }}" min="0" step="0.01" required>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion{{ $producto->id }}">Descripción</label>
                                <textarea class="form-control" id="descripcion{{ $producto->id }}" name="descripcion" rows="3">{{ $producto->descripcion }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="stock{{ $producto->id }}">Stock</label>
                                <input type="number" class="form-control" id="stock{{ $producto->id }}" name="stock" value="{{ $producto->stock }}" min="0" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipo{{ $producto->id }}">Tipo</label>
                                <select class="form-select" id="tipo{{ $producto->id }}" name="tipo" required>
                                    <option value="Artículo" {{ $producto->tipo == 'Artículo' ? 'selected' : '' }}>Artículo</option>
                                    <option value="Visita" {{ $producto->tipo == 'Visita' ? 'selected' : '' }}>Visita</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-light-primary">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@if (session('delete_prod'))
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
            title: "Producto eliminado"
        });
    });
</script>
@endif

@if (session('update_prod'))
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
            title: "Producto actualizado."
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

        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productoId = button.getAttribute('data-producto-id');
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
                        document.getElementById(`delete-form-${productoId}`).submit();
                    }
                });
            });
        });
    });
</script>
@endpush
</x-default-layout>
