@include('partials/modals/_asignar-visita')

<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
	<div class="menu-item px-3">
		<div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Gestionar proyecto: {{ $proyecto->proyecto_id }}</div>
	</div>

    @if ($proyecto->estado == 'presupuestado')
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3 aceptar-proyecto-btn" data-proyecto-id="{{ $proyecto->id }}">
            <span class="menu-title">Aceptar proyecto</span>
            <span><i class="fa-solid fa-circle-check"></i></span>
        </a>
    </div>

    @endif

    <div class="menu-item px-3">
		<a href="{{ route('presupuesto.edit', $proyecto->presupuesto->id) }}" class="menu-link px-3">
            <span class="menu-title">Editar proyecto</span>
            <span><i class="fa-solid fa-pen-to-square"></i></span>
        </a>
	</div>

    @if ($proyecto->estado != 'presupuestado')
    <div class="menu-item px-3">
        <a href="#" class="menu-link px-3"
        data-bs-toggle="modal"
        data-bs-target="#visitaModal"
        data-proyecto-id="{{ $proyecto->proyecto_id }}"
        data-serie-ref="{{ $proyecto->serie_ref ?? 'Serie no registrada.' }}"
        data-contacto="{{ $proyecto->cliente->contacto ?? 'Contacto no disponible' }}">
            <span class="menu-title">Asignar visita</span>
            <span><i class="fa-solid fa-calendar-check"></i></span>
        </a>
    </div>


    <div class="menu-item px-3">
        <a href="" class="menu-link px-3">
            <span class="menu-title">Generar factura</span>
            <span><i class="fa-solid fa-receipt"></i></span>
        </a>
    </div>

    <div class="menu-item px-3">
        <a href="{{ route('visita.store') }}" class="menu-link px-3">
            <span class="menu-title">Cerrar proyecto</span>
            <span><i class="fa-solid fa-circle-xmark"></i></span>
        </a>
    </div>
    @endif

    <div class="menu-item px-3">
		<form id="delete-form-{{ $proyecto->proyecto_id }}" action="{{ route('proyecto.destroy', $proyecto->proyecto_id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-light-danger delete-btn" data-proyecto-id="{{ $proyecto->proyecto_id }}">
                Eliminar proyecto <i class="fa-solid fa-trash"></i>
            </button>
        </form>
        <span class="menu-arrow"></span>
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

    document.addEventListener('DOMContentLoaded', function() {
    const visitaModal = document.getElementById('visitaModal');

    visitaModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget; // El botón que abrió el modal
        const proyectoId = button.getAttribute('data-proyecto-id');
        const serieRef = button.getAttribute('data-serie-ref');
        const contacto = button.getAttribute('data-contacto');

        // Actualiza los elementos en el modal con los valores capturados
        const modalTitle = visitaModal.querySelector('.modal-title strong');
        const proyectoInput = visitaModal.querySelector('input[name="proyecto_id"]');
        const contactoInput = visitaModal.querySelector('input[name="contacto_visita"]');

        modalTitle.textContent = `${proyectoId} - ${serieRef}`;
        proyectoInput.value = proyectoId;
        contactoInput.value = contacto;
    });
});

</script>
