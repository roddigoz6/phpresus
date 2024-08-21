@section('title')
    Perfil de {{$user->name}}
@endsection

@php
    $bg = ['bg1.jpg', 'bg2.jpg', 'bg3.jpg', 'bg4.jpg', 'bg5.jpg', 'bg6.jpg', 'bg7.jpg', 'bg8.jpg', 'bg9.jpg'];
    $randbg=$bg[array_rand($bg)];
@endphp

<x-default-layout>
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center mt-6">
            <div class="col col-lg-6 mb-4 mb-lg-0">
                <div class="card" style="border-radius: .5rem;">
                    <div class="row g-0">

                        <div class="col-md-4 text-center" style="background-image: url('{{ asset("assets/media/auth/" . $randbg) }}'); background-size: cover; background-position: center; border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                        </div>
                        <div class="col-md-8">

                            <div class="card-body p-4">
                                <h6>Información</h6>
                                <hr class="mt-0 mb-4">

                                    <div id="userNameContainer" class=" row mb-3">
                                        <label for="userNameInput">Nombre</label>
                                        <h2 id="userNameDisplay">{{ $user->name }}</h2>
                                        <div id="userNameEdit" class="d-none">
                                            <input type="text" id="userNameInput" class="form-control" value="{{ $user->name }}">
                                            <button id="saveNameBtn" class="my-3 btn btn-light-primary">Guardar</button>
                                            <button id="cancelarNameBtn" class="btn btn-light-danger">Cancelar</button>
                                        </div>
                                    </div>

                                    <div id="userEmailContainer" class="row mb-3">
                                        <label for="userEmailInput">Email</label>
                                        <h3 id="userEmailDisplay">{{ $user->email }}</h3>
                                        <div id="userEmailEdit" class="d-none">
                                            <input type="email" id="userEmailInput" class="form-control" value="{{ $user->email }}">
                                            <button id="saveEmailBtn" class="my-3 btn btn-light-primary">Guardar</button>
                                            <button id="cancelarEmailBtn" class="btn btn-light-danger">Cancelar</button>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label>Creado en {{ $user->created_at->format('d/m/Y H:i') }}</label>
                                    </div>

                                <h6>Seguridad</h6>
                                <hr class="mt-0 mb-4">

                                <div class="row pt-1">
                                    <div class="col text-center">
                                        <a href="#" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                            Cambiar contraseña <i class="fa-solid fa-unlock-keyhole"></i></a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3">
                                        <p id="ultMod" class="text-muted">Última modificación {{$user->updated_at->format('d/m/Y H:i')}}</p>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para cambiar la contraseña -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Cambiar contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="changePasswordForm">
                    <div class="modal-body">

                        <div class="position-relative mb-3">
                            <input placeholder="Nueva contraseña" type="password" class="form-control bg-transparent" id="newPassword" name="password" autocomplete="off" required>
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility" id="toggleNewPassword">
                                <i class="bi bi-eye-slash fs-2"></i>
                                <i class="bi bi-eye fs-2 d-none"></i>
                            </span>
                        </div>

                        <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                            <div class="flex-grow-1 bg-secondary rounded h-5px me-2" id="meter-1"></div>
                            <div class="flex-grow-1 bg-secondary rounded h-5px me-2" id="meter-2"></div>
                            <div class="flex-grow-1 bg-secondary rounded h-5px me-2" id="meter-3"></div>
                            <div class="flex-grow-1 bg-secondary rounded h-5px" id="meter-4"></div>
                        </div>

                        <div class="text-muted">
                            Usa 8 o más caracteres combinando letras, números y símbolos.
                        </div>

                        <div class="position-relative mt-3">
                            <input placeholder="Confirmar contraseña" type="password" class="form-control" id="confirmPassword" name="password_confirmation" required>
                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility" id="toggleConfirmPassword">
                                <i class="bi bi-eye-slash fs-2"></i>
                                <i class="bi bi-eye fs-2 d-none"></i>
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-danger" data-bs-dismiss="modal">Cancelar</button>
                        <button id="guardarNuevaContra" type="submit" class="btn btn-light-primary" disabled>Guardar</button>
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
        document.addEventListener('DOMContentLoaded', function () {
            const nuevaContraInput = document.getElementById('newPassword');
            const confirmarContraInput = document.getElementById('confirmPassword');
            const verNuevaContra = document.querySelector('#toggleNewPassword .bi-eye-slash');
            const ocultarNuevaContra = document.querySelector('#toggleNewPassword .bi-eye');
            const verConfirmarContra = document.querySelector('#toggleConfirmPassword .bi-eye-slash');
            const ocultarConfirmarContra = document.querySelector('#toggleConfirmPassword .bi-eye');
            const medidor = document.querySelectorAll('[data-kt-password-meter-control="highlight"] > div');
            const btnGuardar = document.getElementById('guardarNuevaContra');

            verNuevaContra.addEventListener('click', function () {
                nuevaContraInput.type = 'text';
                verNuevaContra.classList.add('d-none');
                ocultarNuevaContra.classList.remove('d-none');
            });

            ocultarNuevaContra.addEventListener('click', function () {
                nuevaContraInput.type = 'password';
                ocultarNuevaContra.classList.add('d-none');
                verNuevaContra.classList.remove('d-none');
            });

            verConfirmarContra.addEventListener('click', function () {
                confirmarContraInput.type = 'text';
                verConfirmarContra.classList.add('d-none');
                ocultarConfirmarContra.classList.remove('d-none');
            });

            ocultarConfirmarContra.addEventListener('click', function () {
                confirmarContraInput.type = 'password';
                ocultarConfirmarContra.classList.add('d-none');
                verConfirmarContra.classList.remove('d-none');
            });

            function actualizerMed() {
                const password = nuevaContraInput.value;
                const hasUpperCase = /[A-Z]/.test(password);
                const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);
                const hasNumber = /[0-9]/.test(password);
                const isLongEnough = password.length >= 8;

                let complexity = 0;

                if (hasUpperCase) complexity++;
                if (hasSpecialChar) complexity++;
                if (hasNumber) complexity++;
                if (isLongEnough) complexity++;
                if (hasUpperCase && hasSpecialChar && hasNumber && isLongEnough) complexity++;

                medidor.forEach((div, index) => {
                    if (index < complexity) {
                        div.classList.remove('bg-secondary');
                        div.classList.add('bg-success');
                    } else {
                        div.classList.remove('bg-success');
                        div.classList.add('bg-secondary');
                    }
                });

                btnGuardar.disabled = complexity < 3 || nuevaContraInput.value !== confirmarContraInput.value;
            }

            nuevaContraInput.addEventListener('input', actualizerMed);
            confirmarContraInput.addEventListener('input', actualizerMed);

        });

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
                    type: "POST",
                    data: {
                        _method: "PUT",
                        _token: "{{ csrf_token() }}",
                        name: updatedName
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: response.message,
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        $('#userNameDisplay').text(updatedName).removeClass('d-none');
                        $('#userNameEdit').addClass('d-none');
                        $('#userNameDisplay').removeClass('d-none');
                        actualizarUltMod();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: 'Error al validar. Inténtalo de nuevo.',
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                });
            });

            // Guardar email
            $('#saveEmailBtn').on('click', function() {
                var updatedEmail = $('#userEmailInput').val();
                $.ajax({
                    url: "{{ route('user.update', $user->id) }}",
                    type: "POST",
                    data: {
                        _method: "PUT",
                        _token: "{{ csrf_token() }}",
                        email: updatedEmail
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: response.message,
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        $('#userEmailDisplay').text(updatedEmail).removeClass('d-none');
                        $('#userEmailEdit').addClass('d-none');
                        $('#userEmailDisplay').removeClass('d-none');
                        actualizarUltMod();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: 'Error al validar. Inténtalo de nuevo.',
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                });
            });

            // Guardar contraseña
            $('#changePasswordForm').on('submit', function(e) {
                e.preventDefault(); // Evitar el envío normal del formulario
                $.ajax({
                    url: "{{ route('user.update', $user->id) }}",
                    type: "POST",
                    data: $(this).serialize() + '&_method=PUT',
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: response.message,
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        $('#changePasswordModal').modal('hide');
                        actualizarUltMod();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: 'Error al validar. Inténtalo de nuevo.',
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                });
            });

            // Cancelar edición de nombre
            $('#cancelarNameBtn').on('click', function() {
                $('#userNameInput').val($('#userNameDisplay').text());
                $('#userNameEdit').addClass('d-none');
                $('#userNameDisplay').removeClass('d-none');
            });

            // Cancelar edición de email
            $('#cancelarEmailBtn').on('click', function() {
                $('#userEmailInput').val($('#userEmailDisplay').text());
                $('#userEmailEdit').addClass('d-none');
                $('#userEmailDisplay').removeClass('d-none');
            });

            function actualizarUltMod() {
                $.ajax({
                    url: "{{ route('user.getUltimaModif', $user->id) }}",
                    type: "GET",
                    success: function(response) {
                        $('#ultMod').text('Última modificación ' + response.updated_at);
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: 'Error al obtener la fecha de la última modificación.',
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                    }
                });
            }
        });
    </script>
    @endpush
</x-default-layout>
