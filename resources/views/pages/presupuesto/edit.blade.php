<x-default-layout>
@section('title')
    Editar presupuesto
@endsection

<div class="container mt-3">
    <div class="row">
        <div class="col-md-4">
            <div class="row align-items-center mb-3">
                <div class="col">
                    <h3 class="mb-0">Productos</h3>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#crearProductoModal" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Crear un nuevo producto y agregar a la lista">
                        Nuevo producto <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
            </div>

            <div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form action="{{ route('producto.store') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="crearProductoModalLabel">Nuevo producto</h5>
                                </div>
                                <div class="">
                                    <label for="nombre">Nombre del Producto</label> <strong class="required"></strong>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="">
                                    <label for="precio">Precio</label> <strong class="required"></strong>
                                    <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01" required>
                                </div>
                                <div class="">
                                    <label for="descripcion">Descripción</label>
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                                </div>
                                <div class="">
                                    <label for="stock">Stock</label> <strong class="required"></strong>
                                    <input type="number" class="form-control" id="stock" name="stock" min="0" required>
                                </div>
                                <div class="">
                                    <label for="tipo">Tipo</label> <strong class="required"></strong>
                                    <select class="form-select" id="tipo" name="tipo" required>
                                        <option value="Artículo">Artículo</option>
                                        <option value="Visita">Visita</option>
                                    </select>
                                </div>
                                <div class="mt-3">Los campos con <strong class="required"></strong> son requeridos.</div>
                                <button type="submit" class="btn btn-primary mt-3" id="CreaProd">Ingresar nuevo producto</button>
                            </form>
                            @if (session('success_prod'))
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
                                            title: "Producto agregado."
                                        });
                                    });
                                </script>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('presupuesto.getProductos') }}" id="search-form" class="d-flex">
                <div class="input-group mb-3">
                    <input type="text" name="search" id="search-input" class="form-control" placeholder="Buscar productos..." value="{{ request('search') }}">
                    <div class="input-group-append">
                    <button class="btn btn-light-primary mx-3" id="search-button" type="button" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Buscar producto por nombre">
                        <i class="fas fa-search"></i>
                    </button>
                    </div>
                    <input type="hidden" name="order" id="order-input" value="{{ $order ?? 'asc' }}">
                    <button type="button" id="orderButton" class="nav-link ms-2 d-flex align-items-center" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Ordenar productos por nombre">
                        <i class="fa-solid fa-up-down"></i>
                    </button>
                    <input type="hidden" name="precio_order" id="precio_order-input" value="{{ $precio_order ?? 'asc' }}">
                    <button type="button" id="precioButton" class="nav-link ms-2 d-flex align-items-center" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Ordenar productos por precio">
                        <i class="fa-solid fa-euro-sign"></i>
                    </button>
                </div>
            </form>
            <div id="productos-container">
            </div>
        </div>

        <div class="col-md-8">

            <form action="{{ route('presupuesto.update', $presupuesto->id) }}" method="POST" class="mb-3">
                @csrf
                @method('PUT')
                <div class="row">
                    <h3>Editar proyecto {{ $proyecto->proyecto_id }}, cliente <strong id="cliente_nombre_proyecto"> {{ $presupuesto->cliente->nombre }} </strong>.</h3>
                </div>

                <div class="row mb-3">
                    <div class="col col-me">
                        <div class="form-group">
                            <div class="row">
                                <select id="clienteSelectEdit" name="cliente" class="form-control">
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col col-auto">
                        <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#crearClienteModalEdit" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Crear nuevo cliente">
                           Nuevo cliente <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                </div>

                <div class="row form-group">

                    <div class="col form-group">
                        <p class="mb-0">Datos del cliente</p>
                        Cliente: <strong id="cliente_nombre">{{ $presupuesto->cliente->nombre }} {{ $presupuesto->cliente->apellido }}</strong>
                        <input type="hidden" value="{{ $presupuesto->cliente->id }}" id="cliente_id" name="cliente_id">
                    </div>

                    <div class="col form-group">
                        Contacto: <strong id="cliente_contacto">{{ $presupuesto->cliente->contacto ?: 'No registrado' }}</strong><br>
                        Forma de pago de cliente: <strong id="cliente_pago">{{ $presupuesto->cliente->pago ?: 'No registrado' }}</strong>
                    </div>
                </div>

                <div class="col">
                    <hr />
                    <p class="mb-0">Info del proyecto</p>

                    <div class="row">
                        <div class="col">
                            <input class="form-control" type="text" name="serie_ref" placeholder="Nombre del proyecto / serie de referencia" value="{{ $proyecto->serie_ref }}">
                        </div>

                        <div class="col">
                            <input class="form-control" type="text" name="num_ref" placeholder="Número de referencia" value="{{ $proyecto->num_ref }}">
                        </div>
                    </div>

                    <div>
                        <label for="pago">Forma de pago</label>
                            <select class="form-select" id="pago" name="pago">
                                <option value="Ver condiciones" {{ $proyecto->pago == 'Ver condiciones' ? 'selected' : '' }}>Ver condiciones</option>
                                <option value="50% inicio, 50% fin" {{ $proyecto->pago == '50% inicio, 50% fin' ? 'selected' : '' }}>50% inicio, 50% fin</option>
                                <option value="50% termino de obra, resto a 90 dias" {{ $proyecto->pago == '50% termino de obra, resto a 90 días' ? 'selected' : '' }}>50% termino de obra, resto a 90 días</option>
                                <option value="50% comienzo de obra, resto a convenir" {{ $proyecto->pago == '50% comienzo de obra, resto a convenir' ? 'selected' : '' }}>50% comienzo de obra, resto a convenir</option>
                                <option value="Certificaciones quincenales" {{ $proyecto->pago == 'Certificaciones quincenales' ? 'selected' : '' }}>Certificaciones quincenales</option>
                                <option value="Como siempre" {{ $proyecto->pago == 'Como siempre' ? 'selected' : '' }}>Como siempre</option>
                                <option value="Contado termino de obra" {{ $proyecto->pago == 'Contado termino de obra' ? 'selected' : '' }}>Contado termino de obra</option>
                                <option value="Convenir" {{ $proyecto->pago == 'Convenir' ? 'selected' : '' }}>Convenir</option>
                                <option value="Fin de ejercicio, 15 de diciembre" {{ $proyecto->pago == 'Fin de ejercicio, 15 de diciembre' ? 'selected' : '' }}>Fin de ejercicio, 15 de diciembre</option>
                                <option value="Letra de 90 dias" {{ $proyecto->pago == 'Letra de 90 días' ? 'selected' : '' }}>Letra de 90 días</option>
                                <option value="Letra a la vista" {{ $proyecto->pago == 'Letra a la vista' ? 'selected' : '' }}>Letra a la vista</option>
                            </select>
                    </div>
                    <hr />
                </div>

                <p>Arrastra aquí los productos para agregarlos al presupuesto.</p>

                <div id="canvas" class="border p-2" style="min-height: 300px; overflow-y: auto;"
                    ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div id="lista-presupuesto" class="table-responsive">
                        <table class="table table-light text-center table-hover rounded-table">
                            <thead class="table-dark">
                                <tr>
                                    <th class="icon-table">Nombre</th>
                                    <th class="icon-table">Descripción</th>
                                    <th class="icon-table">Cantidad</th>
                                    <th class="icon-table">Precio x Unidad</th>
                                    <th class="icon-table">Precio</th>
                                    <th class="icon-table"></th>
                                </tr>
                            </thead>
                            <tbody id="productos-table-body" class="list">
                            </tbody>
                        </table>
                    </div>
                </div>

                <label for="total">Total:</label>
                <h3 id="precio_total_display">0.00</h3>

                <input type="hidden" id="precio_total_input" name="precio_total" value="0.00">
                <input type="hidden" id="lista_productos" name="lista_productos" value="">
                <div class="row mb-3">
                    <div class="col col-auto me-auto">
                        <div class="btn-container d-flex gap-2">
                            <button type="submit" class="btn btn-light-primary">
                                Actualizar <i class="fas fa-check-circle"></i>
                            </button>
                            <button id="agregarCap" type="button" class="btn btn-light-success">
                                Agregar capítulo <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col col-auto">
                        <button type="button" class="btn btn-light-danger" id="limpiarCanvas" data-bs-toggle="popover"
                            data-bs-trigger="hover focus" title="Quitar todos los productos de la lista.">Quitar
                            todos <i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </form>

            @if (session('success_pres'))
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
                            title: "Presupuesto guardado."
                        });
                    });
                </script>
            @endif
        </div>
    </div>
