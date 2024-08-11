<div class="card card-flush h-md-100">
    <div class="card-body d-flex flex-column justify-content-between mt-3 bgi-no-repeat bgi-size-cover bgi-position-x-center pb-0" style="background-position: 100% 50%; background-image:url('assets/media/stock/900x600/42.png')">
        <div class="mb-10">
            <div class="fs-2hx fw-bold text-gray-800 text-center mb-3">
                <span class="me-2">Productos con menos de
                <span class="position-relative d-inline-block text-danger">
                    <a href="#" class="text-danger opacity-75-hover">5 unidades en stock</a>
                    <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                </span></span>:
            </div>

            <div id="productos-bajo-stock-content">
                <!-- Aquí se cargará el contenido con AJAX -->
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('producto.index') }}" class="btn btn-sm btn-dark fw-bold">Ir a productos</a>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function() {
    loadProductosBajoStock();

    function loadProductosBajoStock(page = 1) {
        $.ajax({
            url: "{{ route('productos.bajo.stock') }}?page=" + page,
            success: function(data) {
                $('#productos-bajo-stock-content').html(data);
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error: ' + status + ' - ' + error);
                console.log(xhr.responseText);
            }
        });
    }

    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        loadProductosBajoStock(page);
    });
});
</script>
@endpush
