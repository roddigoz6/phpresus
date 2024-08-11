<div class="card card-flush bgi-no-repeat bgi-size-contain bgi-position-x-end h-md-50 mb-5 mb-xl-10" style="background-image:url('assets/media/patterns/pattern-1.jpg');background-size: cover; background-position: center; background-repeat: no-repeat; width: 100%; height: 100%;">

    @if ($presupuestosCount == 0)
    <div class="card-header pt-5">
        <div class="card-title d-flex flex-column">
            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">No hay presupuestos registrados</span>
        </div>
    </div>

    @else
    <div class="card-header pt-5">
        <div class="card-title d-flex flex-column">
            <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">Facturas</span>
            <span class="text-white opacity-75 pt-1 fw-semibold fs-6">
               Facturas pendientes
            </span>
        </div>
    </div>
    @endif
</div>