</div>

<!-- Capítulos -->
<div class="modal fade" id="capituloModal" tabindex="-1" aria-labelledby="capituloModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="capituloModalLabel">Agregar Capítulo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col me-auto">
                        <input type="text" class="form-control" id="capituloTitulo" placeholder="Ingrese el título del capítulo">
                    </div>
                    <div class="col col-auto">
                        <button type="button" class="btn btn-light-primary" id="saveCapituloBtn">Guardar <i class="fa fa-check-circle"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal para agregar clientes-->
<div class="modal fade" id="crearClienteModalEdit" tabindex="1" aria-labelledby="crearClienteModalEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <form id="createClientFormEdit" action="{{ route('cliente.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="context" value="form">
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
                        <div class="header-modal">
                            <h4>Pago</h4>
                        </div>
                        <div class="">
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
                    </div>
                    <div class="mt-3">Los campos <strong class="required"></strong> son requeridos.</div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-light-primary mt-3">Guardar <i class="fas fa-check-circle"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    //console.log(productosArrastrados);
    actualizarListaProductos();
});

let nextCapituloId = 1;

function generarIdCapitulo() {
    const maxCapituloId = productosArrastrados.reduce((maxId, producto) => {
        if (producto.tipo === 'capitulo' && producto.capitulo_id !== null) {
            return Math.max(maxId, producto.capitulo_id);
        }
        return maxId;
    }, 0);

    return maxCapituloId + 1;
}


let productosArrastrados = {!! json_encode($productosArrastrados) !!};

function limpiarProductos() {
    localStorage.removeItem('productosArrastrados');
}

function allowDrop(event) {
    event.preventDefault();
}

function drag(event) {
    event.dataTransfer.setData("text", event.target.id);
}

function drop(event) {
    if (window.drop_function != undefined && window.drop_function === 2) {
        //console.log("CAMBIANDO A DROP2");
        drop2(event);
        return;
    }
    //console.log("DEV: DROP-EVENT 1");
    event.preventDefault();
    const data = event.dataTransfer.getData("text");
    const draggedElement = document.getElementById(data);
    const productoId = parseInt(draggedElement.querySelector('.producto-id').textContent);
    const productoNombre = draggedElement.querySelector('.producto-nombre').textContent;
    const productoPrecio = parseFloat(draggedElement.querySelector('.producto-precio').textContent);
    const productoStock = parseInt(draggedElement.querySelector('.producto-stock').textContent);

    const productoExistente = productosArrastrados.find(producto => producto.id === productoId);
    if (!productoExistente) {
        productosArrastrados.push({
            id: productoId,
            nombre: productoNombre,
            precio: productoPrecio,
            stock: productoStock,
            cantidad: 1,
            orden: productosArrastrados.length + 1,
            tipo: '',
            titulo: '',
            descripcion: ''
        });

        actualizarListaProductos();
    } else {
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
            title: "Ya agregaste este producto"
        });
    }
}

