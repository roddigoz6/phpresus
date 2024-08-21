<x-default-layout>
    @section('title')
        Categorías
    @endsection
<div class="container">
    <div class="row my-3 align-items-center">
        <div class="col text-start">
            <h2>Categorías de productos</h2>
        </div>
        <div class="col text-end">
            <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Crear nueva categoría">
                Nueva categoría <i class="fas fa-plus-circle"></i>
            </button>
        </div>
    </div>

    <!-- Modal para crear una nueva categoría -->
    <div class="modal fade" id="crearCategoriaModal" tabindex="-1" aria-labelledby="crearCategoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearCategoriaModalLabel">Nueva categoría</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para crear una nueva categoría -->
                    <form action="{{ route('categoria.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre">Nombre de categoría</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-light-primary">Guardar <i class="fas fa-check-circle"></i></button>
                        </div>
                    </form>
                    <!-- Mensaje de éxito -->
                    @if (session('success_cat'))
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
                                    title: "Categoría agregada."
                                });
                            });
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario de búsqueda -->
    <form action="{{ route('categoria.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Buscar categoría">
            <button class="btn btn-light-primary" type="submit"><i class="fas fa-search"></i></button>
        </div>
    </form>

    <!-- Tabla de categorías -->
    <table class="table table-light text-center table-hover rounded-table">
        <thead class="table-dark">
            <tr class="align-middle">
                <th class="icon-table">Categoría</th>
                <th class="icon-table">Nombre</th>
                <th class="icon-table">Fecha de creación</th>
                <th class="icon-table">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categorias as $categoria)
            <tr>
                <td class="align-middle">
                    <button class="btn btn-light-info btn-ver-productos" data-bs-toggle="modal" data-bs-target="#modalProductos{{ $categoria->id }}">
                        {{ $categoria->id }}
                    </button>
                </td>
                <td class="align-middle">{{ $categoria->nombre }}</td>
                <td class="align-middle">{{ $categoria->created_at->format('d/m/Y H:i') }}</td>
                <td class="align-middle">
                    <form id="delete-form-{{ $categoria->id }}" action="{{ route('categoria.destroy', $categoria->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-light-danger delete-btn" data-categoria-id="{{ $categoria->id }}" data-nombre="{{ $categoria->nombre }}" data-tiene-productos="{{ $categoria->productos()->exists() ? 'true' : 'false' }}" data-bs-toggle="popover" title="Eliminar categoría">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @php
    $totalPages = $categorias->lastPage();
    $currentPage = $categorias->currentPage();
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
                    <a class="page-link" href="{{ $categorias->url(1) }}&tab=all">1</a>
                </li>
                @if ($startPage > 2)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endif

            @for ($i = $startPage; $i <= $endPage; $i++)
                <li class="page-item {{ ($categorias->currentPage() == $i) ? 'active' : '' }}">
                    <a class="page-link" href="{{ $categorias->url($i) }}&tab=all">{{ $i }}</a>
                </li>
            @endfor

            @if ($endPage < $totalPages)
                @if ($endPage < $totalPages - 1)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $categorias->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                </li>
            @endif
        </ul>
    </div>
</div>

<!-- Modales de productos -->
@foreach ($categorias as $categoria)
    <div class="modal fade" id="modalProductos{{ $categoria->id }}" tabindex="-1" aria-labelledby="modalProductosLabel{{ $categoria->id }}" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProductosLabel{{ $categoria->id }}">Productos en categoría {{ $categoria->nombre }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-light text-center table-hover rounded-table">
                        <thead class="table-dark">
                            <tr class="align-middle">
                                <th>Producto</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categoria->productos as $producto)
                                <tr>
                                    <td class="align-middle"> <span class="badge px-4 fs-7 badge-light-info">{{ $producto->id }}</span></td>
                                    <td class="align-middle">{{ $producto->nombre }}</td>
                                    <td class="align-middle" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; text-align:justify;">{{ $producto->descripcion }}</td>
                                    <td class="align-middle">{{ $producto->precio }}</td>
                                    <td class="align-middle">
                                        <span class="badge px-4 fs-7
                                            {{ $producto->stock < 6 ? 'badge-light-danger' : 'badge-light-primary' }}">
                                            {{ $producto->stock }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay productos en esta categoría.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('producto.index') }}" class="btn btn-light-primary">Ir a Productos</a>
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endforeach


<!-- Script para mostrar mensaje de éxito al eliminar -->
@if (session('delete_cat'))
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
                title: "Categoría eliminada."
            });
        });
    </script>
@endif
<!-- Script para mostrar mensaje de éxito al eliminar -->
@if (session('error_gen'))
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
                icon: "warning",
                title: "La categoría General no puede ser eliminada."
            });
        });
    </script>
@endif

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            var categoriaId = $(this).data('categoria-id');
            var categoriaNombre = $(this).data('nombre');
            var formId = '#delete-form-' + categoriaId;

            if (categoriaNombre == "General") {
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
                    icon: "warning",
                    title: "La categoría General no puede ser eliminada."
                });
            } else {
                Swal.fire({
                title: "¿Estás seguro?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Eliminar",
                cancelButtonText: "Cancelar",
                html: `<p>Esta acción no se puede deshacer</p>`
            }).then((result) => {
                if (result.isConfirmed) {
                    // Verificar si se necesita mostrar la segunda confirmación
                    var tieneProductos = $(this).data('tiene-productos');

                    if (tieneProductos) {
                        // Mostrar segunda confirmación si hay productos asociados
                        Swal.fire({
                            title: "¡Advertencia!",
                            icon: "warning",
                            html: `<p>La categoría <strong>${categoriaNombre}</strong> tiene productos asociados. ¿Estás seguro de querer eliminarla?</p>
                            <p>Los productos relacionados a la categoría se actualizarán a categoría <strong>General</strong> y tendrás que volver a asociarlos manualmente.</p>`,
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#3085d6",
                            confirmButtonText: "Eliminar",
                            cancelButtonText: "Cancelar"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Enviar el formulario de eliminación
                                $(formId).submit();
                            }
                        });
                    } else {
                        // Si no hay productos asociados, proceder con la eliminación directamente
                        $(formId).submit();
                    }
                }
            });
            }
        });
    });
</script>
@endpush
</x-default-layout>
