<x-default-layout>
    @section('title')
        Crear presupuesto
    @endsection

<div class="container mt-3">
    <div class="row">
        <div class="col-md-4">
            <div class="row align-items-center mb-3">
                <div class="col">
                    <h3 class="mb-0">Productos</h3>
                </div>
                <div class="col text-end">
                    <button type="button" class="btn btn-light-primary" data-bs-toggle="modal" data-bs-target="#crearProductoModal">
                        Nuevo producto <i class="fas fa-plus-circle"></i>
                    </button>
                </div>
            </div>

            <div class="modal fade" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <form action="{{ route('producto.store') }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="crearProductoModalLabel">Nuevo producto</h5>
                                </div>
                                <div class="mb-3">
                                    <label for="nombre">Nombre del Producto</label> <strong class="required"></strong>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="precio">Precio</label> <strong class="required"></strong>
                                    <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01" required>
                                </div>
                                <div class="mb-3">
                                    <label for="leyenda">Leyenda</label>
                                    <textarea class="form-control" id="leyenda" name="leyenda" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="stock">Stock</label> <strong class="required"></strong>
                                    <input type="number" class="form-control" id="stock" name="stock" min="0" required>
                                </div>
                                <input type="hidden" id="tipo" name="tipo" value="linea" required>

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
                    <input type="text" name="search" id="search-input" class="form-control" placeholder="Buscar productos..." value="{{ request('search') }}" style="border-radius:5px;">
                    <div class="input-group-append">
                    <button class="btn btn-light-primary mx-3" id="search-button" type="button" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Buscar producto por nombre">
                        <i class="fas fa-search"></i>
                    </button>
                    </div>

                    <input type="hidden" name="sort_by" id="sort_by-input" value="{{ $sort_by ?? 'nombre' }}">

                    <input type="hidden" name="order" id="order-input" value="{{ $order ?? 'asc' }}">
                    <button type="button" id="orderButton" class="nav-link ms-2 d-flex align-items-center mx-3" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Ordenar productos por nombre">
                        <i class="fa-solid fa-up-down"></i>
                    </button>

                    <input type="hidden" name="precio_order" id="precio_order-input" value="{{ $precio_order ?? 'asc' }}">
                    <button type="button" id="precioButton" class="nav-link ms-2 d-flex align-items-center" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Ordenar productos por precio">
                        <i class="fa-solid fa-euro-sign"></i>
                    </button>
                </div>
            </form>
            <div id="productos-content">
            </div>

        </div>

        <div class="col-md-8">
            <form id="presupuesto-form" method="POST" class="mb-3">
                @csrf

                <h3>Crear proyecto</h3>

                <div class="col">
                    <hr />
                    <p class="mb-0">Datos del cliente</p>
                    <div class="col form-group">

                        Cliente: <strong>{{$cliente->nombre}} {{$cliente->apellido}}</strong>
                        <input type="hidden" value="{{$cliente->id}}" id="cliente_id" name="cliente_id">
                    </div>

                    <div class="col form-group">

                        Contacto: <strong>{{$cliente->contacto ?: "No registrado" }}</strong>
                        Forma de pago de cliente: <strong>{{$cliente->pago ?: "No registrado"}}</strong>

                    </div>
                </div>

                <div class="col">
                    <hr />
                    <p class="mb-0">Info del proyecto</p>

                    <div class="row">
                        <div class="col">
                            <input class="form-control" type="text" name="serie_ref" placeholder="Nombre del proyecto / serie de referencia">
                        </div>

                        <div class="col">
                            <input class="form-control" type="text" name="num_ref" placeholder="Número de referencia">
                        </div>
                    </div>

                    <div>
                        <label for="pago">Forma de pago</label>
                            <select class="form-select" id="pago" name="pago">
                                <option value="Ver condiciones" {{ $cliente->pago == 'Ver condiciones' ? 'selected' : '' }}>Ver condiciones</option>
                                <option value="50% inicio, 50% fin" {{ $cliente->pago == '50% inicio, 50% fin' ? 'selected' : '' }}>50% inicio, 50% fin</option>
                                <option value="50% termino de obra, resto a 90 dias" {{ $cliente->pago == '50% termino de obra, resto a 90 días' ? 'selected' : '' }}>50% termino de obra, resto a 90 días</option>
                                <option value="50% comienzo de obra, resto a convenir" {{ $cliente->pago == '50% comienzo de obra, resto a convenir' ? 'selected' : '' }}>50% comienzo de obra, resto a convenir</option>
                                <option value="Certificaciones quincenales" {{ $cliente->pago == 'Certificaciones quincenales' ? 'selected' : '' }}>Certificaciones quincenales</option>
                                <option value="Como siempre" {{ $cliente->pago == 'Como siempre' ? 'selected' : '' }}>Como siempre</option>
                                <option value="Contado termino de obra" {{ $cliente->pago == 'Contado termino de obra' ? 'selected' : '' }}>Contado termino de obra</option>
                                <option value="Convenir" {{ $cliente->pago == 'Convenir' ? 'selected' : '' }}>Convenir</option>
                                <option value="Fin de ejercicio, 15 de diciembre" {{ $cliente->pago == 'Fin de ejercicio, 15 de diciembre' ? 'selected' : '' }}>Fin de ejercicio, 15 de diciembre</option>
                                <option value="Letra de 90 dias" {{ $cliente->pago == 'Letra de 90 días' ? 'selected' : '' }}>Letra de 90 días</option>
                                <option value="Letra a la vista" {{ $cliente->pago == 'Letra a la vista' ? 'selected' : '' }}>Letra a la vista</option>
                            </select>
                    </div>
                    <hr />
                </div>

                <p>Arrastra aquí los productos para agregarlos al presupuesto.</p>
                <div id="canvas" class="border p-2" style="min-height: 500px; overflow-y: auto;" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div id="lista-presupuesto" class="table-responsive">
                        <table  class="table table-light text-center table-hover rounded-table">
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

                <label for="total">Precio total:</label>

                <h3 id="precio_total_display">0.00</h3>

                <input type="hidden" id="precio_total_input" name="precio_total" value="0.00">
                <input type="hidden" id="lista_productos" name="lista_productos" value="">

                <div class="row mb-3">
                    <div class="col col-auto me-auto">
                        <div class="btn-container d-flex gap-2">
                            <button type="submit" class="btn btn-light-primary">
                                Guardar presupuesto <i class="fas fa-check-circle"></i>
                            </button>
                            <button id="agregarCap" type="button" class="btn btn-light-success">
                                Agregar capítulo <i class="fas fa-plus-circle"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col col-auto">
                        <button type="button" class="btn btn-light-danger" id="limpiarCanvas" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Quitar todos los productos de la lista.">
                            Quitar todos <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

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