function drop2(event) {
    window.drop_function = 1;
    //console.log("DEV: DROP-EVENT 2");
    event.preventDefault();

    const x = event.clientX;
    const y = event.clientY;

    const elementoDebajoDelRaton = document.elementFromPoint(x, y);
    const fila_destino = $(elementoDebajoDelRaton).closest("tr");

    if (fila_destino.length && !fila_destino.is(window.fila_original)) {
        const posicionOriginal = window.fila_original.index();
        const posicionDestino = fila_destino.index();

        //console.log('Posición original:', posicionOriginal);
        //console.log('Posición destino:', posicionDestino);

        if (posicionOriginal < posicionDestino) {
            fila_destino.after(window.fila_original);
        } else {
            fila_destino.before(window.fila_original);
        }

        //console.log('Elemento debajo del ratón:', $(elementoDebajoDelRaton));
        //console.log('Fila destino:', fila_destino);

    } else {
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
            icon: "warning",
            title: "No se puede soltar la fila sobre sí misma."
        });
    }

    actualizarOrdenProductos();
    actualizarListaProductos();
}

$('#agregarCap').on('click', function() {
    $('#capituloModal').modal('show');
});

$('#saveCapituloBtn').on('click', function() {
    guardarCapitulo();
});

// Agregar capítulo al presionar Enter, 13 siendo el código de la tecla
$('#capituloTitulo').on('keypress', function(e) {
    if (e.which === 13) {
        guardarCapitulo();
    }
});

