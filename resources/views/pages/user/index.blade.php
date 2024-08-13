<x-default-layout>
    <div class="container" style="background-image: url({{ asset('assets/media/auth/membership-dark.png') }}); background-size: cover; background-position: center;">
        <div class="row my-3 align-items-center">
            <div class="col text-start">
                <!-- Datos del usuario con inputs para ser editados -->
                <div id="userNameContainer" class="mb-3">
                    <label for="userNameInput">Nombre</label>
                    <h2 id="userNameDisplay">{{ $user->name }}</h2>
                    <div id="userNameEdit" class="d-none">
                        <input type="text" id="userNameInput" class="form-control" value="{{ $user->name }}">
                        <button id="saveNameBtn" class="my-3 btn btn-light-primary">Guardar</button>
                        <button id="cancelarNameBtn" class="btn btn-light-danger">Cancelar</button>
                    </div>
                </div>

                <div id="userEmailContainer" class="mb-3">
                    <label for="userEmailInput">Email</label>
                    <p id="userEmailDisplay">{{ $user->email }}</p>
                    <div id="userEmailEdit" class="d-none">
                        <input type="email" id="userEmailInput" class="form-control" value="{{ $user->email }}">
                        <button id="saveEmailBtn" class="my-3 btn btn-light-primary">Guardar</button>
                        <button id="cancelarEmailBtn" class="btn btn-light-danger">Cancelar</button>
                    </div>
                </div>
            </div>
            <div class="col text-end">
                <a href="#" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                    Cambiar contraseña <i class="fa-solid fa-unlock-keyhole"></i></a>
            </div>
        </div>
    </div>

    <!-- Modal para cambiar la contraseña -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Cambiar contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="changePasswordForm" method="POST" action="{{ route('user.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Nueva contraseña</label>
                            <input type="password" class="form-control" id="newPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirmar contraseña</label>
                            <input type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-light-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('update_user'))
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "success",
            title: "{{ session('update_user') }}"
        });
    });
    </script>
    @endif

    @if (session('update_user_fail'))
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "error",
            title: "{{ session('update_user_fail') }}"
        });
    });
    </script>
    @endif

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Mostrar inputs al hacer clic en el nombre
            $('#userNameDisplay').on('click', function() {
                $('#userNameContainer').find('#userNameEdit').removeClass('d-none');
                $(this).addClass('d-none');
            });

            // Mostrar inputs al hacer clic en el email
            $('#userEmailDisplay').on('click', function() {
                $('#userEmailContainer').find('#userEmailEdit').removeClass('d-none');
                $(this).addClass('d-none');
            });

            // Guardar nombre
            $('#saveNameBtn').on('click', function() {
                var updatedName = $('#userNameInput').val();
                $.ajax({
                    url: "{{ route('user.update', $user->id) }}",
                    method: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        name: updatedName
                    },
                    success: function(response) {
                        alert('Nombre actualizado correctamente.');
                    },
                    error: function(xhr) {
                        alert('Hubo un error al actualizar el nombre.');
                    }
                });
            });

            // Guardar email
            $('#saveEmailBtn').on('click', function() {
                var updatedEmail = $('#userEmailInput').val();
                $.ajax({
                    url: "{{ route('user.update', $user->id) }}",
                    method: "PUT",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: updatedEmail
                    },
                    success: function(response) {
                        alert('Correo Electrónico actualizado correctamente.');
                    },
                    error: function(xhr) {
                        alert('Hubo un error al actualizar el correo electrónico.');
                    }
                });
            });

            $('#cancelarNameBtn').on('click', function(){
                $('#userNameInput').val($('#userNameDisplay').text());
                $('#userNameEdit').addClass('d-none');
                $('#userNameDisplay').removeClass('d-none');
            });

            $('#cancelarEmailBtn').on('click', function(){
                $('#userEmailInput').val($('#userEmailDisplay').text());
                $('#userEmailEdit').addClass('d-none');
                $('#userEmailDisplay').removeClass('d-none');
            });
        });
    </script>
    @endpush
</x-default-layout>
