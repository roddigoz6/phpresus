<div class="card card-flush h-md-50 mb-5 mb-xl-10">

    @if ($ordenesCount == 0)
    <div class="card-header pt-5">
        <div class="card-title d-flex flex-column">
            <span class="fs-2hx fw-bold me-2 lh-1 ls-n2">No hay órdenes registradas.</span>
        </div>
    </div>

    @else
    <div class="card-header pt-5">
        <div class="card-title d-flex flex-column">
            <span class="fs-2hx fw-bold text-primary-900 me-2 lh-1 ls-n2">{{ $ordenesCount }} órdenes</span>
            <span class="text-primary-500 pt-1 fw-semibold fs-6">
                {{ $ordenesCobradasCount }} cobradas, {{ $ordenesSinCobrarCount }} sin cobrar.
            </span>
        </div>
    </div>

    <div class="card-body d-flex align-items-end pt-0">
        <div class="d-flex align-items-center flex-column mt-3 w-100">
            <div class="d-flex justify-content-between fw-bold fs-6 text-dark opacity-75 w-100 mt-auto mb-2">
                <span>{{ $ordenesCobradasCount }} cobradas</span>
                <span>{{ round($porcentajeCobradas, 2) }}%</span>
            </div>
            <div class="h-8px mx-3 w-100 bg-dark bg-opacity-50 rounded">
                <div class="bg-white rounded h-8px" role="progressbar" style="width: {{ $porcentajeCobradas }}%;" aria-valuenow="{{ $porcentajeCobradas }}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        </div>
    </div>
    @endif
</div>
