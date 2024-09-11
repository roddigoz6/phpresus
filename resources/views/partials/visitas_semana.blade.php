<div class="card-body d-flex flex-column align-items-center overflow-auto">
    <div class="table-responsive w-100">
        <table class="table table-light text-center table-hover rounded-table">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Prioridad</th>
                    <th scope="col">Motivo de visita</th>
                    <th scope="col">Contacto</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Proyecto</th>
                    <th scope="col">Fecha</th>
                </tr>
            </thead>
            <tbody>
                @if ($visitas->isEmpty())
                    <div class="d-flex flex-column align-items-center">
                        <span class="fs-3 text-gray-500">No hay visitas esta semana.</span>
                    </div>
                @else
                @foreach ($visitas as $visita)
                    <tr>
                        @switch($visita->prioridad)
                            @case('Alta')
                            <td class="align-middle">{{$visita->prioridad}}
                                <i class="fa-solid fa-exclamation fa-beat text-warning"></i>
                                <i class="fa-solid fa-exclamation fa-beat text-warning"></i>
                                <i class="fa-solid fa-exclamation fa-beat text-warning"></i>
                            </td>
                                @break
                            @case('Media')
                                <td class="align-middle">{{$visita->prioridad}}
                                    <i class="fa-solid fa-exclamation fa-beat text-warning"></i>
                                    <i class="fa-solid fa-exclamation fa-beat text-warning"></i>
                                </td>
                                    @break
                            @case('Baja')
                                <td class="align-middle">{{$visita->prioridad}}
                                    <i class="fa-solid fa-exclamation fa-beat text-warning"></i>
                                </td>
                                    @break
                            @default
                        @endswitch
                        <td class="align-middle">{{ $visita->descripcion }}</td>
                        <td class="align-middle">{{ $visita->contacto_visita }}</td>
                        <td class="align-middle">{{ $visita->proyecto->cliente->direccion }}</td>
                        <td class="align-middle">{{ $visita->proyecto->proyecto_id }} {{ $visita->proyecto->serie_ref }}</td>
                        <td class="align-middle">
                            <span class="badge badge-info">{{ $visita->fecha_inicio }} {{ $visita->hora_inicio }}</span>
                        </td>
                    </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

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
                <li class="page-item {{ ($visitas->currentPage() == $i) ? 'active' : '' }}">
                    <a class="page-link" href="{{ $visitas->url($i) }}&tab=all">{{ $i }}</a>
                </li>
            @endfor

            @if ($endPage < $totalPages)
                @if ($endPage < $totalPages - 1)
                    <li class="page-item disabled"><span class="page-link">...</span></li>
                @endif
                <li class="page-item">
                    <a class="page-link" href="{{ $visitas->url($totalPages) }}&tab=all">{{ $totalPages }}</a>
                </li>
            @endif
        </ul>

    </div>
</div>
