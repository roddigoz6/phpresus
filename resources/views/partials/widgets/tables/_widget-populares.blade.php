<div class="card card-flush h-md-100">

    <div class="card-header pt-7">
        <div class="card-title d-flex flex-column">
            <span class="fs-2hx fw-bold me-2 lh-1 ls-n2">Productos más populares</span>
        </div>
    </div>

    <div class="card-body pt-6">

        <div class="table-responsive">
            <table class="table table-row-dashed text-center gs-0 gy-3 my-0">
                <thead>
                    <tr class="fs-7 fw-bold text-gray-500 border-bottom-0">
                        <th class="p-0 pb-3 min-w-175px text-start">Id</th>
                        <th class="p-0 pb-3 min-w-100px text-end">Nombre de producto</th>
                        <th class="p-0 pb-3 min-w-100px text-end">Precio</th>
                        <th class="p-0 pb-3 min-w-175px text-end pe-12">Stock disponible</th>
                        <th class="p-0 pb-3 w-125px text-end pe-7">Presupuesto</th>
                        <th class="p-0 pb-3 w-50px text-end">Orden</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productosMasPopulares as $popular)
                    <tr>
                        <td class="text-start pe-0 align-middle">{{$popular->id}}</td>

                        <td class="text-end pe-0 align-middle">
                            {{$popular->nombre}}
                        </td>

                        <td class="text-end pe-0 align-middle">
                            {{$popular->precio}}
                        </td>

                        @if ($popular->stock <= 5)
                        <td class="text-end pe-12 align-middle">
                            <span class="badge py-3 px-4 fs-7 badge-light-danger">{{ $popular->stock }}</span>
                        </td>
                        @else
                        <td class="text-end pe-12 align-middle">
                            <span class="badge py-3 px-4 fs-7 badge-light-success">{{ $popular->stock }}</span>
                        </td>
                        @endif

                        @if ($popular->presupuesto == null)
                        <td class="text-end pe-12 align-middle">
                            <span class="badge py-3 px-4 fs-7 badge-light-warning">Presupuesto no registrado</span>
                        </td>
                        @else
                        <td class="text-end pe-12 align-middle">
                            <span class="badge py-3 px-4 fs-7 badge-light-success">{{ $popular->presupuesto->id }}</span>
                        </td>
                        @endif

                        <td class="text-end pe-0 align-middle">
                            <!-- Puedes añadir contenido aquí si es necesario -->
                        </td>

                        <td class="text-end align-middle">
                            <!-- Puedes añadir contenido aquí si es necesario -->
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
