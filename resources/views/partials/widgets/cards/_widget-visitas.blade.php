<div class="card card-flush ">

    <div class="card-header pt-5">
        <div class="card-title d-flex flex-column">
            <span class="text-gray-500 pt-1 fw-semibold fs-6">Visitas agendadas esta semana, del</span>

            <div class="d-flex align-items-center">
                <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">{{ $rangoSemana }}</span>
                <i class="fa-regular fa-calendar fa-shake"></i>
            </div>
        </div>
    </div>

    <div class="card-body  d-flex flex-wrap align-items-center">
        @if ($visitas->isEmpty())
            <div class="d-flex flex-column align-items-center">
                <span class="fs-3 text-gray-500">No hay visitas esta semana.</span>
            </div>
        @else
        <div class="table-responsive">
            <table class="table table-light text-center table-hover rounded-table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Motivo de visita</th>
                        <th scope="col">Proyecto</th>
                        <th scope="col">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visitas as $visita)
                        <tr>
                            <td class="align-middle">{{ $visita->descripcion }}</td>
                            <td class="align-middle">{{ $visita->proyecto->proyecto_id }}
                            {{ $visita->proyecto->serie_ref }}</td>
                            <td class="align-middle">
                                <span class="badge badge-info">{{ $visita->fecha_inicio }} {{ $visita->hora_inicio }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

</div>
