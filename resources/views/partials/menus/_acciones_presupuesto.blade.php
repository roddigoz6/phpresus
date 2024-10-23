
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
    <div class="menu-item px-3">
        <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">Gestionar presupuesto: {{ $presupuesto->id }}
            <span class="badge badge-secondary">{{ $proyecto->proyecto_id }}</span>
        </div>
    </div>

    @if (!$proyecto->cerrado)
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3 aceptar-presupuesto-btn" data-presupuesto-id="{{ $presupuesto->id }}">
                <span class="menu-title">Aceptar presupuesto</span>
                <span><i class="fa-solid fa-circle-check"></i></span>
            </a>
        </div>
        <div class="menu-item px-3">
            <a href="{{ route('proyecto.download', ['id' => $proyecto->proyecto_id]) }}" class="menu-link px-3 descargar-proyecto-btn" data-presupuesto-id="{{ $presupuesto->id }}">
                <span class="menu-title">Descargar PDF simple</span>
                <span><i class="fa-solid fa-file-pdf"></i></span>
            </a>
        </div>

        @if ($proyecto->estado != 'presupuestado')
        <div class="menu-item px-3">
            <a href="{{ route('proyecto.downloadBudget', ['id' => $proyecto->proyecto_id]) }}" class="menu-link px-3 descargar-proforma-btn" data-presupuesto-id="{{ $presupuesto->id }}">
                <span class="menu-title">Descargar proforma</span>
                <span><i class="fa-solid fa-circle-down"></i></span>
            </a>
        </div>
        @endif

        <div class="menu-item px-3">
            <a href="" class="menu-link px-3 enviar-presupuesto-btn" data-presupuesto-id="{{ $presupuesto->id }}">
                <span class="menu-title">Enviar PDF simple</span>
                <span><i class="fa-solid fa-envelope"></i></span>
            </a>
        </div>

        @if ($proyecto->estado != 'presupuestado')
        <div class="menu-item px-3">
            <a href="" class="menu-link px-3 enviar-proforma-btn" data-presupuesto-id="{{ $presupuesto->id }}">
                <span class="menu-title">Enviar proforma</span>
                <span><i class="fa-solid fa-envelopes-bulk"></i></span>
            </a>
        </div>
        @endif

        <div class="menu-item px-3">
            <a href="{{ route('presupuesto.edit', $presupuesto->id) }}" class="menu-link px-3">
                <span class="menu-title">Editar presupuesto</span>
                <span><i class="fa-solid fa-pen-to-square"></i></span>
            </a>
        </div>

        <div class="menu-item px-3">
            <a href="" class="menu-link px-3 facturar-presupuesto-btn" data-presupuesto-id="{{ $presupuesto->id }}">
                <span class="menu-title">Generar factura</span>
                <span><i class="fa-solid fa-euro"></i></span>
            </a>
        </div>

    @endif

    <div class="menu-item px-3">
        <form id="delete-form-{{ $presupuesto->id }}" action="{{ route('presupuesto.destroy', $presupuesto->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-light-danger delete-btn-presupuesto" data-presupuesto-id="{{ $presupuesto->id }}">
                Eliminar <i class="fa-solid fa-trash"></i>
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
</script>
