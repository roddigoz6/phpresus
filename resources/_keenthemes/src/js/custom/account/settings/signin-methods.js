"use strict";

// Class definition
var KTAccountSettingsSigninMethods = function () {
    var signInForm;
    var signInMainEl;
    var signInEditEl;
    var passwordMainEl;
    var passwordEditEl;
    var signInChangeEmail;
    var signInCancelEmail;
    var passwordChange;
    var passwordCancel;

    var toggleChangeEmail = function () {
        signInMainEl.classList.toggle('d-none');
        signInChangeEmail.classList.toggle('d-none');
        signInEditEl.classList.toggle('d-none');
    }

    var toggleChangePassword = function () {
        passwordMainEl.classList.toggle('d-none');
        passwordChange.classList.toggle('d-none');
        passwordEditEl.classList.toggle('d-none');
    }

    // Private functions
    var initSettings = function () {
        if (!signInMainEl) {
            return;
        }

        // toggle UI
        signInChangeEmail.querySelector('button').addEventListener('click', function () {
            toggleChangeEmail();
        });

        signInCancelEmail.addEventListener('click', function () {
            toggleChangeEmail();
        });

        passwordChange.querySelector('button').addEventListener('click', function () {
            toggleChangePassword();
        });

        passwordCancel.addEventListener('click', function () {
            toggleChangePassword();
        });
    }

    var handleChangeEmail = function (e) {
        var validation;

        if (!signInForm) {
            return;
        }

        validation = FormValidation.formValidation(
            signInForm,
            {
                fields: {
                    emailaddress: {
                        validators: {
                            notEmpty: {
                                message: 'El email es requerido.'
                            },
                            emailAddress: {
                                message: 'Email no válido.'
                            }
                        }
                    },

                    confirmemailpassword: {
                        validators: {
                            notEmpty: {
                                message: 'La contraseña es requerida.'
                            }
                        }
                    }
                },

                plugins: { //Learn more: https://formvalidation.io/guide/plugins
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
                }
            }
        );

        signInForm.querySelector('#kt_signin_submit').addEventListener('click', function (e) {
            e.preventDefault();
            console.log('click');

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    swal.fire({
                        text: "Recuperación enviada. Por favor revisa tu email.",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "¡Ok!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    }).then(function(){
                        signInForm.reset();
                        validation.resetForm(); // Reset formvalidation --- more info: https://formvalidation.io/guide/api/reset-form/
                        toggleChangeEmail();
                    });
                } else {
                    swal.fire({
                        text: "Oops, hubo un error. Inténtalo de nuevo.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "¡Ok!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    });
                }
            });
        });
    }

    var handleChangePassword = function (e) {
        var validation;

        // form elements
        var passwordForm = document.getElementById('kt_signin_change_password');

        if (!passwordForm) {
            return;
        }

        validation = FormValidation.formValidation(
            passwordForm,
            {
                fields: {
                    currentpassword: {
                        validators: {
                            notEmpty: {
                                message: 'La contraseña actual es requerida.'
                            }
                        }
                    },

                    newpassword: {
                        validators: {
                            notEmpty: {
                                message: 'La nueva contraseña es requerida.'
                            }
                        }
                    },

                    confirmpassword: {
                        validators: {
                            notEmpty: {
                                message: 'Es necesario confirmar tu contraseña.'
                            },
                            identical: {
                                compare: function() {
                                    return passwordForm.querySelector('[name="newpassword"]').value;
                                },
                                message: 'Las contraseñas no coinciden. Inténtalo de nuevo.'
                            }
                        }
                    },
                },

                plugins: { //Learn more: https://formvalidation.io/guide/plugins
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: '.fv-row'
                    })
                }
            }
        );

        passwordForm.querySelector('#kt_password_submit').addEventListener('click', function (e) {
            e.preventDefault();
            console.log('click');

            validation.validate().then(function (status) {
                if (status == 'Valid') {
                    swal.fire({
                        text: "Recuperación enviada. Por favor revisa tu email",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "¡Ok!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    }).then(function(){
                        passwordForm.reset();
                        validation.resetForm(); // Reset formvalidation --- more info: https://formvalidation.io/guide/api/reset-form/
                        toggleChangePassword();
                    });
                } else {
                    swal.fire({
                        text: "Oops, hubo un error. Inténtalo de nuevo.",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "¡Ok!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    });
                }
            });
        });
    }

    // Public methods
    return {
        init: function () {
            signInForm = document.getElementById('kt_signin_change_email');
            signInMainEl = document.getElementById('kt_signin_email');
            signInEditEl = document.getElementById('kt_signin_email_edit');
            passwordMainEl = document.getElementById('kt_signin_password');
            passwordEditEl = document.getElementById('kt_signin_password_edit');
            signInChangeEmail = document.getElementById('kt_signin_email_button');
            signInCancelEmail = document.getElementById('kt_signin_cancel');
            passwordChange = document.getElementById('kt_signin_password_button');
            passwordCancel = document.getElementById('kt_password_cancel');

            initSettings();
            handleChangeEmail();
            handleChangePassword();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    KTAccountSettingsSigninMethods.init();
});
