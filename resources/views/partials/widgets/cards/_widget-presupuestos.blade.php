<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #F1416C;background-image:url('assets/media/patterns/vector-1.png')">

    @if ($presupuestosCount == 0)
    <div class="card-header pt-5">
        <div class="card-title d-flex flex-column">
            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">No hay presupuestos registrados.</span>
        </div>
    </div>

    @else
    <div class="card-header pt-5">
        <div class="card-title d-flex flex-column">
            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $presupuestosCount }} presupuestos</span>
            <span class="text-white opacity-75 pt-1 fw-semibold fs-6">
                {{ $presupuestosAceptados }} presupuestos aceptados
                y {{ $presupuestosNoAceptados }} presupuestos no aceptados.
            </span>
        </div>
    </div>

    <div class="card-body d-flex align-items-end pt-0">
        <div class="d-flex align-items-center flex-column mt-3 w-100">
            <div class="d-flex justify-content-between fw-bold fs-6 text-white opacity-75 w-100 mt-auto mb-2">
                <span>{{ $presupuestosAceptados }} Aceptados</span>
                <span>{{ round($porcentajeAceptados, 2) }}%</span>
            </div>
            <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                <div class="bg-white rounded h-8px" role="progressbar" style="width: {{ $porcentajeAceptados }}%;" aria-valuenow="{{ $porcentajeAceptados }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    @endif
</div>
