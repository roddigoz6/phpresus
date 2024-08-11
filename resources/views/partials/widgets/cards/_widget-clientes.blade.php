<!--begin::Card widget 17-->
<div class="card card-flush h-md-50 mb-5 mb-xl-10">

    <div class="card-header pt-5">

        <div class="card-title d-flex flex-column">

            <div class="d-flex align-items-center">
                <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">Clientes</span>
                <i class="fa-solid fa-face-smile"></i>
            </div>
            <span class="text-gray-500 pt-1 fw-semibold fs-6">Distribución de Clientes</span>

        </div>

    </div>

    <div class="card-body pt-2 pb-4 d-flex flex-wrap align-items-center">
        @if ($clientes->isEmpty())
        <div class="d-flex flex-column align-items-center w-100">
            <span class="fs-3 text-gray-500">No hay clientes registrados.</span>
        </div>

        @else
        <div class="d-flex flex-center me-5 pt-2">
            <canvas id="clientesChart" style="min-width: 50px; min-height: 50px;"></canvas>
        </div>

        <div class="d-flex flex-column content-justify-center flex-row-fluid">

            <div class="d-flex fw-semibold align-items-center">
                <div class="bullet w-8px h-3px rounded-2 bg-success me-3"></div>
                <div class="text-gray-500 flex-grow-1 me-4">Clientes establecidos</div>
                <div class="fw-bolder text-gray-700 text-xxl-end">{{ $clientesEstablecidos }}</div>
            </div>

            <div class="d-flex fw-semibold align-items-center my-3">
                <div class="bullet w-8px h-3px rounded-2 bg-primary me-3"></div>
                <div class="text-gray-500 flex-grow-1 me-4">Clientes no establecidos</div>
                <div class="fw-bolder text-gray-700 text-xxl-end">{{ $clientesNoEstablecidos }}</div>
            </div>

            <div class="d-flex fw-semibold align-items-center">
                <div class="bullet w-8px h-3px rounded-2 me-3" style="background-color: #E4E6EF"></div>
                <div class="text-gray-500 flex-grow-1 me-4">Total de Clientes</div>
                <div class="fw-bolder text-gray-700 text-xxl-end">{{ $clientes->count() }}</div>
            </div>

        </div>
        @endif

    </div>

</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var ctx = document.getElementById('clientesChart').getContext('2d');
        var clientesChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Clientes Establecidos', 'Clientes No Establecidos'],
                datasets: [{
                    label: 'Distribución de Clientes',
                    data: [{{ $clientesEstablecidos }}, {{ $clientesNoEstablecidos }}],
                    backgroundColor: ['#28a745', '#007bff'],
                    borderColor: ['#ffffff', '#ffffff'],
                    borderWidth: 1
                }]
            },
            options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                tooltip: {
                    enabled: false,
                    mode: 'index',
                    intersect: false,
                    bodyFont: {
                        size: 10,
                    },
                    padding: 5,
                    caretSize: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    },
                },
                legend: {
                    display: false,
                    position: 'bottom',
                }
            },
                cutout: '70%',
            }
        });
    });

</script>
@endpush
