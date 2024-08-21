@php
    $colors = ['bg-success', 'bg-info', 'bg-danger', 'bg-primary'];
    $randomColor = $colors[array_rand($colors)];
@endphp

<div class="card card-flush h-md-100">

    <div class="card-header pt-7">
        <div class="card-title d-flex flex-column">
            <span class="fs-2hx fw-bold me-2 lh-1 ls-n2">Productos más populares</span>
        </div>
    </div>


    <div class="card-body pt-6">
    @if (!$productosMasPopulares->isEmpty())
        <div class="table-responsive d-flex justify-content-center">
            <table class="table table-hover table-row-dashed text-center gs-0 gy-3 my-0 rounded-table">
                <thead class="table-dark">
                    <tr class="fs-7 fw-bold border-bottom-0 align-middle">
                        <th class="icon-table">Id</th>
                        <th class="icon-table">Nombre de producto</th>
                        <th class="icon-table">Descripción</th>
                        <th class="icon-table">Precio</th>
                        <th class="icon-table">Stock disponible</th>
                        <th class="icon-table">Presupuesto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productosMasPopulares as $popular)
                    <tr>
                        <td class="align-middle">
                            <div class="symbol symbol-35px symbol-circle">
                                <span class="symbol-label bg-info text-inverse-info fw-bold">{{$popular->id}}</span>
                            </div>
                        </td>

                        <td class="align-middle">
                            {{$popular->nombre}}
                        </td>

                        <td class="align-middle" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; text-align:justify;">
                            {{$popular->descripcion}}
                        </td>

                        <td class="align-middle">
                            <strong>€{{$popular->precio}}</strong>
                        </td>

                        @if ($popular->stock <= 5)
                        <td class="align-middle">
                            <span class="badge px-4 fs-7 badge-light-danger">{{ $popular->stock }}</span>
                        </td>
                        @else
                        <td class="align-middle">
                            <span class="badge px-4 fs-7 badge-light-success">{{ $popular->stock }}</span>
                        </td>
                        @endif

                        <td class="align-middle">
                            <div class="symbol-group symbol-hover flex-nowrap align-middle justify-content-center">
                                @foreach($popular->producto_presupuestos->take(5) as $index => $productoPresupuesto)

                                @if ($productoPresupuesto->presupuesto && !$productoPresupuesto->presupuesto->eliminado)
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Presupuesto {{ $productoPresupuesto->presupuesto->id }}">
                                        <span class="symbol-label {{ $randomColor }} text-inverse-success fw-bold">{{ $productoPresupuesto->presupuesto->id }}</span>
                                    </div>
                                @else
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Presupuesto no registrado o eliminado">
                                        <span class="symbol-label bg-warning text-inverse-warning fw-bold">N/A</span>
                                    </div>
                                @endif
                                @endforeach

                                @if($popular->producto_presupuestos->count() > 5)
                                    @php
                                        $remainingCount = $popular->producto_presupuestos->count() - 5;
                                    @endphp
                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" data-bs-trigger="hover" title="{{ $remainingCount }} presupuestos más">
                                        <span class="symbol-label bg-secondary text-dark fs-8 fw-bold">+{{ $remainingCount }}</span>
                                    </div>
                                @endif
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <h3 class="text-center">
        Aún no hay productos registrados en <span class="text-danger opacity-75-hover">presupuestos</span>. :)
    </h3>
    @endif
</div>
