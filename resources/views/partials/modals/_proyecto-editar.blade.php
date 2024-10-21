<div class="modal fade" id="editarProyectoModal" tabindex="-1" aria-labelledby="editarProyectoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editarProyectoLabel">Editar Proyecto {{$proyecto->proyecto_id}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Formulario de edición de proyecto -->
            <form id="editProyectoForm" method="post" action="{{ route('proyecto.update', $proyecto->proyecto_id) }}">
                @csrf
                @method('PUT') <!-- Usamos el método PUT para actualizar -->

                <div class="modal-body">
                    <!-- Aquí va el formulario con los datos que deseas editar -->
                    <div class="form-group mt-6">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <label for="serie_ref">Nombre del proyecto</label>
                                    <input class="form-control" type="text" name="serie_ref" id="serie_ref-edit" value="{{ $proyecto->serie_ref }}" required>
                                </div>

                                <div class="col col-auto">
                                    <label for="num_ref">Número de referencia del proyecto</label>
                                    <input class="form-control" type="text" value="{{ $proyecto->num_ref }}" disabled>
                                    <input type="hidden" name="num_ref" id="num_ref-edit" value="{{ $proyecto->num_ref }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <label for="pago">Forma de pago</label>
                                    <select class="form-select" id="pago-edit" name="pago">
                                        <option value="Ver condiciones" {{ $proyecto->pago == 'Ver condiciones' ? 'selected' : '' }}>Ver condiciones</option>
                                        <option value="50% inicio, 50% fin" {{ $proyecto->pago == '50% inicio, 50% fin' ? 'selected' : '' }}>50% inicio, 50% fin</option>
                                        <option value="50% termino de obra, resto a 90 dias" {{ $proyecto->pago == '50% termino de obra, resto a 90 dias' ? 'selected' : '' }}>50% termino de obra, resto a 90 días</option>

                                        <option value="50% comienzo de obra, resto a convenir" {{ $proyecto->pago == '50% comienzo de obra, resto a convenir' ? 'selected' : '' }}>50% comienzo de obra, resto a convenir</option>
                                        <option value="Certificaciones quincenales" {{ $proyecto->pago == 'Certificaciones quincenales' ? 'selected' : '' }}>Certificaciones quincenales</option>
                                        <option value="Como siempre" {{ $proyecto->pago == 'Como siempre' ? 'selected' : '' }}>Como siempre</option>
                                        <option value="Contado termino de obra" {{ $proyecto->pago == 'Contado termino de obra' ? 'selected' : '' }}>Contado termino de obra</option>
                                        <option value="Convenir" {{ $proyecto->pago == 'Convenir' ? 'selected' : '' }}>Convenir</option>
                                        <option value="Fin de ejercicio, 15 de diciembre" {{ $proyecto->pago == 'Fin de ejercicio, 15 de diciembre' ? 'selected' : '' }}>Fin de ejercicio, 15 de diciembre</option>
                                        <option value="Letra de 90 dias" {{ $proyecto->pago == 'Letra de 90 dias' ? 'selected' : '' }}>Letra de 90 días</option>
                                        <option value="Letra a la vista" {{ $proyecto->pago == 'Letra a la vista' ? 'selected' : '' }}>Letra a la vista</option>
                                    </select>
                                </div>

                                <div class="col col-auto">
                                    <label for="iva">IVA</label>
                                    <select class="form-select" id="iva-edit" name="iva">
                                        <option value="7" {{ $proyecto->iva == '7' ? 'selected' : '' }}>7</option>
                                        <option value="8" {{ $proyecto->iva == '8' ? 'selected' : '' }}>8</option>
                                        <option value="10" {{ $proyecto->iva == '10' ? 'selected' : '' }}>10</option>
                                        <option value="16" {{ $proyecto->iva == '16' ? 'selected' : '' }}>16</option>
                                        <option value="18" {{ $proyecto->iva == '18' ? 'selected' : '' }}>18</option>
                                        <option value="21" {{ $proyecto->iva == '21' ? 'selected' : '' }}>21</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
