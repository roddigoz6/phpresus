@if (!$productos->isEmpty())
    <table class="table table-light table-hover text-center rounded-table">
        <thead>
            <tr>
                <th class="icon-table">Nombre</th>
                <th class="icon-table">Precio</th>
                <th class="icon-table">Stock</th>
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
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <ul class="pagination">
            {{-- Enlace a la primera página --}}
            @if ($productos->currentPage() > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ $productos->url(1) }}" data-page="1">1</a>
                </li>
                @if ($productos->currentPage() > 2)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
            @endif

            {{-- Enlaces a las páginas intermedias --}}
            @for ($i = max($productos->currentPage() - 2, 1); $i <= min($productos->currentPage() + 2, $productos->lastPage()); $i++)
                <li class="page-item {{ ($productos->currentPage() == $i) ? 'active' : '' }}">
                    <a class="page-link" href="{{ $productos->url($i) }}" data-page="{{ $i }}">{{ $i }}</a>
                </li>
            @endfor

            {{-- Enlace a la última página --}}
            @if ($productos->currentPage() < $productos->lastPage())
                @if ($productos->currentPage() < $productos->lastPage() - 1)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $productos->url($productos->lastPage()) }}" data-page="{{ $productos->lastPage() }}">{{ $productos->lastPage() }}</a>
                </li>
            @endif
        </ul>
    </div>
@else
    <div class="alert alert-warning" role="alert">
        No hay resultados.
    </div>
@endif