function guardarCapitulo() {
    const tituloCapitulo = $('#capituloTitulo').val().trim();

    if (tituloCapitulo === '') {
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
            icon: "warning",
            title: "El título del capítulo no puede estar vacío."
        });
        return;
    }

    const nuevoCapitulo = {
        capitulo_id: generarIdCapitulo(),
        titulo: tituloCapitulo,
        tipo: 'capitulo',
        orden: productosArrastrados.length + 1,
        descripcion: ''
    };

    productosArrastrados.push(nuevoCapitulo);
    actualizarListaProductos();

    $('#capituloModal').modal('hide');
    $('#capituloTitulo').val('');
}

function actualizarListaProductos() {

    const tableBody = $('#productos-table-body');
    tableBody.empty();

    productosArrastrados.forEach((producto, index) => {
        //console.log('Producto:', producto);

        const tr = $('<tr></tr>');
        if (producto.tipo != 'linea') {
            tr.attr('data-capitulo-id', producto.capitulo_id || '');
        }else{
            tr.attr('data-producto-id', producto.id || '');
        }

        tr.addClass('item');
        tr.attr('draggable', true);

        if (producto.tipo === 'capitulo') {
            const tdTitulo = $('<td class="align-middle" colspan="2"></td>');
            tdTitulo.text(producto.titulo);
            const tdDescripcion = $('<td class="align-middle" colspan="3"></td>');
            const descripcionInput = $('<textarea class="form-control"></textarea>');
            descripcionInput.attr('name', `descripcion_capitulo_${index + 1}`);
            descripcionInput.val(producto.descripcion || '');
            descripcionInput.on('change', function() {
                //console.log("CP1", descripcionInput);
                //console.log(producto);
                producto.descripcion = $(this).val();
                document.getElementById("lista_productos").value = JSON.stringify(productosArrastrados);
            });
            tdDescripcion.append(descripcionInput);

            const tdAcciones = $('<td class="align-middle"></td>');
            const eliminarBtn = $('<button></button>');
            eliminarBtn.attr('type', 'button');
            eliminarBtn.addClass('btn btn-danger btn-sm');
            eliminarBtn.html('<i class="fa-solid fa-trash"></i>');
            eliminarBtn.on('click', function() {
                tr.remove();
                productosArrastrados = productosArrastrados.filter(p => p.capitulo_id !== producto.capitulo_id);
                actualizarOrdenProductos();
            });
            tdAcciones.append(eliminarBtn);

            const idInput = $('<input>');
            idInput.attr({
                type: 'hidden',
                class: 'id-capitulo',
                name: `capitulo_id_${index + 1}`,
                value: producto.capitulo_id
            });

            const ordenInput = $('<input>');
            ordenInput.attr({
                type: 'hidden',
                class: 'orden-producto',
                name: `orden_producto_${index + 1}`,
                value: producto.orden
            });

            const tipoInput = $('<input>');
            tipoInput.attr({
                type: 'hidden',
                class: 'tipo-producto',
                name: `tipo_producto_${index + 1}`,
                value: producto.tipo
            });

            tr.append(tdTitulo, tdDescripcion, tdAcciones, idInput, ordenInput, tipoInput);
        } else {
            // Aquí va el código para productos (no capítulos)
            const tdNombre = $('<td class="align-middle"></td>');
            tdNombre.text(producto.nombre);

            const tdDescripcion = $('<td class="align-middle"></td>');
            const descripcionInput = $('<textarea class="form-control"></textarea>');

            descripcionInput.attr('name', `descripcion_capitulo_${index + 1}`);
            descripcionInput.val(producto.descripcion || '');

            descripcionInput.on('change', function() {
                //console.log("CP1", descripcionInput);
                //console.log(producto);
                producto.descripcion = $(this).val();
                document.getElementById("lista_productos").value = JSON.stringify(productosArrastrados);
            });

            tdDescripcion.append(descripcionInput);

            const tdCantidad = $('<td class="align-middle"></td>');
            const cantidadInput = $('<input>');
            cantidadInput.attr({
                type: 'number',
                value: producto.cantidad,
                min: 1,
                max: producto.stock
            });
            cantidadInput.addClass('cantidad-producto form-control');
            cantidadInput.on('change', function() {
                const cantidad = parseInt($(this).val());
                producto.cantidad = cantidad;
                tdPrecioTotal.text((cantidad * producto.precio).toFixed(2) + '€');
                actualizarPrecioTotal();
            });
            tdCantidad.append(cantidadInput);

            const tdPrecio = $('<td class="align-middle"></td>');
            const precioInput = $('<input>');
            precioInput.attr({
                type: 'number',
                value: producto.precio.toFixed(2),
                min: 0,
                step: 0.01
            });
            precioInput.addClass('input-precio-producto form-control');
            precioInput.on('change', function() {
                const precio = parseFloat($(this).val());
                producto.precio = precio;
                tdPrecioTotal.text((producto.cantidad * precio).toFixed(2) + '€');
                actualizarPrecioTotal();
            });
            tdPrecio.append(precioInput);

            const tdPrecioTotal = $('<td class="align-middle"></td>');
            tdPrecioTotal.addClass('precio-total-producto text-center');
            tdPrecioTotal.text((producto.cantidad * producto.precio).toFixed(2) + '€');

            const tdAcciones = $('<td class="align-middle"></td>');
            const eliminarBtn = $('<button></button>');
            eliminarBtn.attr('type', 'button');
            eliminarBtn.addClass('btn btn-danger btn-sm');
            eliminarBtn.html('<i class="fa-solid fa-trash"></i>');
            eliminarBtn.on('click', function() {
                tr.remove();
                productosArrastrados = productosArrastrados.filter(p => p.id !== producto.id);
                actualizarOrdenProductos();
                actualizarPrecioTotal();
            });
            tdAcciones.append(eliminarBtn);

            const ordenInput = $('<input>');
            ordenInput.attr({
                type: 'hidden',
                class: 'orden-producto',
                name: `orden_producto_${index + 1}`,
                value: index + 1
            });

            const tipoInput = $('<input>');
            tipoInput.attr({
                type: 'hidden',
                class: 'tipo-producto',
                name: `tipo_producto_${index + 1}`,
                value: producto.tipo
            });

            tr.append(tdNombre, tdDescripcion, tdCantidad, tdPrecio, tdPrecioTotal, tdAcciones, ordenInput, tipoInput);
        }

        tableBody.append(tr);

        tr.on('dragstart', function(e) {
            $(this).addClass('dragging');
            window.fila_original = tr;
            window.drop_function = 2;
            e.originalEvent.dataTransfer.setData('text/plain', producto.id);
        });

        tr.on('dragend', function() {
            $(this).removeClass('dragging');
            actualizarOrdenProductos();
        });
    });

    actualizarPrecioTotal();
}