@push('scripts')
<script>
let productosArrastrados = [];

let nextCapituloId = 1;

function generarIdCapitulo() {
    return nextCapituloId++;
}

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
    if (window.drop_function !== undefined && window.drop_function === 2) {
        drop2(event);
        return;
    }

    //console.log("DEV: DROP-EVENT 1");
    event.preventDefault();

    const data = event.dataTransfer.getData("text");
    const draggedElement = document.getElementById(data);

    if (!draggedElement) {
        console.error("Elemento arrastrado no encontrado.");
        return;
    }

    // Obtener los elementos del producto
    const productoIdElem = draggedElement.querySelector('.producto-id');
    const productoNombreElem = draggedElement.querySelector('.producto-nombre');
    const productoPrecioElem = draggedElement.querySelector('.producto-precio');
    const productoStockElem = draggedElement.querySelector('.producto-stock');
    const productoTipoElem = draggedElement.querySelector('.producto-tipo');

    if (!productoIdElem || !productoNombreElem || !productoPrecioElem || !productoStockElem || !productoTipoElem) {
        console.error("Algunos elementos del producto no se encontraron.");
        console.log("ID Element:", productoIdElem);
        console.log("Nombre Element:", productoNombreElem);
        console.log("Precio Element:", productoPrecioElem);
        console.log("Stock Element:", productoStockElem);
        console.log("Tipo Element:", productoTipoElem);
        return;
    }

    const productoId = parseInt(productoIdElem.textContent.trim());
    const productoNombre = productoNombreElem.textContent.trim();
    const productoPrecio = parseFloat(productoPrecioElem.textContent.trim());
    const productoStock = parseInt(productoStockElem.textContent.trim());
    const productoTipo = productoTipoElem.textContent.trim();

    if (!productoTipo) {
        console.error("Tipo del producto es null o vacío.");
    }

    const productoExistente = productosArrastrados.find(producto => producto.id === productoId);
    if (!productoExistente) {
        productosArrastrados.push({
            id: productoId,
            nombre: productoNombre,
            precio: productoPrecio,
            stock: productoStock,
            orden: productosArrastrados.length + 1,
            descripcion: '',
            cantidad: 1,
            tipo: productoTipo
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
    console.log("DEV: DROP-EVENT 2");
    event.preventDefault();

    const x = event.clientX;
    const y = event.clientY;

    const elementoDebajoDelRaton = document.elementFromPoint(x, y);
    const fila_destino = $(elementoDebajoDelRaton).closest("tr");

    if (fila_destino.length && !fila_destino.is(window.fila_original)) {
        const posicionOriginal = window.fila_original.index();
        const posicionDestino = fila_destino.index();

        console.log('Posición original:', posicionOriginal);
        console.log('Posición destino:', posicionDestino);

        if (posicionOriginal < posicionDestino) {
            fila_destino.after(window.fila_original);
        } else {
            fila_destino.before(window.fila_original);
        }

        const productoId = window.fila_original.data('producto-id') || null;
        const capituloId = window.fila_original.data('capitulo-id') || window.fila_original.find('.id-capitulo').val() || null;
        const productoTipo = window.fila_original.find('.tipo-producto').val();

        let producto = null;

        if (productoTipo === 'capitulo') {
            producto = productosArrastrados.find(p => p.tipo === 'capitulo' && p.capitulo_id == capituloId);
        } else {
            producto = productosArrastrados.find(p => p.id == productoId && p.tipo === productoTipo);
        }

        if (producto) {
            productosArrastrados = productosArrastrados.filter(p =>
                (p.id !== productoId && p.capitulo_id !== capituloId)
            );

            productosArrastrados.splice(posicionDestino, 0, producto);
        } else {
            console.log(`No se encontró el producto o capítulo con ID: ${productoId}, capitulo_id: ${capituloId}`);
        }

        // Actualizar el orden de los productos y capítulos
        actualizarOrdenProductos();
    } else {
        console.log("No se puede soltar la fila sobre sí misma.");
    }
}

//Para agregar capítulos
$('#agregarCap').on('click', function() {
    $('#capituloModal').modal('show');
});

$('#saveCapituloBtn').on('click', function() {
    const tituloCapitulo = $('#capituloTitulo').val().trim();

    if (tituloCapitulo === '') {
        alert('El título del capítulo no puede estar vacío.');
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
});

function actualizarListaProductos() {
    console.log("FUN: actualizarListaProductos");

    const tableBody = $('#productos-table-body');
    tableBody.empty();

    productosArrastrados.forEach((producto, index) => {
        console.log('Producto:', producto);

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
                console.log("CP1", descripcionInput);
                console.log(producto);
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
                console.log("CP1", descripcionInput);
                console.log(producto);
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
        // Leer los valores de cada fila
        const productoId = $(this).data('producto-id') || null;
        const capituloId = $(this).data('capitulo-id') || $(this).find('.id-capitulo').val() || null;
        const productoTipo = $(this).find('.tipo-producto').val();

        console.log(`Procesando fila con: productoId=${productoId}, capituloId=${capituloId}, tipo=${productoTipo}`);

        let producto = null;

        // Actualizar el producto o capítulo según su tipo
        if (productoTipo === 'capitulo') {
            producto = productosArrastrados.find(p => p.tipo === 'capitulo' && p.capitulo_id == capituloId);
        } else {
            producto = productosArrastrados.find(p => p.id == productoId && p.tipo === productoTipo);
        }

        // Actualizar el orden si se encontró el producto o capítulo
        if (producto) {
            producto.orden = index + 1;  // Actualizar el orden en el array
            $(this).find('.orden-producto').val(producto.orden);
        } else {
            console.log(`No se encontró producto o capítulo en la lista con tipo: ${productoTipo}, ID: ${productoId}, capitulo_id: ${capituloId}`);
        }
    });

    // Ordenar el array `productosArrastrados` por el nuevo orden
    productosArrastrados.sort((a, b) => a.orden - b.orden);

    // Actualizar el valor del campo oculto
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
        //console.log("reooksfjdescrip");
    }
    actualizarListaProductos();
}


document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('presupuesto-form');
    const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                })

    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Evita el envío tradicional del formulario

        // Obtener los valores del formulario
        const listaProductosInput = document.getElementById('lista_productos');
        const listaProductos = JSON.parse(listaProductosInput.value || '[]');

        // Verificar si el array de productos está vacío
        if (listaProductos.length === 0) {

            Toast.fire({
                icon: 'error',
                title: 'Error',
                text: 'El presupuesto debe contener al menos un producto.'
            });
            return; // Detiene la ejecución si el array está vacío
        }

        var formData = new FormData(this);

        $.ajax({
            url: '{{ route('presupuesto.store') }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {

                if (data.success) {
                    localStorage.setItem('successMessage', data.message || 'Proyecto presupuestado correctamente.');
                    window.location.href = '{{ route('proyecto.index') }}';

                } else {
                    Toast.fire({
                        icon: 'error',
                        title: data.message || 'Hubo un problema al crear el presupuesto.'
                    });
                    if (data.errors) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Object.values(data.errors).forEach(errorMessages => {
                            errorMessages.forEach(errorMessage => {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: errorMessage
                                });
                            });
                        });
                    }
                }
            },
            error: function(xhr) {

                console.error('Error:', xhr);
                Toast.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al procesar la solicitud.'
                });
            }
        });
    });
});


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

    // Prevenir comportamiento por defecto del formulario
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        cargarProductos();
    });

    // Manejar clic en botón de búsqueda
    $('#search-button').on('click', function() {
        cargarProductos();
    });

    // Manejar clic en botón de ordenar por nombre
    $('#orderButton').on('click', function() {
        const currentOrder = $('#order-input').val();
        const newOrder = currentOrder === 'asc' ? 'desc' : 'asc';
        $('#order-input').val(newOrder);
        $('#sort_by-input').val('nombre');
        cargarProductos();
    });

    // Manejar clic en botón de ordenar por precio
    $('#precioButton').on('click', function() {
        const currentPrecioOrder = $('#precio_order-input').val();
        const newPrecioOrder = currentPrecioOrder === 'asc' ? 'desc' : 'asc';
        $('#precio_order-input').val(newPrecioOrder);
        $('#sort_by-input').val('precio');
        cargarProductos();
    });

    // Función para cargar productos al hacer clic en la paginación
    $('#productos-container').on('click', '.pagination a', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        cargarProductos({ url: url });
    });

    cargarProductos();

    // Manejar el clic en los enlaces de paginación
    $(document).on('click', '.pagination a', function(event) {
        event.preventDefault();

        const pageUrl = $(this).attr('href');
        cargarProductos({ url: pageUrl });
    });
});
</script>
@endpush
</x-default-layout>
