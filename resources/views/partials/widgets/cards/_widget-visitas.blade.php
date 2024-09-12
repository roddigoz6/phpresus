
<div class="card card-flush h-100" style="background-image:url('assets/media/patterns/pattern-1.jpg');background-size: cover; background-position: center; background-repeat: no-repeat; width: 100%; height: 100%;">
    <div class="card-header pt-5">
        <div class="card-title d-flex flex-column">
            <div class="d-flex align-items-center">
                <span class="fs-2hx fw-bold text-white me-2 lh-1 ls-n2">Visitas agendadas esta semana, del {{ $rangoSemana }}</span>
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