function actualizarOrdenProductos() {
    $('#productos-table-body tr').each(function(index) {
        const productoId = $(this).data('producto-id') || null;
        const capituloId = $(this).data('capitulo-id') || $(this).find('.id-capitulo').val() || null;
        const productoTipo = $(this).find('.tipo-producto').val();

        //console.log(`Procesando fila con: productoId=${productoId}, capituloId=${capituloId}, tipo=${productoTipo}`);

        let producto = null;

        if (productoTipo === 'capitulo') {
            producto = productosArrastrados.find(p => p.capitulo_id == capituloId && p.tipo === 'capitulo');
        } else if (productoId !== null) {
            producto = productosArrastrados.find(p => p.id == productoId && p.tipo === productoTipo);
        } else {
            producto = productosArrastrados.find(p => p.capitulo_id == capituloId && p.tipo === productoTipo);
        }

        if (producto) {
            producto.orden = index + 1;  // Actualiza el orden en el objeto
            $(this).find('.orden-producto').val(producto.orden);  // Reflejar en el DOM
        } else {
            //console.log(`No se encontró producto o capítulo en la lista con tipo: ${productoTipo}, ID: ${productoId}, capitulo_id: ${capituloId}`);
        }
    });

    // Reordenar array de productos por su nuevo orden
    productosArrastrados.sort((a, b) => a.orden - b.orden);

    // Actualizar el campo oculto con el nuevo orden
    document.getElementById("lista_productos").value = JSON.stringify(productosArrastrados);
}


