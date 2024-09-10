<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
    <div class="menu-item px-3">
        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Gestionar visita de proyecto: {{ $visita->proyecto->proyecto_id }}</div>
    </div>

    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3 cerrar-btn"
           data-visita-id="{{ $visita->id }}"
           data-visita-descripcion="{{ $visita->descripcion }}"
           data-proyecto-id="{{ $visita->proyecto->proyecto_id }}"
           data-bs-toggle="modal"
           data-bs-target="#visitaCerrarModal">
            <span class="menu-title">Cerrar visita</span>
            <span><i class="fa-solid fa-circle-check"></i></span>
        </a>
    </div>

    <div class="menu-item px-3">
        <form id="delete-form-{{ $visita->id }}" action="{{ route('visita.destroy', $visita->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-light-danger delete-btn" data-visita-id="{{ $visita->id }}">
                Eliminar visita <i class="fa-solid fa-trash"></i>
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let menuLinks = document.querySelectorAll('.menu-item a');

    menuLinks.forEach(link => {
        let icon = link.querySelector('.fa-solid');
        if (icon && !link.closest('form')) {
            link.addEventListener('mouseover', () => {
                icon.classList.add('fa-beat', 'text-primary');
            });

            link.addEventListener('mouseout', () => {
                icon.classList.remove('fa-beat', 'text-primary');
            });
        }
    });
});
</script>
