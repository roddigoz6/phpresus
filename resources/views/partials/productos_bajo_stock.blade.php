@if (!$productosBajoStock->isEmpty())
<table class="table table-light text-center table-hover rounded-table">
    <thead class="table-dark">
        <tr>
            <th scope="col">id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Categoría</th>
            <th scope="col">Cantidad</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($productosBajoStock as $producto)
        <tr>
            <td><span class="badge badge-light-info fs-base">{{ $producto->id }}</span></td>
            <td>{{ $producto->nombre }}</td>
            <td>{{ $producto->categoria->nombre }}</td>
            <td><span class="badge badge-light-danger fs-base">{{ $producto->stock }}</span></td>
        </tr>
    @endforeach
    </tbody>
</table>

@php
$totalPages = $productosBajoStock->lastPage();
$currentPage = $productosBajoStock->currentPage();
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
                <a class="page-link" href="{{ $productosBajoStock->url(1) }}&tab=all">1</a>
            </li>
            @if ($startPage > 2)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
        @endif

        @for ($i = $startPage; $i <= $endPage; $i++)
            <li class="page-item {{ ($productosBajoStock->currentPage() == $i) ? 'active' : '' }}">
                <a class="page-link" href="{{ $productosBajoStock->url($i) }}&tab=all">{{ $i }}</a>
            </li>
        @endfor

        @if ($endPage < $totalPages)
            @if ($endPage < $totalPages - 1)
                <li class="page-item disabled"><span class="page-link">...</span></li>
            @endif
            <li class="page-item">
                <a class="page-link" href="{{ $productosBajoStock->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
            </li>
        @endif
    </ul>
</div>

@else
    <h3 class="text-center">
        No hay productos con menos de <span class="text-danger opacity-75-hover">5 unidades</span> en stock. :)
    </h3>
@endif