// Función para actualizar el precio total
function actualizarPrecioTotal() {
    let total = 0;
    productosArrastrados.forEach(producto => {
        if (producto.tipo !== 'capitulo') {
            total += producto.precio * producto.cantidad;
        }
    });

    document.getElementById("precio_total_display").textContent = total.toFixed(2) + '€';
    document.getElementById("precio_total_input").value = total.toFixed(2);
    document.getElementById("lista_productos").value = JSON.stringify(productosArrastrados);
}

// Evento para limpiar la tabla
document.getElementById("limpiarCanvas").addEventListener("click", function() {
    const tableBody = document.getElementById("productos-table-body");
    tableBody.innerHTML = "";
    productosArrastrados = [];
    actualizarPrecioTotal();
});

// Función para agregar un producto a la lista
function agregarProducto(productoId) {
    const productoElement = document.querySelector(`#producto-${productoId}`);

    if (!productoElement) {
        console.error('Producto no encontrado.');
        return;
    }

    const productoNombre = productoElement.querySelector('.producto-nombre').textContent;
    const productoPrecio = parseFloat(productoElement.querySelector('.producto-precio').textContent);
    const productoStock = parseInt(productoElement.querySelector('.producto-stock').textContent);

    const productoExistente = productosArrastrados.find(producto => producto.id === productoId);
    if (productoExistente) {
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
            title: "Ya agregaste este producto"
        });
    } else {
        productosArrastrados.push({
            id: productoId,
            nombre: productoNombre,
            precio: productoPrecio,
            stock: productoStock,
            orden: ordenInput,
            descripcion: descripcionInput,
            cantidad: 1
        });
    }
    actualizarListaProductos();
}

