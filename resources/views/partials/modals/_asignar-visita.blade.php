<div class="modal fade" id="visitaModal" tabindex="-1" aria-labelledby="visitaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="visitaModalLabel">Asignar visita proyecto: <strong>{{ $proyecto->proyecto_id }} - {{ $proyecto->serie_ref ?? 'Serie no registrada.' }}</strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('visita.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="proyecto_id" value="{{ $proyecto->proyecto_id }}">

                    <div class="mb-3">
                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Motivo de la visita">
                    </div>
                    <div class="row">
                        <div class="col col-me">
                            <div class="mb-3">
                                <label for="kt_datepicker1" class="form-label">Fecha y Hora de inicio</label>
                                <input class="form-control form-control-solid" placeholder="Escoge una fecha y hora" id="kt_datepicker1"/>
                                <input type="hidden" id="fecha_inicio" name="fecha_inicio">
                                <input type="hidden" id="hora_inicio" name="hora_inicio">
                            </div>
                        </div>

                        <div class="col col-auto">
                            <div class="mb-3">
                                <label for="kt_datepicker2" class="form-label">Fecha y Hora de fin</label>
                                <input class="form-control form-control-solid" placeholder="Escoge una fecha y hora" id="kt_datepicker2"/>
                                <input type="hidden" id="fecha_fin" name="fecha_fin">
                                <input type="hidden" id="hora_fin" name="hora_fin">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <table class="table table-light text-center table-hover rounded-table">
                            <thead class="table-dark">
                                <tr class="align-middle">
                                    <th class="icon-table" colspan="4">
                                        Visitas agendadas esta semana, del {{ $rangoSemana }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($visitas->isEmpty())
                                    <tr>
                                        <td colspan="4">No hay visitas agendadas para esta semana.</td>
                                    </tr>
                                @else
                                    @foreach ($visitas as $visita)
                                        <tr>
                                            <td>{{ $visita->proyecto->proyecto_id }}</td>
                                            <td>
                                                <span class="badge badge-info">{{ $visita->fecha_inicio }} {{ $visita->hora_inicio }}</span>
                                            </td>
                                            <td>
                                                @if ($visita->fecha_fin && $visita->hora_fin)
                                                    <span class="badge badge-warning">{{ $visita->fecha_fin }} {{ $visita->hora_fin }}</span>
                                                @else
                                                    <span class="badge badge-warning">No registrado</span>
                                                @endif
                                            </td>
                                            <td>{{ $visita->contacto_visita }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="contacto_visita" class="form-label">Contacto Visita</label>
                                <input type="text" class="form-control" id="contacto_visita" name="contacto_visita"
                                       value="{{ $proyecto->cliente->contacto ?? 'Contacto no disponible' }}" required>
                            </div>
                        </div>

                        <div class="col col-auto">
                            <div class="mb-3">
                                <label for="prioridad" class="form-label">Prioridad</label>
                                <div class="star-rating">
                                    <i class="fa fa-star text-secondary" data-value="Baja"></i>
                                    <i class="fa fa-star text-secondary" data-value="Media"></i>
                                    <i class="fa fa-star text-secondary" data-value="Alta"></i>
                                </div>
                                <input type="hidden" id="prioridad" name="prioridad" value="Baja">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-light-primary">Asignar Visita <i class="fa fa-circle-check"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.star-rating .fa-star');
        const priorityInput = document.getElementById('prioridad');

        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                const value = this.getAttribute('data-value');

                // Restablecer todas las estrellas a color secundario
                stars.forEach(s => s.classList.remove('text-warning'));
                stars.forEach(s => s.classList.add('text-secondary', 'fa-beat'));

                // Cambiar el color de las estrellas seleccionadas
                for (let i = 0; i <= index; i++) {
                    stars[i].classList.remove('text-secondary');
                    stars[i].classList.add('text-warning', 'fa-beat');
                }

                priorityInput.value = value;
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#kt_datepicker1", {
            enableTime: true,
            dateFormat: "d/m/Y H:i",
            locale: {
                weekdays: {
                shorthand: ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'],
                longhand: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
                },
                months: {
                shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                },
            },
            minDate: 'today',
            onChange: function(selectedDates, dateStr, instance) {
                // Separar fecha y hora del string seleccionado
                const [date, time] = dateStr.split(' ');

                // Actualizar los campos de fecha y hora
                document.getElementById('fecha_inicio').value = date;
                document.getElementById('hora_inicio').value = time;
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#kt_datepicker2", {
            enableTime: true,
            dateFormat: "d/m/Y H:i",
            locale: {
                weekdays: {
                shorthand: ['Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa', 'Do'],
                longhand: ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'],
                },
                months: {
                shorthand: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Оct', 'Nov', 'Dic'],
                longhand: ['Enero', 'Febrero', 'Мarzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                },
            },
            minDate: 'today',
            onChange: function(selectedDates, dateStr, instance) {
                // Separar fecha y hora del string seleccionado
                const [date, time] = dateStr.split(' ');

                // Actualizar los campos de fecha y hora
                document.getElementById('fecha_fin').value = date;
                document.getElementById('hora_fin').value = time;
            }
        });
    });
</script>
