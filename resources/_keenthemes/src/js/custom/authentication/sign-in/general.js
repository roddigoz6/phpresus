"use strict";

// Definición de la clase
var KTSigninGeneral = function () {
    // Elementos
    var form;
    var submitButton;
    var validator;

    // Manejar validación del formulario
    var handleValidation = function (e) {
        // Inicializar reglas de validación del formulario. Para más información, consulta la documentación oficial del plugin FormValidation: https://formvalidation.io/
        validator = FormValidation.formValidation(
            form,
            {
                fields: {
                    'email': {
                        validators: {
                            regexp: {
                                regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
                                message: 'El valor no es una dirección de correo electrónico válida',
                            },
                            notEmpty: {
                                message: 'El correo electrónico es obligatorio'
                            }
                        }
                    },
                    'password': {
                        validators: {
                            notEmpty: {
                                message: 'La contraseña es obligatoria'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row',
                        eleInvalidClass: '',  // comente para habilitar iconos de estado inválido
                        eleValidClass: '' // comente para habilitar iconos de estado válido
                    })
                }
            }
        );
    }

    var handleSubmitDemo = function (e) {
        // Manejar envío del formulario
        submitButton.addEventListener('click', function (e) {
            // Prevenir acción predeterminada del botón
            e.preventDefault();

            // Validar formulario
            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    // Mostrar indicador de carga
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Deshabilitar el botón para evitar múltiples clics
                    submitButton.disabled = true;

                    // Simular petición AJAX
                    setTimeout(function () {
                        // Ocultar indicador de carga
                        submitButton.removeAttribute('data-kt-indicator');

                        // Habilitar el botón
                        submitButton.disabled = false;

                        // Mostrar mensaje emergente. Para más información, consulta la documentación oficial del plugin: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "¡Bienvenido!",
                            icon: "success",
                            buttonsStyling: false,
                            confirmButtonText: "¡Ok!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                form.querySelector('[name="email"]').value = "";
                                form.querySelector('[name="password"]').value = "";

                                //form.submit(); // enviar formulario
                                var redirectUrl = form.getAttribute('data-kt-redirect-url');
                                if (redirectUrl) {
                                    location.href = redirectUrl;
                                }
                            }
                        });
                    }, 2000);
                } else {
                    // Mostrar mensaje de error emergente. Para más información, consulta la documentación oficial del plugin: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Oops, parece que hay errores, inténtalo de nuevo.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "¡Ok!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });
    }

    var handleSubmitAjax = function (e) {
        // Manejar envío del formulario
        submitButton.addEventListener('click', function (e) {
            // Prevenir acción predeterminada del botón
            e.preventDefault();

            // Validar formulario
            validator.validate().then(function (status) {
                if (status == 'Valid') {
                    // Mostrar indicador de carga
                    submitButton.setAttribute('data-kt-indicator', 'on');

                    // Deshabilitar el botón para evitar múltiples clics
                    submitButton.disabled = true;

                    // Consulta la documentación de la librería axios: https://axios-http.com/docs/intro
                    axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form)).then(function (response) {
                        if (response) {
                            form.reset();

                            // Mostrar mensaje emergente. Para más información, consulta la documentación oficial del plugin: https://sweetalert2.github.io/
                            Swal.fire({
                                text: "¡Bienvenido!",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "¡Ok!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });

                            const redirectUrl = form.getAttribute('data-kt-redirect-url');

                            if (redirectUrl) {
                                location.href = redirectUrl;
                            }
                        } else {
                            // Mostrar mensaje de error emergente. Para más información, consulta la documentación oficial del plugin: https://sweetalert2.github.io/
                            Swal.fire({
                                text: "Oops, el correo electrónico o la contraseña son incorrectos, inténtalo de nuevo.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "¡Ok!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    }).catch(function (error) {
                        Swal.fire({
                            text: "Oops, parece que hay errores, inténtalo de nuevo.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "¡Ok!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }).then(() => {
                        // Ocultar indicador de carga
                        submitButton.removeAttribute('data-kt-indicator');

                        // Habilitar botón
                        submitButton.disabled = false;
                    });
                } else {
                    // Mostrar mensaje de error emergente. Para más información, consulta la documentación oficial del plugin: https://sweetalert2.github.io/
                    Swal.fire({
                        text: "Oops, parece que hay errores, inténtalo de nuevo.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "¡Ok!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        });
    }

    var isValidUrl = function(url) {
        try {
            new URL(url);
            return true;
        } catch (e) {
            return false;
        }
    }

    // Funciones públicas
    return {
        // Inicialización
        init: function () {
            form = document.querySelector('#kt_sign_in_form');
            submitButton = document.querySelector('#kt_sign_in_submit');

            handleValidation();

            if (isValidUrl(submitButton.closest('form').getAttribute('action'))) {
                handleSubmitAjax(); // usar para envío ajax
            } else {
                handleSubmitDemo(); // usado solo para propósitos de demostración
            }
        }
    };
}();

// Cuando el documento esté listo
KTUtil.onDOMContentLoaded(function () {
    KTSigninGeneral.init();
});
