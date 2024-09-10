<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-color: #F1416C;background-image:url('assets/media/patterns/vector-1.png')">

    @if ($proyectos == 0)
    <div class="card-header pt-5">
        <div class="card-title d-flex flex-column">
            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">No hay proyectos registrados.</span>
        </div>
    </div>

    @else
    <div class="card-header pt-5">
        <div class="row w-100">
            <div class="card-title">
                <div class="col col-me">
                    <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">{{ $proyectos }} proyectos</span>
                </div>
                <div class="col col-auto flex-end">
                    <a href="{{ route('proyecto.index') }}" class="btn btn-light">Ir a proyectos</a>
                </div>
            </div>

        </div>
    </div>

    <div class="card-body d-flex align-items-end pt-0">
        <div class="d-flex align-items-center flex-column mt-3 w-100">

<span class="text-white pt-1 fw-semibold fs-6">
                        {{ $proyectoAcept }} aceptados,
                        {{ $proyectoPorFac }} por facturar, y
                        {{ $proyectoPorCobr }} pendientes de cobro.
                        {{ $proyectoCobr }} cobrados, y
                        {{ $proyectoCerrado }} cerrados.
                    </span>

        </div>
    </div>
    @endif
</div>
