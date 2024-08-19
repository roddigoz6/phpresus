@if (!$productos->isEmpty())
    <table class="table table-light table-hover text-center rounded-table">
        <thead class="table-dark">
            <tr>
                <th class="icon-table">Nombre</th>
                <th class="icon-table">Precio</th>
                <th class="icon-table">Stock</th>
                <th class="icon-table agregar">Agregar</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $producto)
                @if($producto->stock > 0)
                    <tr id="producto-{{ $producto->id }}" data-categoria-id="{{ $producto->categoria_id }}" draggable="true" ondragstart="drag(event)">
                        <td class="producto-id" style="display: none;">{{ $producto->id }}</td>
                        <td class="producto-nombre">{{ $producto->nombre }}</td>
                        <td class="producto-precio">{{ $producto->precio }} €</td>
                        <td class="producto-stock">{{ $producto->stock }} cntd.</td>
                        <td class="agregar">
                            <button
                                class="btn btn-light-primary agregar-presupuesto"
                                data-producto-id="{{ $producto->id }}"
                                onclick="agregarProducto({{ $producto->id }})"><i class="fas fa-plus-circle "></i>
                            </button>
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    @php
        $totalPages = $productos->lastPage();
        $currentPage = $productos->currentPage();
        $maxPagesToShow = 5; // Número máximo de enlaces de página a mostrar

        $startPage = max($currentPage - floor($maxPagesToShow / 2), 1);
        $endPage = min($startPage + $maxPagesToShow - 1, $totalPages);

        // Ajuste para cuando hay menos de $maxPagesToShow páginas a mostrar al principio o al final
        if ($endPage - $startPage + 1 < $maxPagesToShow) {
            $startPage = max($endPage - $maxPagesToShow + 1, 1);
        }
    @endphp

    <div class="d-flex justify-content-center">
        <ul class="pagination">
            @if ($startPage > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $productos->url(1) }}&tab=all">1</a>
                </li>
                @if ($startPage > 2)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endif

            @for ($i = $startPage; $i <= $endPage; $i++)
                <li class="page-item {{ ($productos->currentPage() == $i) ? 'active' : '' }}">
                    <a class="page-link" href="{{ $productos->url($i) }}&tab=all">{{ $i }}</a>
                </li>
            @endfor

            @if ($endPage < $totalPages)
                @if ($endPage < $totalPages - 1)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $productos->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                </li>
            @endif
        </ul>
    </div>
@else
    <div class="alert alert-warning" role="alert">
        No hay resultados.
    </div>
@endif