$(document).ready(function() {
    function cargarProductos(params = {}) {
        const url = params.url || '{{ route('presupuesto.getProductos') }}';
        const data = {
            search: $('#search-input').val(),
            order: $('#order-input').val(),
            precio_order: $('#precio_order-input').val(),
            sort_by: $('#sort_by-input').val(),
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: url,
            method: 'GET',
            data: data,
            success: function(response) {
                $('#productos-content').html(response.html);
            },
            error: function(xhr, status, error) {
                alert('Error al cargar los productos.');
                console.error(error);
            }
        });
    }

    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        cargarProductos();
    });

    $('#search-button').on('click', function() {
        cargarProductos();
    });

    $('#orderButton').on('click', function() {
        const currentOrder = $('#order-input').val();
        const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
        $('#order-input').val(newOrder);
        $('#sort_by-input').val('nombre');
        cargarProductos();
    });

    $('#precioButton').on('click', function() {
        const currentPrecioOrder = $('#precio_order-input').val();
        const newPrecioOrder = currentPrecioOrder === 'asc' ? 'desc' : 'asc';
        $('#precio_order-input').val(newPrecioOrder);
        $('#sort_by-input').val('precio');
        cargarProductos();
    });

    $('#productos-container').on('click', '.pagination a', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        cargarProductos({ url: url });
    });

    cargarProductos();

    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();

        const pageUrl = $(this).attr('href');
        cargarProductos({ url: pageUrl });
    });
});

$(document).ready(function() {
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

    // Datos del cliente original
    const originalCliente = {
        id: $('#cliente_id').val(),
        nombre: $('#cliente_nombre').text(),
        contacto: $('#cliente_contacto').text(),
        pago: $('#cliente_pago').text()
    };

    $('#createClientFormEdit').submit(function(e) {
        e.preventDefault();

        let formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: formData,
            success: function(response) {
                $('#crearClienteModalEdit').modal('hide');

                $('#cliente_id').val(response.id);
                $('#cliente_nombre').html(`${response.nombre} ${response.apellido}`);
                $('#cliente_contacto').html(response.contacto || 'No registrado');
                $('#cliente_pago').html(response.pago || 'No registrado');
                $('#cliente_nombre_proyecto').html(response.nombre);

                Toast.fire({
                    icon: "success",
                    title: "Cliente creado exitosamente.",
                    timer: 3000
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
                Toast.fire({
                    icon: "error",
                    title: "Error al crear el cliente. Inténtalo de nuevo.",
                    timer: 4000
                });
            }
        });
    });

    function initializeSelect2Edit() {
        $('#clienteSelectEdit').select2({
            placeholder: 'Seleccionar cliente',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return 'No se encontraron clientes con ese nombre';
                }
            }
        }).on('change', function() {
            const clienteId = $(this).val();

            if (clienteId && clienteId !== originalCliente.id) { // Verificar si el cliente ha cambiado
                $.ajax({
                    url: '{{ route("clientes.data") }}',
                    method: 'GET',
                    success: function(data) {
                        // Encontrar el cliente seleccionado
                        const cliente = data.find(c => c.id == clienteId);

                        if (cliente) {
                            $('#cliente_id').val(cliente.id);
                            $('#cliente_nombre').html(`${cliente.text}`);
                            $('#cliente_contacto').html(cliente.contacto || 'No registrado');
                            $('#cliente_pago').html(cliente.pago || 'No registrado');
                            $('#cliente_nombre_proyecto').html(cliente.text);
                        }
                    },
                    error: function(error) {
                        console.error('Error al obtener los detalles del cliente:', error);
                    }
                });
            } else {
                // Restablecer los datos al cliente original si no se selecciona uno nuevo
                $('#cliente_id').val(originalCliente.id);
                $('#cliente_nombre').html(originalCliente.nombre);
                $('#cliente_contacto').html(originalCliente.contacto);
                $('#cliente_pago').html(originalCliente.pago);
                $('#cliente_nombre_proyecto').html(originalCliente.nombre);
            }
        });
    }

    initializeSelect2Edit();

    $.ajax({
        url: '{{ route("clientes.data") }}',
        method: 'GET',
        success: function(data) {
            $('#clienteSelectEdit').empty().append(
                $.map(data, function(cliente) {
                    return new Option(cliente.text, cliente.id, false, false);
                })
            ).val('{{ $presupuesto->cliente->id }}').trigger('change'); // Seleccionar cliente actual
        },
        error: function(error) {
            console.error('Error al cargar los clientes:', error);
        }
    });
});

</script>
@endpush
</x-default-layout>
