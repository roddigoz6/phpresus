<x-default-layout>
    @section('title')
    Información del sistema
    @endsection
<div class="container">
    <div class="row my-3 align-items-center">
        <div class="col text-start">
            <h2>Información del sistema</h2>
            <p>Actualizaciones - Módulos - Log</p>
        </div>
    </div>

    <div>
        <label for="">Actualizaciones</label>
        <div class="table-responsive">
            <table class="table text-center table-hovered rounded-table">
                <thead>
                    <tr class="bg-secondary">
                        <th>Estado</th>
                        <th>Fecha</th>
                        <th>Versión</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><span class="badge badge-success">INSTALADO</span></td>
                        <td>09/10/2024</td>
                        <td>1.0</td>
                        <td><button class="btn btn-sm btn-icon btn-light-primary"><i class="fa-solid fa-arrows-rotate"></i></button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <label for="">Módulos</label>
        <div class="table-responsive">
            <table class="table text-center table-hovered rounded-table">
                <thead>
                    <tr class="bg-secondary">
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="align-middle">
                            <img alt="Logo" src="{{ image('logos/TBAI-G-.png') }}" class="h-60px h-lg-75px"/>
                            <span class="badge badge-success" data-b-toggle="popover" data-bs-trigger="hover" title="Activo">TICKETBAI</span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-icon btn-light-info"><i class="fa-solid fa-wrench"></i></button>
                            <button class="btn btn-sm btn-icon btn-light-primary"><i class="fa-solid fa-arrows-rotate"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <label for="">Logs de acceso</label>
        <div class="table-responsive">
            <table class="table text-center table-hovered rounded-table">
                <thead>
                    <tr class="bg-secondary">
                        <th>ID</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Fecha</th>
                        <th>IP</th>
                        <th>Browser</th>
                        <th>Server Name</th>
                        <th>Remote Host</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td><span class="badge badge-info">{{ $log->accion['nombre_usuario'] ?? 'Desconocido' }}</span></td>
                        <td>{{ $log->accion['email_usuario'] ?? 'No disponible' }}</td>
                        <td>{{ $log->accion['fecha'] ?? 'No disponible' }}</td>
                        <td>{{ $log->accion['ip'] ?? 'No disponible' }}</td>
                        <td>{{ $log->accion['browser'] ?? 'No disponible' }}</td>
                        <td>{{ $log->accion['server_name'] ?? 'No disponible' }}</td>
                        <td>{{ $log->accion['remote_host'] ?? 'No disponible' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

</x-default-layout>
