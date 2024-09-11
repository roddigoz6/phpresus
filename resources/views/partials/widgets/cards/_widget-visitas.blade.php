<div class="card card-flush h-100">
    <div class="card-header pt-5">
        <div class="card-title d-flex flex-column">
            <span class="text-gray-500 pt-1 fw-semibold fs-6">Visitas agendadas esta semana, del</span>

            <div class="d-flex align-items-center">
                <span class="fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2">Visitas agendadas esta semana, del {{ $rangoSemana }}</span>
                <i class="fa-regular fa-calendar fa-shake"></i>
            </div>
        </div>
    </div>

    <div id="visitas-semana">

    </div>
</div>
@push('scripts')
<script>
$(document).ready(function() {
    loadVisitasSemana();

    function loadVisitasSemana(page = 1) {
        $.ajax({
            url: "{{ route('visita.semana') }}?page=" + page,
            success: function(data) {
                $('#visitas-semana').html(data);
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
        loadVisitasSemana(page);
    });
});
</script>
@endpush
