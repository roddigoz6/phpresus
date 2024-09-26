<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {!! printHtmlAttributes('html') !!}>
<!--begin::Head-->
<head>
    <base href=""/>
    <title>{{ config('app.name', 'Kasier') }} - @yield('title', '')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content=""/>
    <link rel="canonical" href="{{ url()->current() }}"/>

    {!! includeFavicon() !!}

    <!--begin::Fonts-->
    {!! includeFonts() !!}
    <!--end::Fonts-->

    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    @foreach(getGlobalAssets('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Vendor Stylesheets(used by this page)-->
    @foreach(getVendors('css') as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Vendor Stylesheets-->

    <!--begin::Custom Stylesheets(optional)-->
    @foreach(getCustomCss() as $path)
        {!! sprintf('<link rel="stylesheet" href="%s">', asset($path)) !!}
    @endforeach
    <!--end::Custom Stylesheets-->

    @livewireStyles
    <style>
        .rounded-table {
            border-radius: 15px;
            overflow: hidden;
        }

        /*
        .modal-content{
            backdrop-filter: blur(5px)!important ;
            background-color: rgba(255, 255, 255, 0.7) !important;
        }

        .modal{
            backdrop-filter: blur(5px)!important ;
            background-color: rgba(255, 255, 255, 0.2) !important;
        }
        */

        .btn > i {
            padding-right: 0 !important;
        }

        .element-id {
            background-color: #C5B3E6;
            color: #6f42c1;
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
        }
        .element-id:hover{
            background-color: #6f42c1;
            color:#fff;
        }
        .header-modal
        {
            margin: 5px;
            border-bottom:1px solid black;
        }
        #clientesChart {
            width: 75px;
            height: 75px;
        }
        @media (max-width: 576px) {
            .agregar {
                display: table-cell;
            }
        }

        @media (min-width: 577px) {
            .agregar {
                display: none;
            }
        }
    </style>
</head>
<!--end::Head-->

<!--begin::Body-->
<body {!! printHtmlClasses('body') !!} {!! printHtmlAttributes('body') !!}>

@include('partials/theme-mode/_init')

@yield('content')
<!-- Modal -->
<div class="modal fade" id="clienteModal" aria-labelledby="clienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clienteModalLabel">Nuevo proyecto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="createProyectoForm" method="post" action="{{route('proyecto.store')}}">
            @csrf
            <div class="modal-body">

                <button type="button" class="btn btn-light-primary text-start" id="clienteNuevoBtn">Cliente nuevo <span class="menu-icon"><i class="fa-solid fa-user-plus"></i></span></button>

                <button type="button" class="btn btn-light-info text-end" id="clienteExistenteBtn">Cliente existente <i class="fa-solid fa-user-check"></i></button>

                <div class="form-group mt-6" id="clienteSelectContainer" style="display: none;">
                    <div class="row">
                        <div class="col me-auto">
                            <select data-dropdown-parent="#clienteModalLabel" id="clienteSelectMaster" name="cliente_id" id="cliente_id" class="form-control">
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-6" id="clienteNuevoContainer" style="display: none;">
                    <div class="row">
                        <div class="col me-auto" id="clienteNuevoBtn">
                            <div class="row">
                                <div class="col">
                                    <div class="header-modal">
                                        <h4>Datos del cliente</h4>
                                        <input type="hidden" name="context" value="form">
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="">
                                                <label for="nombre">Nombre</label> <strong class="required"></strong>
                                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="">
                                                <label for="apellido">Apellido</label> <strong class="required"></strong>
                                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="">
                                                <label for="dni">DNI</label> <strong class="required"></strong>
                                                <input type="text" class="form-control" id="dni" name="dni" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <label for="movil">Móvil</label> <strong class="required"></strong>
                                                <input type="text" class="form-control" id="movil" name="movil" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <label for="email">Correo Electrónico</label>
                                        <input type="email" class="form-control" id="email" name="email">
                                    </div>
                                    <div class="">
                                        <label for="direccion">Direccion</label> <strong class="required"></strong>
                                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                                    </div>
                                    <div class="">
                                        <label for="cp">Código postal</label> <strong class="required"></strong>
                                        <input type="text" class="form-control" id="cp" name="cp" required>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="">
                                                <label for="poblacion">Población</label> <strong class="required"></strong>
                                                <input type="text" class="form-control" id="poblacion" name="poblacion" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="">
                                                <label for="provincia">Provincia</label> <strong class="required"></strong>
                                                <input type="text" class="form-control" id="provincia" name="provincia" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="">
                                                <label for="fax">Fax</label>
                                                <input type="text" class="form-control" id="fax" name="fax">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <label for="cargo">Cargo</label>
                                                <input type="text" class="form-control" id="cargo" name="cargo">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="header-modal">
                                        <h4>Datos de envío</h4>
                                    </div>
                                    <div class="">
                                        <label for="contacto">Contacto</label>
                                        <input type="text" class="form-control" id="contacto" name="contacto">
                                    </div>
                                    <div class="">
                                        <label for="titular_nom">Nombre de titular</label>
                                        <input type="text" class="form-control" id="titular_nom" name="titular_nom">
                                    </div>
                                    <div class="">
                                        <label for="titular_ape">Apellido de titular</label>
                                        <input type="text" class="form-control" id="titular_ape" name="titular_ape">
                                    </div>
                                    <div class="">
                                        <label for="direccion_envio">Dirección de envío</label>
                                        <input type="text" class="form-control" id="direccion_envio" name="direccion_envio">
                                    </div>
                                    <div class="">
                                        <label for="cp_envio">Código postal de dirección de envío</label>
                                        <input type="text" class="form-control" id="cp_envio" name="cp_envio">
                                    </div>
                                    <div class="">
                                        <label for="poblacion_envio">Población de dirección de envío</label>
                                        <input type="text" class="form-control" id="poblacion_envio" name="poblacion_envio">
                                    </div>
                                    <div class="">
                                        <label for="provincia_envio">Provincia de dirección de envío</label>
                                        <input type="text" class="form-control" id="provincia_envio" name="provincia_envio">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mt-6">
                    <div class="col">
                        <div class="row">
                            <div class="col">
                                <label for="serie_ref">Nombre del proyecto</label>
                                <input class="form-control" type="text" name="serie_ref" id="serie_ref" placeholder="987654321E">
                            </div>

                            <div class="col col-auto">
                                <label for="num_ref">Número de referencia del proyecto</label>
                                <input class="form-control" type="text" placeholder="" value="{{ $proyectoNum }}" disabled>
                                <input type="hidden" name="num_ref" id="num_ref" value="{{$proyectoNum}}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="pago">Forma de pago</label>
                                <select class="form-select" id="pago" name="pago">
                                    <option value="Ver condiciones">Ver condiciones</option>
                                    <option value="50% inicio, 50% fin">50% inicio, 50% fin</option>
                                    <option value="50% termino de obra, resto a 90 dias">50% termino de obra, resto a 90 días</option>
                                    <option value="50% comienzo de obra, resto a convenir">50% comienzo de obra, resto a convenir</option>
                                    <option value="Certificaciones quincenales">Certificaciones quincenales</option>
                                    <option value="Como siempre">Como siempre</option>
                                    <option value="Contado termino de obra">Contado termino de obra</option>
                                    <option value="Convenir">Convenir</option>
                                    <option value="Fin de ejercicio, 15 de diciembre">Fin de ejercicio, 15 de diciembre</option>
                                    <option value="Letra de 90 dias">Letra de 90 días</option>
                                    <option value="Letra a la vista">Letra a la vista</option>
                                </select>
                            </div>

                            <div class="col col-auto">
                                <label for="iva">IVA</label>
                                <select class="form-select" id="iva" name="iva">
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="10">10</option>
                                    <option value="16">16</option>
                                    <option value="18">18</option>
                                    <option value="21">21</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="">
                    <button type="button" class="btn btn-light-primary" id="crearProyecto">Crear proyecto <i class="fa-solid fa-arrow-right"></i></button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
@foreach(getGlobalAssets() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Global Javascript Bundle-->

<!--begin::Vendors Javascript(used by this page)-->
@foreach(getVendors('js') as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Vendors Javascript-->

<!--begin::Custom Javascript(optional)-->
@foreach(getCustomJs() as $path)
    {!! sprintf('<script src="%s"></script>', asset($path)) !!}
@endforeach
<!--end::Custom Javascript-->
<!--end::Javascript-->
<script>
    $(document).ready(function() {
        $('.btn').on('click', function() {
            $(this).removeClass('active');
        });
    });

    document.addEventListener('livewire:init', () => {
        Livewire.on('success', (message) => {
            toastr.success(message);
        });
        Livewire.on('error', (message) => {
            toastr.error(message);
        });

        Livewire.on('swal', (message, icon, confirmButtonText) => {
            if (typeof icon === 'undefined') {
                icon = 'success';
            }
            if (typeof confirmButtonText === 'undefined') {
                confirmButtonText = '¡Ok!';
            }
            Swal.fire({
                text: message,
                icon: icon,
                buttonsStyling: false,
                confirmButtonText: confirmButtonText,
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
    document.addEventListener('submit', function(e) {
        if (e.target && e.target.id === 'createClientForm') {
            e.preventDefault();

            const formData = new FormData(e.target);
            fetch(e.target.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-Token': formData.get('_token')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.id) {
                    const createProyecto = "{{ route('proyecto.store') }}";
                    const clienteId = data.id;

                    window.location.href = `${createProyecto}?cliente_id=${clienteId}`;

                    document.getElementById('createClientForm').reset();
                    const clienteModal = bootstrap.Modal.getInstance(document.getElementById('crearClienteModal'));
                    clienteModal.hide();
                } else {
                    alert('Error al crear el cliente. Por favor, inténtalo de nuevo.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ocurrió un error. Por favor, inténtalo de nuevo.');
            });
        }
    });
});

$(document).ready(function() {
    function initializeSelect2() {
        $('#clienteSelectMaster').select2({
            placeholder: 'Seleccionar cliente',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return 'No se encontraron clientes con ese nombre';
                }
            }
        });
    }

    initializeSelect2();

    // Mostrar el contenedor de selección de cliente existente
    $('#clienteExistenteBtn').on('click', function() {
        $('#clienteSelectContainer').slideDown();
        $('#clienteNuevoContainer').slideUp();

        $.ajax({
            url: '{{ route("clientes.data") }}',
            method: 'GET',
            success: function(data) {
                $('#clienteSelectMaster').empty();
                $('#clienteSelectMaster').select2({
                    placeholder: 'Seleccionar cliente',
                    allowClear: true,
                    width: '100%',
                    language: {
                        noResults: function() {
                            return 'No se encontraron clientes con ese nombre';
                        }
                    }
                }).append(
                    $.map(data, function(cliente) {
                        return new Option(cliente.text, cliente.id, false, false);
                    })
                );
                $('#clienteSelectMaster').val(null).trigger('change');
            },
            error: function(error) {
                console.error('Error al cargar los clientes:', error);
            }
        });
    });

     // Mostrar el formulario de creación de cliente nuevo
     $('#clienteNuevoBtn').on('click', function() {
        $('#clienteSelectContainer').slideUp();
        $('#clienteNuevoContainer').slideDown();
    });

    $('#crearProyecto').on('click', function() {
        const isClienteSelectVisible = $('#clienteSelectMaster').is(':visible');
        const clienteId = isClienteSelectVisible ? $('#clienteSelectMaster').val() : null;
        const serieRef = $('#serie_ref').val();
        const numRef = $('#num_ref').val();
        const pago = $('#pago').val();

        const createProyecto = "{{ route('proyecto.store') }}";

        // Si se selecciona un cliente existente
        if (isClienteSelectVisible && clienteId) {
            $.ajax({
                url: createProyecto,
                method: 'POST',
                data: {
                    cliente_id: clienteId,
                    serie_ref: serieRef,
                    num_ref: numRef,
                    pago: pago,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.success) {
                        window.location.href = "{{ route('proyecto.index') }}";
                    } else {
                        alert(data.message || 'Error al crear el proyecto.');
                    }
                },
                error: function(error) {
                    console.error('Error al crear el proyecto:', error);
                }
            });
        } else {

            const nombreCli = $('#nombre').val();
            const apellidoCli = $('#apellido').val();
            const dni = $('#dni').val();
            const email = $('#email').val();
            const movil = $('#movil').val();
            const contacto = $('#contacto').val();
            const direccion = $('#direccion').val();
            const cp = $('#cp').val();
            const poblacion = $('#poblacion').val();
            const provincia = $('#provincia').val();
            const fax = $('#fax').val();
            const cargo = $('#cargo').val();
            const titularNom = $('#titular_nom').val();
            const titularApe = $('#titular_ape').val();
            const direccionEnvio = $('#direccion_envio').val();
            const cpEnvio = $('#cp_envio').val();
            const poblacionEnvio = $('#poblacion_envio').val();
            const provinciaEnvio = $('#provincia_envio').val();

            $.ajax({
                url: createProyecto,
                method: 'POST',
                data: {
                    nombre: nombreCli,
                    apellido: apellidoCli,
                    dni: dni,
                    email: email,
                    movil: movil,
                    contacto: contacto,
                    direccion: direccion,
                    cp: cp,
                    poblacion: poblacion,
                    provincia: provincia,
                    fax: fax,
                    cargo: cargo,
                    titular_nom: titularNom,
                    titular_ape: titularApe,
                    direccion_envio: direccionEnvio,
                    cp_envio: cpEnvio,
                    poblacion_envio: poblacionEnvio,
                    provincia_envio: provinciaEnvio,
                    serie_ref: serieRef,
                    num_ref: numRef,
                    pago: pago,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.success) {
                        window.location.href = "{{ route('proyecto.index') }}";
                    } else {
                        alert(data.message || 'Error al crear el proyecto.');
                    }
                },
                error: function(error) {
                    console.error('Error al crear el proyecto:', error);
                }
            });
        }
    });
});

</script>

@livewireScripts

@stack('scripts')

<!--end::Body-->
</html>
