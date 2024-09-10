<div class="modal fade" id="visitaCerrarModal" tabindex="-1" aria-labelledby="visitaCerrarModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="visitaCerrarModalLabel">Cerrar visita <strong></strong> del proyecto {{ $visita->proyecto->proyecto_id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="visitaCerrarForm" action="{{ route('visita.cerrar', ':id') }}" method="POST">
                    @csrf
                    <input type="hidden" id="visita-id-input" name="visita_id" value="">

                    <div class="mb-3">
                        Motivo de la visita: <strong id="visitaDescripcion">{{ $visita->descripcion }}</strong>
                    </div>

                    <div class="mb-3">
                        <textarea class="form-control" id="nota_cerrar" name="nota_cerrar" placeholder="Comentario de cierre" rows="3" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-light-danger">Cerrar Visita <i class="fa fa-circle-check"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
